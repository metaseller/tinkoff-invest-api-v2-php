---
sidebar_position: 1
---


# Дилерские торговые сессии

По ряду инструментов в T-Invest API есть возможность совершать операции в то время, когда на бирже инструменты не
торгуются. Торговля имеет ряд ограничений и особенностей.

[Подробнее про особенности торговли](https://www.tbank.ru/invest/help/brokerage/account/trade-on-bs/buy-n-sell/?internal_source=search_help&card=q6)


## Торгуемые инструменты

Заключать сделки возможно только по [ограниченному списку инструментов](/invest/services/instruments/faq_instruments#как-узнать-торгуется-ли-инструмент-на-выходных-).
Сейчас это наиболее ликвидные инструменты нескольких [торговых площадок](/invest/intro/useful-info/markets).

## Расписание торгов

:::info
Расписание торгов может меняться в зависимости от выходных, праздников и работы биржи.
Рекомендуем получать актуальную информацию через метод [getTradingSchedules](/invest/services/instruments/head-instruments#tradingschedules),
передавая в параметрах запроса нужную торговую площадку.
:::

Период дилерских торгов называется `dealer_regular_trading_session` и проходит по [расписанию](/invest/services/instruments/head-instruments#получить-расписание-торгов) торговой площадки инструмента.



## Котировки и рыночные данные

### Свечи

Доступны в API в методе [GetCandles](/invest/services/quotes/marketdata/#getcandles) и в [Stream-соединениях](/invest/intro/developer/stream) только на маленьких [интервалах](/invest/services/quotes/marketdata/#candleinterval)
в диапазоне от `CANDLE_INTERVAL_5_SEC` до `CANDLE_INTERVAL_HOUR`.


### OrderBook

Стакан можно получить через метод [GetOrderBook](/invest/services/quotes/marketdata/#getorderbook)
или в [Stream-соединениях](/invest/services/quotes/marketdata/#subscribeorderbookrequest).


### Цена последней сделки

Цену последней сделки можно получить через метод [GetLastPrices](/invest/services/quotes/marketdata/#getlastprices)
или из [Stream-соединения](/invest/services/quotes/marketdata/#subscribelastpricerequest).

### Цена закрытия

На внебиржевом рынке неприменима цена закрытия — `ClosePrice`.

### Обезличенные сделки

Поток обезличенных сделок от торговли по выходным можно получить в [Stream-соединениях](/invest/services/quotes/marketdata/#subscribetradesrequest).


### Торговый статус

Торговля ведется на внутреннем рынке, поэтому во время торгов статус будет `DEALER_NORMAL_TRADING`.
Получить статус можно используя метод [GetTradingStatus](/invest/services/quotes/marketdata/#gettradingstatus) или из [Stream-соединения](/invest/services/quotes/marketdata/#subscribeinforequest).

## Торговля

Заявки можно выставлять с некоторыми ограничениями. Доступные [типы заявок](/invest/services/orders/methods#ordertype):

| Тип заявки  | Доступность выставления торгов                                                                               |
|-------------|--------------------------------------------------------------------------------------------------------------|
| Лимитная    | Доступно. Исключение — [алгоритм исполнения](/invest/services/orders/methods#timeinforcetype) `FILL_OR_KILL` |
| Рыночная    | Доступно                                                                                                     |
| Лучшая цена | Доступно                                                                                                     |

[Отмена](/invest/services/orders/methods#cancelorder), [получение cтатуса](/invest/services/orders/methods#getorderstate) и [изменение](/invest/services/orders/methods#replaceorder) выставленной заявки
по выходным выполняются без каких-либо особенностей.

### Сделки и заявки

Сделки, совершенные в выходные, можно получать в [стриме сделок](/invest/services/orders/methods#tradesstream).
Подписаться на статусы заявок можно через [стрим заявок](/invest/services/orders/orders_state_stream).

