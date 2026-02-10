import React, { useEffect, useMemo, useState } from 'react';
import { DataTable } from '../../../../src/components/DataTable';
import { DataTableSkeleton } from '../../../../src/components/DataTableSkeleton';
import { Pagination } from '@platform-ui/dataTable';
import { ButtonDesktop as Button } from '@tui-react/button';
import { CheckboxDesktop as Checkbox } from '@tui-react/checkbox';
import { TuiIconTdsMediumDocArrowDown } from '@tui-react/proprietary-icons';

import { fetchTradesDaysIndex, SERVER_URL } from '../trades-index-loader';
import { usePagination } from '../pagination';
import { ExampleCodeView } from '../code-example';
import styles from '../styles.module.scss';

export const YearsView = ({ year }) => {
    const [currentTradesData, setCurrentTradesData] = useState([]);
    const [selectedArchives, setSelectedArchives] = useState({});
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    const {
        page,
        pageSize,
        model,
        onChangePage,
        onChangeRowsPerPage,
    } = usePagination(currentTradesData);

    useEffect(() => {
        setLoading(true);
        fetchTradesDaysIndex(year)
            .then((entries) => {
                setCurrentTradesData(entries);
                setLoading(false);
            })
            .catch((err) => {
                setError(err.message);
                setLoading(false);
            });
    }, [year]);

    useEffect(() => {
        setSelectedArchives({});
    }, [model]);

    const keyFn = (entry) => entry.uri;

    const allSelection = useMemo(() => {
        if (model.length === 0) return false;
        return model.every((entry) => selectedArchives[keyFn(entry)]);
    }, [model, selectedArchives]);

    const allSelectionIndeterminate = useMemo(() => {
        const selectedCount = model.filter((entry) => selectedArchives[keyFn(entry)]).length;
        return selectedCount > 0 && selectedCount < model.length;
    }, [model, selectedArchives]);

    const onToggleSelectAll = (event) => {
        const checked = event.target.checked;
        const newSelected = { ...selectedArchives };
        model.forEach((entry) => {
            if (checked) {
                newSelected[keyFn(entry)] = entry;
            } else {
                delete newSelected[keyFn(entry)];
            }
        });
        setSelectedArchives(newSelected);
    };

    const onToggleSelect = (event) => {
        const name = event.target.name;
        const checked = event.target.checked;
        setSelectedArchives((prev) => {
            const newSelected = { ...prev };
            if (checked) {
                newSelected[name] = currentTradesData.find((e) => keyFn(e) === name);
            } else {
                delete newSelected[name];
            }
            return newSelected;
        });
    };

    if (loading || error) return <DataTableSkeleton
        headers={[
            <Checkbox size="s" key="select-all" />,
            'Архив',
            'Ссылка для загрузки',
        ]}
        rows={pageSize}
        headerRowHeight={50}
        contentRowHeight={61}
    />;
    if (!currentTradesData.length) return <p>Нет данных</p>;

    const selectedUris = Object.values(selectedArchives);

    return (
        <div className={styles.wrapper}>
            <DataTable
                heading={[
                    <Checkbox
                        key="select-all"
                        size="s"
                        indeterminate={allSelectionIndeterminate}
                        checked={allSelection}
                        onChange={onToggleSelectAll}
                    />,
                    'Архив',
                    'Ссылка для загрузки',
                ]}
                body={model.map((tradeData) => [
                    <Checkbox
                        key={tradeData.uri + '-checkbox'}
                        size="s"
                        name={tradeData.uri}
                        checked={!!selectedArchives[tradeData.uri]}
                        onChange={onToggleSelect}
                    />,
                    tradeData.date,
                    <Button
                        key={tradeData.uri + '-button'}
                        size="xs"
                        href={`${SERVER_URL}/history-trades${tradeData.uri}`}
                        download
                        iconLeft={<TuiIconTdsMediumDocArrowDown />}
                        appearance="flat-grayscale-on-dark"
                    >
                        {tradeData.sizeTxt}
                    </Button>,
                ])}
            />
            <Pagination
                page={page - 1}
                rowsPerPage={pageSize}
                rowsPerPageOptions={[pageSize]}
                itemsTotal={currentTradesData.length}
                onChangePage={onChangePage}
                onChangeRowsPerPage={onChangeRowsPerPage}
            />

            <div>
                <h3>Пример кода загрузки</h3>
                <ExampleCodeView examples={selectedUris} />
            </div>
        </div>
    );
};
