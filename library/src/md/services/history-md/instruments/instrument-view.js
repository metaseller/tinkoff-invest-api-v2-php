import React, { useCallback, useMemo, useState, useEffect } from 'react';
import { DataTable } from '../../../../src/components/DataTable';
import { DataTableSkeleton } from '../../../../src/components/DataTableSkeleton';
import { Pagination } from '@platform-ui/dataTable';
import { ButtonDesktop as Button } from '@tui-react/button';
import { CheckboxDesktop as Checkbox } from '@tui-react/checkbox';
import { TuiIconTdsMediumDocArrowDown } from '@tui-react/proprietary-icons';

import { ExampleCodeView } from '../code-example';
import { fetchInstrumentIndex, SERVER_URL } from '../trades-index-loader';
import styles from '../styles.module.scss';

export const InstrumentView = ({ tickerClassCode, name, onBack }) => {
    const [model, setModel] = useState({
        loading: true,
        error: null,
        trades: [],
        page: 1,
        pageSize: 10,
        selectedArchives: {},
    });

    const detailKeyFn = (trade) => trade.uri;

    const detailTradesPaged = useMemo(() => {
        const start = (model.page - 1) * model.pageSize;
        const end = start + model.pageSize;
        return model.trades.slice(start, end);
    }, [model.trades, model.page, model.pageSize]);

    const allSelection = useMemo(() => {
        if (!detailTradesPaged.length) return false;
        return detailTradesPaged.every((t) => model.selectedArchives[detailKeyFn(t)]);
    }, [detailTradesPaged, model.selectedArchives]);

    const indeterminate = useMemo(() => {
        const selectedCount = detailTradesPaged.filter((t) => model.selectedArchives[detailKeyFn(t)]).length;
        return selectedCount > 0 && selectedCount < detailTradesPaged.length;
    }, [detailTradesPaged, model.selectedArchives]);

    const onToggleSelectAll = (e) => {
        const checked = e.target.checked;
        const newSelected = { ...model.selectedArchives };
        detailTradesPaged.forEach((t) => {
            const key = detailKeyFn(t);
            if (checked) {
                newSelected[key] = {
                    ...t,
                    key: tickerClassCode
                };
            } else {
                delete newSelected[key];
            }
        });
        setModel((m) => ({ ...m, selectedArchives: newSelected }));
    };

    const onToggleSelect = (e) => {
        const name = e.target.name;
        const checked = e.target.checked;
        setModel((m) => {
            const newSelected = { ...m.selectedArchives };
            if (checked) {
                const trade = m.trades.find((t) => detailKeyFn(t) === name);
                if (trade) {
                    newSelected[name] = {
                        ...trade,
                        key: tickerClassCode
                    };
                }
            } else {
                delete newSelected[name];
            }
            return { ...m, selectedArchives: newSelected };
        });
    };

    const onChangePage = useCallback((_, { page }) => {
        const newPage = Number(page);
        if (!isNaN(newPage) && newPage >= 0) {
            setModel((m) => ({ ...m, page: newPage + 1, selectedArchives: {} }));
        }
    }, []);

    const onChangeRowsPerPage = useCallback((_, { rowsPerPage }) => {
        const size = Number(rowsPerPage);
        if (!isNaN(size) && size > 0) {
            setModel((m) => ({ ...m, pageSize: size, page: 1, selectedArchives: {} }));
        }
    }, []);

    useEffect(() => {
        setModel((m) => ({ ...m, loading: true, error: null }));

        fetchInstrumentIndex(tickerClassCode)
            .then((trades) => {
                setModel((m) => ({
                    ...m,
                    loading: false,
                    trades: trades || [],
                }));
            })
            .catch((err) => {
                setModel((m) => ({ ...m, loading: false, error: err.message }));
            });
    }, [tickerClassCode]);

    return (
        <div className={styles.wrapper}>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                <div>
                    <h4>{name}</h4>
                    <h5>{tickerClassCode}</h5>
                </div>
                <Button size="s" onClick={onBack}>
                    Назад к списку инструментов
                </Button>
            </div>

            {model.loading && (
                <DataTableSkeleton
                    headers={[<Checkbox size="s" key="select-all" />, 'Архив', 'Ссылка для загрузки']}
                    rows={model.pageSize}
                    headerRowHeight={50}
                    contentRowHeight={61}
                />
            )}

            {model.error && <p style={{ color: 'red' }}>{model.error}</p>}

            {!model.loading && !model.error && (
                <div>
                    <DataTable
                        heading={[
                            <Checkbox
                                key="select-all"
                                size="s"
                                indeterminate={indeterminate}
                                checked={allSelection}
                                onChange={onToggleSelectAll}
                            />,
                            'Архив',
                            'Ссылка для загрузки',
                        ]}
                        body={detailTradesPaged.map((trade) => [
                            <Checkbox
                                key={trade.uri + '-checkbox'}
                                size="s"
                                name={trade.uri}
                                checked={!!model.selectedArchives[trade.uri]}
                                onChange={onToggleSelect}
                            />,
                            trade.date,
                            <Button
                                key={trade.uri + '-button'}
                                size="xs"
                                href={`${SERVER_URL}/history-trades${trade.uri}`}
                                download
                                iconLeft={<TuiIconTdsMediumDocArrowDown />}
                                appearance="flat-grayscale-on-dark"
                            >
                                {trade.sizeTxt}
                            </Button>,
                        ])}
                    />

                    <Pagination
                        page={model.page - 1}
                        rowsPerPage={model.pageSize}
                        itemsTotal={model.trades.length}
                        rowsPerPageOptions={[model.pageSize]}
                        onChangePage={onChangePage}
                        onChangeRowsPerPage={onChangeRowsPerPage}
                    />

                    <div>
                        <h3>Пример кода загрузки</h3>
                        <ExampleCodeView examples={Object.values(model.selectedArchives)} />
                    </div>
                </div>
            )}
        </div>
    );
};
