import React, { useState, useEffect, useMemo } from 'react';
import { DataTable } from '../../../../src/components/DataTable';
import { DataTableSkeleton } from '../../../../src/components/DataTableSkeleton';
import { Pagination } from '@platform-ui/dataTable';
import { ButtonDesktop as Button } from '@tui-react/button';
import Input from '@platform-ui/input';
import { fetchAssetsIndex } from '../trades-index-loader';
import { usePagination } from '../pagination';
import { AssetView } from './asset-view';
import styles from "../styles.module.scss";

export const AssetsView = ({ instrumentType }) => {
    const [assetsData, setAssetsData] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [filterAsset, setFilterAsset] = useState('');
    const [selectedAsset, setSelectedAsset] = useState(null);

    useEffect(() => {
        setLoading(true);
        fetchAssetsIndex(instrumentType)
            .then((data) => {
                const arr = Object.entries(data.basicAssets).map(([key, val]) => ({
                    id: key,
                    name: val.name,
                    count: val.count,
                }));
                setAssetsData(arr);
                setLoading(false);
            })
            .catch((err) => {
                setError(err.message);
                setLoading(false);
            });
    }, [instrumentType]);

    const filteredAssets = useMemo(() => {
        return assetsData.filter((asset) =>
            asset.name.toLowerCase().includes(filterAsset.toLowerCase())
        );
    }, [assetsData, filterAsset]);

    const {
        page,
        pageSize,
        model,
        onChangePage,
        onChangeRowsPerPage,
        resetToFirstPage,
    } = usePagination(filteredAssets);

    useEffect(() => {
        if (resetToFirstPage) {
            resetToFirstPage();
        }
    }, [filterAsset, resetToFirstPage]);

    if (loading || error) {
        return (
            <div className={styles.wrapper}>
                <div style={{ marginBottom: 16 }}>
                    <Input
                        label="Поиск актива"
                        placeholder="Введите название актива"
                        value=""
                        disabled={true}
                        readOnly={true}
                    />
                </div>

                <DataTableSkeleton
                    headers={['Актив', 'Кол-во инструментов']}
                    rows={10}
                    twoColumnsMode={true}
                    headerRowHeight={50}
                    contentRowHeight={87}
                />
            </div>
        );
    }

    if (selectedAsset) {
        return (
            <AssetView
                assetName={selectedAsset.name}
                instrumentType={instrumentType}
                onBack={() => setSelectedAsset(null)}
            />
        );
    }

    return (
        <div className={styles.wrapper}>
            <div style={{ marginBottom: 16 }}>
                <Input
                    label="Поиск актива"
                    placeholder="Введите название актива"
                    value={filterAsset}
                    onChange={(e) => setFilterAsset(e.target.value)}
                />
            </div>
            <DataTable
                twoColumnsMode={true}
                heading={[
                    'Актив',
                    'Кол-во инструментов',
                ]}
                body={model.map((asset) => [
                    <Button
                        appearance="flat-grayscale-on-dark"
                        onClick={() => setSelectedAsset(asset)}
                    >
                        {asset.name}
                    </Button>,
                    <Button
                        appearance="flat-grayscale-on-dark"
                        onClick={() => setSelectedAsset(asset)}
                    >
                        {asset.count}
                    </Button>,
                ])}
            />
            <Pagination
                page={page - 1}
                rowsPerPage={pageSize}
                itemsTotal={filteredAssets.length}
                rowsPerPageOptions={[pageSize]}
                onChangePage={onChangePage}
                onChangeRowsPerPage={onChangeRowsPerPage}
            />
        </div>
    );
};
