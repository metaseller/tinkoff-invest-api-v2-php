import React,{ useMemo, useState, useEffect } from 'react';
import { DataTable } from '/src/components/DataTable'
import { tradesStateFuncByInstrumentType, groupByTickerClassCode } from './../trades-store'
import { Pagination } from '@platform-ui/dataTable'
import Input from '@platform-ui/input'
import { ButtonDesktop as Button } from '@tui-react/button'
import { CheckboxDesktop as Checkbox, CheckboxDesktopStateless, LabelDesktop as Label } from '@tui-react/checkbox'
import BrowserOnly from "@docusaurus/BrowserOnly";
import { TuiIconTdsMediumDocArrowDown, TuiIconTdsMediumPhoneNumberScan } from '@tui-react/proprietary-icons'
import { ExampleCodeView } from '../code-example';
import { TooltipDesktop as Tooltip } from '@tui-react/tooltip'
import styles from './../styles.module.scss';

const DETAIL_VIEW = 'detail';
const LIST_VIEW = 'list';
      

export const InstrumentsView = ({instrumentType, ...props}) => {
    const stateF = tradesStateFuncByInstrumentType(instrumentType)
    const [tradesState, setTradesState] = useState(stateF.initTradesState)
    const [codeState, setCodeState] = useState(() => ({ loading: true, visible: false, selectedUris: [] }))
    const [assetsData, setAssetsData] = useState(() => ({loadedPages:{}, assets: {}}))

    useEffect(() => {
        let active = true;
        let maxPages = tradesState.currentTradesData.length / 250 | 0
        if (tradesState.currentTradesData.length > (250 * maxPages))
            maxPages += 1
        var indexes = [ 0, ...Array(maxPages).keys().filter(v=>v > 0) ]
        async function loadData() {
             return await indexes
                .filter(page => !assetsData.loadedPages[page])
                .reduce( (promise, page) => {
                    return promise.then((arr) => stateF.loadDetailAssets(instrumentType, page)
                        .then(pageAssetData => {
                            setAssetsData(state => {
                                const assetPage = Object.fromEntries(pageAssetData.map(value => ([stateF.keyFn(value), value])))
                                return {
                                    loadedPages:{
                                        ...state.loadedPages,
                                        ...page
                                    },
                                    assets: { 
                                        ...state.assets,
                                        ...assetPage
                                    }
                                }
                            })
                            return Promise.resolve([...arr, {page, pageAssetData}]) 
                        }))
                }, Promise.resolve([]))
        }

        loadData()
            .then(data => {
                if (!active) return;
                setCodeState({
                    loading: false, 
                    visible: true
                })
            })

       
        
        return () => { active = false }
    },[instrumentType])



     const onChangePage = (event, payload) => {
        setTradesState(state => {
            var filterApply = stateF.filterToken(state.currentTradesData, state.filter.ticker);
            return {...state,
                page: payload.page,
                model: stateF.nextPage(filterApply.data, payload.page, state.pageSize),
                totalSize: filterApply.data.length,
                selectedArchives: {}
            };
        })
     }

     const onChagePageSize = (event, payload) => {
        setTradesState(state => {
            var filterApply = stateF.filterToken(state.currentTradesData, state.filter.ticker);
            return {...state,
                page: 0,
                pageSize: payload.rowsPerPage,
                model: stateF.firstPage(filterApply.data, payload.rowsPerPage),
                totalSize: filterApply.data.length,
                selectedArchives: {}
            };
        })
     }


     const onChangeTicker = (event, changed) => {
        setTradesState(state => {
            var filterApply = stateF.filterToken(
                state.currentTradesData, 
                changed.value, 
                state.pageSize
            );
            return {...state,
                selectedArchives: {},
                filter: { ticker : changed.value},
                model: filterApply.page,
                page: 0,
                totalSize: filterApply.data.length,
            };
        })
     }

     const onToggleSelectAll = (event, params) => {
        setTradesState(state => {
            return {...state, 
                selectedArchives: Object.fromEntries(state.model
                    .map(selected=>[stateF.keyFn(selected), (!allSelectionIndeterminate && params.checked)?selected:false]))
            }
        })
     }

     const onToggleSelect = (event, params) => {
        setTradesState(state => {
            const {selectedArchives, ...stateArgs} = state;
            const selectedKey = params.name
            const allTickers = groupByTickerClassCode(tradesState.currentTradesData)
            return {...stateArgs, 
                selectedArchives: Object.assign({
                    ...selectedArchives
                }, Object.fromEntries([[selectedKey, (params.checked)?allTickers[selectedKey]:false]]))
            };
        })
     }


    const allSelectionIndeterminate = useMemo(
        () => {
            var allTickers = groupByTickerClassCode(tradesState.model)
            var selectedSize = Object.keys(tradesState.selectedArchives)
            .filter((key) => key in allTickers)
            .reduce(
                (prevState, key) => (!!tradesState.selectedArchives[key]?prevState +1:prevState),
                0
            )
             return selectedSize > 0 && tradesState.model.length != selectedSize
        } ,
        [tradesState])

    const allSelection = useMemo(
        () => tradesState.model.length === Object.keys(tradesState.selectedArchives)
            .reduce((prevState, key) => (!!tradesState.selectedArchives[key]?prevState +1:prevState) ,0),
        [tradesState])    

        
    const selectedUris = useMemo(
        () => codeState.selectedUris,
        [codeState]
    )    

    useEffect(
        () => {
            const selectedUris =  Object.values(tradesState.selectedArchives)
                .filter(s => !!s)
                .map(s => ({...s, ...assetsData.assets[stateF.keyFn(s)], key : stateF.keyFn(s)}))
                .flatMap(assetVal => {
                    if (!assetVal.years || !assetVal.years.length) return []
                    return assetVal.years.map(year => ({
                        ...year, 
                        key : assetVal.key,
                        uri: stateF.candlesServerUrl + '?instrumentId=' + assetVal.uid + '&year=' + year.year
                    }))
                })
                .map(item => ({...item, candle: true}))
                .filter(s => !!s)

            setTimeout(function() {
                setCodeState(codeState => ({...codeState, selectedUris}))
            }, 0)
            
        },
        [tradesState, assetsData]
    )

    const candleYearsData = useMemo(
        () => tradesState.model
             .map(
                instrumentData => {
                    const assetVal = assetsData.assets[stateF.keyFn(instrumentData)];
                    return ({
                        ...instrumentData, 
                        years : (!!assetVal)?
                            assetVal
                            .years
                            .map((year => ({
                                ...year, 
                                uid: assetVal.uid, 
                                uri: stateF.candlesServerUrl + '?instrumentId=' + assetVal.uid + '&year=' + year.year
                            })))
                            : []
                    });
                }
            )
                
                ,
        [tradesState, assetsData]
    ) 

     
    return (
        <div className={styles.wrapper}>
        <div>
        <div style={{marginBottom:'16px'}}>
            <Input
                label="Поиск инструмента"
                onChange={onChangeTicker}
                placeholder="Введите тикер"
                value={tradesState.filter.ticker}
                variant="default"
            />
        </div>
        <DataTable 
            heading={
                [(<Checkbox size="s" 
                    indeterminate={allSelectionIndeterminate} 
                    checked={allSelection} 
                    onChange={onToggleSelectAll} 
                />),
                'Тикер',
                'Архивы за год'
            ]} 
            body={candleYearsData.map(
                instrumentData => [
                    (<Checkbox 
                        size="s" 
                        name={instrumentData.ticker + '_' + instrumentData.classCode} 
                        checked={!!tradesState.selectedArchives[instrumentData.ticker + '_' + instrumentData.classCode]} 
                        onChange={onToggleSelect} 
                    />),
                    ( 
                     <Tooltip {...props}>
                        <Tooltip.Trigger asChild>
                            <Button 
                                appearance="flat-grayscale-on-dark" 
                                >{instrumentData.ticker + '_' + instrumentData.classCode}
                            </Button>
                        </Tooltip.Trigger>
                        <Tooltip.Content appearance='default'>{instrumentData.name}</Tooltip.Content>
                    </Tooltip>
                    ), 
                    (<div>
                        {(!instrumentData.years || !instrumentData.years.length) && (
                            <span>&#8722;</span>
                        )}
                        {(instrumentData.years.map((yearCandle, index) => (
                            <Button 
                                size="xs" 
                                key={index}
                                href={yearCandle.uri} 
                                download={true} 
                                iconLeft={ <TuiIconTdsMediumDocArrowDown/>}
                                appearance="flat-grayscale-on-dark"
                                >
                                    {yearCandle.year}
                            </Button>
                        )))}
                    </div>)
                ])} 
        />
        <Pagination 
            page={tradesState.page} 
            rowsPerPage={tradesState.pageSize} 
            itemsTotal={tradesState.totalSize} 
            onChangePage={onChangePage} 
            onChangeRowsPerPage={onChagePageSize}
        />
        </div>
        
        {codeState.loading && (<div>Загрузка данных для примера...</div>)}
        {codeState.visible && (
            <BrowserOnly>
                {()=>(
                    <div>
                        <h3>Пример кода загрузки</h3>
                        <ExampleCodeView examples={selectedUris} />
                    </div>
                )}
            </BrowserOnly>
        )}
            
        </div>

    );
}