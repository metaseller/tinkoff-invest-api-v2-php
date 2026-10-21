import React, { useState, useEffect, useMemo, useRef } from 'react';
import { DataTable } from '../../../../src/components/DataTable';
import { DataTableSkeleton } from '../../../../src/components/DataTableSkeleton';
import { Pagination } from '@platform-ui/dataTable';
import { ButtonDesktop as Button } from '@tui-react/button';
import { CheckboxDesktop as Checkbox } from '@tui-react/checkbox';
import { TooltipDesktop as Tooltip } from '@tui-react/tooltip';
import Input from '@platform-ui/input';
import { fetchAssetInstruments, fetchInstrumentIndex } from '../trades-index-loader';
import { usePagination } from '../pagination';
import { InstrumentView } from './instrument-view';
import { ExampleCodeView } from '../code-example';
import { MAX_LINES } from '../code-snippet';
import styles from "../styles.module.scss";

export const AssetView = ({ assetName, instrumentType, onBack }) => {
    const [instrumentsData, setInstrumentsData] = useState([]);
    const [selectedInstruments, setSelectedInstruments] = useState({});
    const [selectedArchivesMap, setSelectedArchivesMap] = useState(new Map());
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [filterTicker, setFilterTicker] = useState('');
    const [selectedInstrument, setSelectedInstrument] = useState(null);
    const [loadingInstruments, setLoadingInstruments] = useState(new Set());
    const [loadingAllInstruments, setLoadingAllInstruments] = useState(false);
    const currentArchivesCount = useRef(0);

    const selectedArchives = useMemo(() => {
        const archives = [];
        for (const archivesList of selectedArchivesMap.values()) {
            archives.push(...archivesList);
        }
        return archives;
    }, [selectedArchivesMap]);

    const totalSelectedArchivesCount = useMemo(() => selectedArchives.length, [selectedArchives]);

    useEffect(() => {
        currentArchivesCount.current = totalSelectedArchivesCount;
    }, [totalSelectedArchivesCount]);

    useEffect(() => {
        setLoading(true);
        fetchAssetInstruments(instrumentType, assetName)
            .then((data) => {
                const arr = Object.entries(data.instruments).map(([key, val]) => ({
                    id: key,
                    ticker: val.ticker,
                    classCode: val.classCode,
                    count: val.count,
                    name: val.name,
                }));
                setInstrumentsData(arr);
                setLoading(false);
            })
            .catch((err) => {
                setError(err.message);
                setLoading(false);
            });
    }, [instrumentType, assetName]);

    const filteredInstruments = useMemo(() => {
        return instrumentsData.filter((inst) =>
            `${inst.ticker}_${inst.classCode}`.toLowerCase().includes(filterTicker.toLowerCase())
        );
    }, [instrumentsData, filterTicker]);

    const {
        page,
        pageSize,
        model,
        onChangePage,
        onChangeRowsPerPage,
        resetToFirstPage,
    } = usePagination(filteredInstruments);

    useEffect(() => {
        if (resetToFirstPage) {
            resetToFirstPage();
        }
    }, [filterTicker, resetToFirstPage]);

    const keyFn = (entry) => entry.id;

    const allSelection = useMemo(() =>
            model.length > 0 && model.every((e) => selectedInstruments[keyFn(e)]),
        [model, selectedInstruments]
    );

    const indeterminate = useMemo(() => {
        const selectedCount = model.filter((e) => selectedInstruments[keyFn(e)]).length;
        return selectedCount > 0 && selectedCount < model.length;
    }, [model, selectedInstruments]);

    const loadInstrumentArchives = async (instrumentId, instrument) => {
        setLoadingInstruments(prev => new Set([...prev, instrumentId]));

        try {
            const tradeData = await fetchInstrumentIndex(instrument.id);

            return new Promise((resolve) => {
                setSelectedArchivesMap(prevMap => {
                    const newMap = new Map(prevMap);
                    const currentCount = Array.from(newMap.values()).reduce((sum, archives) => sum + archives.length, 0);
                    const availableSlots = MAX_LINES - currentCount;

                    const recordsToAdd = Math.min(tradeData.length, availableSlots);
                    const limitedTradeData = tradeData.slice(0, recordsToAdd);

                    const instrumentArchives = limitedTradeData.map(archive => ({
                        ...archive,
                        instrumentId: instrumentId,
                        key: instrument.id
                    }));

                    newMap.set(instrumentId, instrumentArchives);

                    const newTotalCount = Array.from(newMap.values()).reduce((sum, archives) => sum + archives.length, 0);
                    currentArchivesCount.current = newTotalCount;

                    resolve({
                        newCount: newTotalCount,
                        addedCount: instrumentArchives.length,
                        totalAvailable: tradeData.length
                    });
                    return newMap;
                });
            });
        } catch (error) {
            console.error(`Ошибка загрузки архивов для ${instrumentId}:`, error);
            return {
                newCount: currentArchivesCount.current,
                addedCount: 0,
                totalAvailable: 0
            };
        } finally {
            setLoadingInstruments(prev => {
                const newSet = new Set(prev);
                newSet.delete(instrumentId);
                return newSet;
            });
        }
    };

    const removeInstrumentArchives = (instrumentId) => {
        setSelectedArchivesMap(prevMap => {
            const newMap = new Map(prevMap);
            newMap.delete(instrumentId);
            return newMap;
        });
    };

    const removeMultipleInstrumentArchives = (instrumentIds) => {
        setSelectedArchivesMap(prevMap => {
            const newMap = new Map(prevMap);
            instrumentIds.forEach(id => newMap.delete(id));
            return newMap;
        });
    };

    const onToggleSelectAll = async (e) => {
        const checked = e.target.checked;

        if (checked) {
            setLoadingAllInstruments(true);
            const newSelected = { ...selectedInstruments };
            const instrumentsToLoad = [];

            for (const entry of model) {
                if (!selectedInstruments[keyFn(entry)]) {
                    newSelected[keyFn(entry)] = entry;
                    instrumentsToLoad.push(entry);
                }
            }

            setSelectedInstruments(newSelected);

            for (const entry of instrumentsToLoad) {
                if (currentArchivesCount.current >= MAX_LINES) {
                    setSelectedInstruments(prevSelected => {
                        const updatedSelected = { ...prevSelected };
                        const remainingInstruments = instrumentsToLoad.slice(instrumentsToLoad.indexOf(entry));
                        remainingInstruments.forEach(inst => {
                            delete updatedSelected[keyFn(inst)];
                        });
                        return updatedSelected;
                    });
                    break;
                }

                const result = await loadInstrumentArchives(keyFn(entry), entry);

                if (result.newCount >= MAX_LINES || result.addedCount === 0) {
                    const remainingInstruments = instrumentsToLoad.slice(instrumentsToLoad.indexOf(entry) + 1);
                    if (remainingInstruments.length > 0) {
                        setSelectedInstruments(prevSelected => {
                            const updatedSelected = { ...prevSelected };
                            remainingInstruments.forEach(inst => {
                                delete updatedSelected[keyFn(inst)];
                            });
                            return updatedSelected;
                        });
                    }
                    break;
                }
            }

            setLoadingAllInstruments(false);
        } else {
            const newSelected = { ...selectedInstruments };
            const instrumentIdsToRemove = [];

            model.forEach((entry) => {
                delete newSelected[keyFn(entry)];
                instrumentIdsToRemove.push(entry.id);
            });

            setSelectedInstruments(newSelected);
            removeMultipleInstrumentArchives(instrumentIdsToRemove);
        }
    };

    const onToggleSelect = async (e) => {
        const name = e.target.name;
        const checked = e.target.checked;

        if (checked) {
            if (currentArchivesCount.current >= MAX_LINES) {
                return;
            }

            const entry = instrumentsData.find((e) => keyFn(e) === name);
            if (entry) {
                setSelectedInstruments(prev => ({
                    ...prev,
                    [name]: entry
                }));

                await loadInstrumentArchives(name, entry);
            }
        } else {
            setSelectedInstruments(prev => {
                const newSelected = { ...prev };
                delete newSelected[name];
                return newSelected;
            });
            removeInstrumentArchives(name);
        }
    };

    const isCheckboxDisabled = (instrumentId) => {
        if (loadingInstruments.has(instrumentId)) {
            return true;
        }
        if (selectedInstruments[instrumentId]) {
            return false;
        }
        return totalSelectedArchivesCount >= MAX_LINES;
    };

    const isHeaderCheckboxDisabled = () => {
        if (loadingInstruments.size > 0 || loadingAllInstruments) {
            return true;
        }
        return totalSelectedArchivesCount >= MAX_LINES && !allSelection;
    };

    if (loading || error) {
        return (
            <div className={styles.wrapper}>
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 16 }}>
                    <div>
                        <h4>{assetName}</h4>
                    </div>
                    <Button size="s" onClick={onBack}>
                        Назад к списку активов
                    </Button>
                </div>

                <div style={{ marginBottom: 16 }}>
                    <Input
                        label="Поиск инструмента"
                        placeholder="Введите тикер"
                        value=""
                        disabled={true}
                        readOnly={true}
                    />
                </div>

                <DataTableSkeleton
                    headers={[<Checkbox size="s" />, 'Тикер', 'Кол-во архивов']}
                    rows={10}
                    headerRowHeight={50}
                    contentRowHeight={87}
                />
            </div>
        );
    }

    if (selectedInstrument) {
        return (
            <InstrumentView
                tickerClassCode={selectedInstrument.id}
                name={selectedInstrument.name}
                onBack={() => setSelectedInstrument(null)}
            />
        );
    }

    return (
        <div className={styles.wrapper}>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 16 }}>
                <div>
                    <h4>{assetName}</h4>
                </div>
                <Button size="s" onClick={onBack}>
                    Назад к списку активов
                </Button>
            </div>

            <div style={{ marginBottom: 16 }}>
                <Input
                    label="Поиск инструмента"
                    placeholder="Введите тикер"
                    value={filterTicker}
                    onChange={(e) => setFilterTicker(e.target.value)}
                />
            </div>

            <DataTable
                heading={[
                    <Checkbox
                        size="s"
                        checked={allSelection}
                        indeterminate={indeterminate}
                        onChange={onToggleSelectAll}
                        disabled={isHeaderCheckboxDisabled()}
                    />,
                    'Тикер',
                    'Кол-во архивов',
                ]}
                body={model.map((instrument) => [
                    <Checkbox
                        size="s"
                        name={instrument.id}
                        checked={!!selectedInstruments[instrument.id]}
                        onChange={onToggleSelect}
                        disabled={isCheckboxDisabled(instrument.id)}
                    />,
                    <Tooltip>
                        <Tooltip.Trigger asChild>
                            <Button
                                appearance="flat-grayscale-on-dark"
                                onClick={() => setSelectedInstrument(instrument)}
                            >
                                {instrument.ticker}_{instrument.classCode}
                                {loadingInstruments.has(instrument.id) && ' (загрузка...)'}
                            </Button>
                        </Tooltip.Trigger>
                        <Tooltip.Content>{instrument.name}</Tooltip.Content>
                    </Tooltip>,
                    <Button
                        appearance="flat-grayscale-on-dark"
                        onClick={() => setSelectedInstrument(instrument)}
                    >
                        {instrument.count}
                    </Button>,
                ])}
            />

            <Pagination
                page={page - 1}
                rowsPerPage={pageSize}
                itemsTotal={filteredInstruments.length}
                rowsPerPageOptions={[pageSize]}
                onChangePage={onChangePage}
                onChangeRowsPerPage={onChangeRowsPerPage}
            />

            <div>
                <h3>Пример кода загрузки архивов</h3>
                <ExampleCodeView examples={selectedArchives} />
            </div>
        </div>
    );
};