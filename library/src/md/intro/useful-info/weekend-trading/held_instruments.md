# Инструменты иностранных эмитентов

На внутриброкерском рынке Т-Инвестиций заключаются операции с инструментами, по которым приостановлена торговля на биржах.
Не все ценные бумаги обращаются на внутреннем рынке. На странице представлен доступный функционал T-Invest API.

:::info 
Сейчас в T-Invest API нельзя совершать операции с этими инструментами.
Возможность торговли появится в ближайшее время.
:::

Торговля инструментами иностранных эмитентов схожа 
с [торговлей по расширенному расписанию](/invest/intro/useful-info/weekend-trading/extended) и
имеет ряд особенностей.

[Подробнее про особенности торговли](https://www.tbank.ru/invest/help/brokerage/account/trade-on-bs/buy-n-sell/?internal_source=search_help&card=q6)


## Торгуемые инструменты

Акции и фонды [торговой площадки](/invest/intro/useful-info/markets#торговые-площадки) `dealer_int_exchange`. Получить список можно
методами [Shares](/invest/services/instruments/head-instruments/#shares) и [Etfs](/invest/services/instruments/head-instruments/#etfs) задав параметры:

* [Статус запрашиваемых инструментов](/invest/services/instruments/head-instruments/#instrumentstatus) — `INSTRUMENT_STATUS_ALL`

* [Площадка торговли](/invest/services/instruments/head-instruments/#instrumentexchangetype) — `INSTRUMENT_EXCHANGE_DEALER`


## Расписание торгов

Торговая сессия проходит с 12:00 по 21:00 по Москве (UTC +3).

:::info
Расписание торгов может меняться в зависимости от выходных, праздников и от работы биржи.
Рекомендуем получать актуальную информацию через метод [getTradingSchedules](/invest/services/instruments/head-instruments#tradingschedules),
передавая в параметрах запроса нужную торговую площадку.
:::

## Котировки и рыночные данные

### Свечи

Недоступно.

### OrderBook

Стакан можно получить через метод [GetOrderBook](/invest/services/quotes/marketdata/#getorderbook) или в [Stream-соединениях](/invest/services/quotes/marketdata/#subscribeorderbookrequest).

### Цена последней сделки

Цену последней сделки можно получить через метод [GetLastPrices](/invest/services/quotes/marketdata/#getlastprices)
или из [Stream-соединения](/invest/services/quotes/marketdata/#subscribelastpricerequest).

### Цена закрытия

На внебиржевом рынке неприменима цена закрытия — `ClosePrice`.

### Обезличенные сделки

Недоступно.

### Торговый статус

Торговля ведется на внутриброкерском рынке, поэтому во время торгов он будет `DEALER_NORMAL_TRADING`.
Получить статус через метод [GetTradingStatus](/invest/services/quotes/marketdata/#gettradingstatus) или из [Stream-соединения](/invest/services/quotes/marketdata/#subscribeinforequest).

## Торговля

Недоступно.