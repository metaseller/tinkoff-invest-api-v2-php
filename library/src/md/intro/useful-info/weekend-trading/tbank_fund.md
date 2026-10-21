# Фонды Т-Банка

Некоторые фонды Т-Банка не торгуются на биржах.
В T-Invest API можно работать с этими инструментами.


## Торгуемые инструменты

Инструменты [торговой площадки](/invest/intro/useful-info/markets) `dealer_realestate` и [class_code](/invest/services/instruments/faq_instruments#что-такое-class_code-и-где-его-найти) `ZPIF_OTC`.

## Расписание торгов

Торговая сессия проходит по рабочим дням с 10:00 по 19:00 по Москве (UTC +3).

:::info
Расписание торгов может меняться в зависимости от выходных, праздников и от работы биржи.
Рекомендуем получать актуальную информацию через метод [getTradingSchedules](/invest/services/instruments/head-instruments#tradingschedules),
передавая в параметрах запроса нужную торговую площадку.
:::

## Котировки и рыночные данные

### Свечи

Недоступно.

### OrderBook

Стакан можно получить через метод [GetOrderBook](/invest/services/quotes/marketdata#getorderbook) или в [Stream-соединениях](/invest/services/quotes/marketdata#subscribeorderbookrequest).

### Цена последней сделки

Цену последней сделки можно получить через метод [GetLastPrices](/invest/services/quotes/marketdata#getlastprices) или из [Stream-соединения](/invest/services/quotes/marketdata#subscribelastpricerequest).

### Цена закрытия

На внебиржевом рынке неприменима цена закрытия — `ClosePrice`.

### Обезличенные сделки

Недоступно.

### Торговый статус

Торговля ведется на внутриброкерском рынке, поэтому во время торгов он будет `DEALER_NORMAL_TRADING`.
Получить статус можно через метод [GetTradingStatus](/invest/services/quotes/marketdata#gettradingstatus) или из [Stream-соединения](/invest/services/quotes/marketdata#subscribeinforequest).

## Торговля

Заявки можно выставлять с некоторыми ограничениями. Доступные [типы заявок](/invest/services/orders/methods#ordertype):

| Тип заявки  | Доступность выставления торгов                                                               |
|-------------|----------------------------------------------------------------------------------------------|
| Лимитная    | Доступен только [алгоритм исполнения](/invest/services/orders/methods#timeinforcetype) `DAY` |
| Рыночная    | Недоступно                                                                                   |
| Лучшая цена | Недоступно                                                                                   | 