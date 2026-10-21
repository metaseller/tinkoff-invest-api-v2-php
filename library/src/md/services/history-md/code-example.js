import React,{ useState, useEffect } from 'react';
import { DataCard } from '@/components/ApiMethod';
import { Filter } from '@/components/Filter';
import items from '../../../src/theme/ApiExplorer/Request/languages.json';

import { codeSnippet } from './code-snippet';
import { SERVER_URL } from './trades-index-loader'
import styles from './styles.module.scss';

export const ExampleCodeView = ({examples ,...props}) => {
    const filteredItems = items.filter(innerItem => (innerItem.key !== 'payload') );
    const [activeLanguage, setActiveLanguage] = useState(filteredItems[0]);
    const [requestText, setRequestText] = useState('');
    const isPayload = false;
    const data = null;
    const codeSamples = []

    useEffect(() => {
        const serverUrl = SERVER_URL  + "/history-trades"
        const candleUrl = SERVER_URL + "/history-data"
        const items = (examples || []);
        setRequestText(codeSnippet(
            activeLanguage.key,
            { serverUrl: serverUrl,
                items: items
                    .map(item => {
                        let fn;
                        if (item.key && item.key !== 'undefined') {
                            fn = `${item.key}_${item.date}.csv.gz`;
                        } else {
                            fn = `${item.date}.csv.gz`;
                        }

                        let loadUri = `${serverUrl}${item.uri}`
                        if (item.candle) {
                            if (item.key && item.key !== 'undefined') {
                                fn = `${item.key}_${item.year}.zip`;
                            } else {
                                fn = `${item.year}.zip`;
                            }
                            loadUri = item.uri
                        }
                        return ({
                            ...item,
                            fn,
                            loadUri
                        })
                    })
            }
        ))
    }, [activeLanguage, examples]);

    return (
        <div>
            <Filter
                items={filteredItems}
                activeItem={activeLanguage}
                requestText={requestText}
                onChange={(val) => setActiveLanguage(val)}
            />
            <div className={styles.codeWrapper}>
                <DataCard
                    language={activeLanguage.highlightKey ?? activeLanguage.key}
                    requestText={requestText}
                    isPayload={isPayload}
                    schema={{responseType:'application/octet-stream'}}
                    codeSamples={codeSamples}
                    noContentMessage="We haven't come up with a single example where it's needed"
                />
            </div>
        </div>
    )
}
