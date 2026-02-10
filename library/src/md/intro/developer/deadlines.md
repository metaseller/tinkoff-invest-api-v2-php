# Время исполнения запросов

T-Invest API работает по протоколу [gRPC](/invest/intro/developer/protocols/grpc/), который предполагает использование
параметра **deadline** на стороне клиента. 
Этот параметр обозначает крайний срок исполнения запроса — по истечении указанного времени запрос будет прерван принудительно. 

В T-Invest API нет жесткого регулирования параметра **deadline**, но учитывайте, что время исполнения запроса зависит от множества факторов — объема данных, скорости их обработки, сложности вычислений и других.
Поэтому мы не рекомендуем использовать значения меньше указанных в таблице ниже.

[Подробнее про gRPC и deadline](https://grpc.io/blog/deadlines/)

## Рекомендованные минимальные сроки исполнения запросов

| Метод T-Invest API                                          | Рекомендованный `deadline` (ms) |
|:------------------------------------------------------------------|:------------------------------|
| [GetAccounts](/invest/services/accounts/users#getaccounts)                       | 300                           |
| [GetMarginAttributes](/invest/services/accounts/users#getmarginattributes)       | 300                           |
| [GetUserTariff](/invest/services/accounts/users#getusertariff)                   | 300                           |
| [GetInfo](/invest/services/accounts/users#getinfo)                               | 1000                          |
| [TradingSchedules](/invest/services/instruments/head-instruments#tradingschedules)       | 300                           |
| [BondBy](/invest/services/instruments/head-instruments#bondby)                           | 300                           |
| [Bonds](/invest/services/instruments/head-instruments#bonds)                             | 500                           |
| [CurrencyBy](/invest/services/instruments/head-instruments#currencyby)                   | 300                           |
| [Currencies](/invest/services/instruments/head-instruments#currencies)                   | 500                           |
| [EtfBy](/invest/services/instruments/head-instruments#etfby)                             | 300                           |
| [Etfs](/invest/services/instruments/head-instruments#etfs)                               | 500                           |
| [FutureBy](/invest/services/instruments/head-instruments#futureby)                       | 300                           |
| [Futures](/invest/services/instruments/head-instruments#futures)                         | 500                           |
| [ShareBy](/invest/services/instruments/head-instruments#shareby)                         | 300                           |
| [Shares](/invest/services/instruments/head-instruments#shares)                           | 500                           |
| [GetAccruedInterests](/invest/services/instruments/head-instruments#getaccruedinterests) | 500                           |
| [GetFuturesMargin](/invest/services/instruments/head-instruments#getfuturesmargin)       | 500                           |
| [GetInstrumentBy](/invest/services/instruments/head-instruments#getinstrumentby)         | 300                           |
| [PostOrder](/invest/services/orders/methods#postorder)                          | 1500                          |
| [CancelOrder](/invest/services/orders/methods#cancelorder)                      | 1500                          |
| [GetOrderState](/invest/services/orders/methods#getorderstate)                  | 300                           |
| [GetOrders](/invest/services/orders/methods#getorders)                          | 500                           |
| [GetOperations](/invest/services/operations/methods##getoperations)              | 1500                          |
| [GetPortfolio](/invest/services/operations/methods##getportfolio)                | 1500                          |
| [GetPositions](/invest/services/operations/methods##getpositions)                | 1000                          |
| [GetWithdrawLimits](/invest/services/operations/methods##getwithdrawlimits)      | 1000                          |
| [GetCandles](/invest/services/quotes/marketdata#getcandles)                    | 500                           |
| [GetLastPrices](/invest/services/quotes/marketdata#getlastprices)              | 500                           |
| [GetOrderBook](/invest/services/quotes/marketdata#getorderbook)                | 500                           |
| [GetTradingStatus](/invest/services/quotes/marketdata#gettradingstatus)        | 500                           |
| [PostStopOrder](/invest/services/stop-orders/stoporders#poststoporder)              | 1500                          |
| [GetStopOrders](/invest/services/stop-orders/stoporders#getstoporders)              | 1500                          |
| [CancelStopOrder](/invest/services/stop-orders/stoporders#cancelstoporder)          | 1500                          |
| [OpenSandboxAccount](/invest/intro/developer/sandbox/index#opensandboxaccount)       | 300                           |
| [GetSandboxAccounts](/invest/intro/developer/sandbox/index#getsandboxaccounts)       | 300                           |
| [CloseSandboxAccount](/invest/intro/developer/sandbox/index#closesandboxaccount)     | 300                           |
| [PostSandboxOrder](/invest/intro/developer/sandbox/index#postsandboxorder)           | 300                           |
| [GetSandboxOrders](/invest/intro/developer/sandbox/index#getsandboxorders)           | 300                           |
| [CancelSandboxOrder](/invest/intro/developer/sandbox/index#cancelsandboxorder)       | 300                           |
| [GetSandboxOrderState](/invest/intro/developer/sandbox/index#getsandboxorderstate)   | 300                           |
| [GetSandboxPositions](/invest/intro/developer/sandbox/index#getsandboxpositions)     | 2000                          |
| [GetSandboxOperations](/invest/intro/developer/sandbox/index#getsandboxoperations)   | 2000                          |
| [GetSandboxPortfolio](/invest/intro/developer/sandbox/index#getsandboxportfolio)     | 2000                          |
| [SandboxPayIn](/invest/intro/developer/sandbox/index#sandboxpayin)                   | 300                           |