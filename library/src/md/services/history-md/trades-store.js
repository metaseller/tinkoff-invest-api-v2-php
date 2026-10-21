/**
 * Utility functions for archive state,
 * Sharing general state functionality for two archive models - years and instruments
 * Paging, Selecting Rows, Filtering 
 */

import instrumentsIndexData from './data/trades-history-instruments.json';
import { SERVER_URL } from './trades-index-loader'

export const tradesInstrumentIndexKeyFn = (instrumentData) =>  instrumentData.ticker + '_' + instrumentData.classCode  

export const filterByInstrumentType = (type) => Object.keys(instrumentsIndexData.instruments)
    .sort()
    .map(k => instrumentsIndexData.instruments[k])
    .filter(i => i.type === type)
   

export const groupByTickerClassCode = (instruments) =>  Object.fromEntries(instruments.map(
    instrumentData => [tradesInstrumentIndexKeyFn(instrumentData), instrumentData]))

export const paginate = (array, pageSize, pageNumber) => {
  // human-readable page numbers usually start with 1, so we reduce 1 in the first argument
  return array.slice((pageNumber - 1) * pageSize, pageNumber * pageSize);
}

export const tradesStateFuncByInstrumentType = (type) => {
    return tradesStateFunc(
        () => filterByInstrumentType(type), 
        tradesInstrumentIndexKeyFn
    )
}

const DEFAULT_PAGE_SIZE = 10;
let remoteCache = {}


export const tradesStateFunc = (tradesListModelFunc, keyFn) => {
    
    const firstPage = (currentTradesData, pageSize) => [...paginate(currentTradesData, pageSize, 1)]
    const nextPage = (currentTradesData, page, pageSize) => [...paginate(currentTradesData, pageSize, page + 1)]
    return {
        initTradesState: () => {
            const currentTradesData = tradesListModelFunc();
            const firstPageData = firstPage(currentTradesData, DEFAULT_PAGE_SIZE);
            return {
                selectedArchives: {},
                page: 0,
                pageSize: DEFAULT_PAGE_SIZE,
                model: firstPageData,
                filter: {
                    ticker: ''
                },
                totalSize: currentTradesData.length,
                currentTradesData
            }
        },
        loadDetailAssets: async (type, page) => {
            if (!!remoteCache[type + page]) return Object.values(remoteCache[type + page]);
            const fetchCall = fetch(SERVER_URL + '/history-trades-index?chunk=INSTRUMENT_TYPE_'+type+'&page='+ page);
            
            const response = await fetchCall
            const data = await response.json();
            remoteCache[type + page] = data.instruments
            return Object.values(data.instruments);
        },
        firstPage,
        nextPage,
        keyFn,
        serverUrl : SERVER_URL + "/history-trades",
        candlesServerUrl: SERVER_URL + "/history-data",
        filterToken: (currentTradesData, token, pageSize) => {
            var filteredData = currentTradesData.filter(
                i => (!token || token.length < 1)|| (i.ticker != null && ((tradesInstrumentIndexKeyFn(i).toLowerCase()).indexOf(token.toLowerCase()) > -1 ))
            );
            return {data: filteredData, page: [...paginate(filteredData, pageSize, 1)] }
        }
    }
}

