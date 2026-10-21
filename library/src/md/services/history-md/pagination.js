import { useCallback, useMemo, useState } from 'react';

const DEFAULT_PAGE_SIZE = 10;

export const usePagination = (data) => {
    const [page, setPage] = useState(1);
    const [pageSize, setPageSize] = useState(DEFAULT_PAGE_SIZE);

    const model = useMemo(() => {
        const start = (page - 1) * pageSize;
        const end = start + pageSize;
        return data.slice(start, end);
    }, [data, page, pageSize]);

    const onChangePage = useCallback((_, { page: newPage }) => {
        const pageNum = Number(newPage);
        if (!isNaN(pageNum) && pageNum >= 0) {
            setPage(pageNum + 1);
        }
    }, []);

    const onChangeRowsPerPage = useCallback((_, { rowsPerPage }) => {
        const size = Number(rowsPerPage);
        if (!isNaN(size) && size > 0) {
            setPageSize(size);
            setPage(1);
        }
    }, []);

    const resetToFirstPage = useCallback(() => {
        setPage(1);
    }, []);

    return {
        page,
        pageSize,
        model,
        onChangePage,
        onChangeRowsPerPage,
        resetToFirstPage,
    };
};
