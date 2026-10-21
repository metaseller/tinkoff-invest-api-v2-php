export const SERVER_URL = 'https://invest-public-api.tinkoff.ru';

export async function fetchTradesDaysIndex(year) {
    const response = await fetch(`${SERVER_URL}/trades-days-index/${year}`);
    if (!response.ok) {
        throw new Error('Ошибка загрузки индекса архивов сделок за год');
    }
    const json = await response.json();
    return json.entries || [];
}

export async function fetchInstrumentsIndex(instrumentType) {
    const response = await fetch(`${SERVER_URL}/trades-instruments-index/instrument-type/${instrumentType}`);
    if (!response.ok) {
        throw new Error('Ошибка загрузки индекса инструментов по типу');
    }
    const json = await response.json();
    return json.instruments || {};
}

export async function fetchInstrumentIndex(tickerClassCode) {
    const response = await fetch(`${SERVER_URL}/trades-instruments-index/ticker-classcode/${tickerClassCode}`);
    if (!response.ok) {
        throw new Error('Ошибка загрузки индекса архивов сделок по инструменту');
    }
    const json = await response.json()
    return json.trades || {};
}

export const fetchAssetsIndex = async (instrumentType) => {
    const response = await fetch(`${SERVER_URL}/trades-instruments-index/basic-assets/${instrumentType}`);
    if (!response.ok) {
        throw new Error(`Failed to fetch assets: ${response.statusText}`);
    }
    return response.json();
};

export const fetchAssetInstruments = async (instrumentType, assetName) => {
    const response = await fetch(`${SERVER_URL}/trades-instruments-index/basic-assets/${instrumentType}/${assetName}`);
    if (!response.ok) {
        throw new Error(`Failed to fetch asset instruments: ${response.statusText}`);
    }
    return response.json();
};
