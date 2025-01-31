### Что такое шаг цены? 

Шаг цены — это минимальное изменение цены определёного инструмента.

**Пример**

Шаг цены для инструмента — `0.1`, последняя цена — `10.5`. Это значит, что заявка может быть выставлена по одной из следующих цен:

* 10.4,
* 10.5,
* 10.6.

Цена `10.55` будет некорректной, заявка не выставится.

```scala
def isValidPrice(price: BigDecimal, increment: BigDecimal): Boolean = {
    price % increment == 0
}

isValidPrice(10.1, 0.1) // true
isValidPrice(10.16, 0.1) // false
```

### Отличие лотов и количества инструментов

При работе с T-Invest API обращайте особое внимание на различие понятий
лот и количество ценных бумаг. 

Все цены в [сервисе котировок](/investAPI/head-marketdata/) предоставляются за одну ценную бумагу. Это правило касается методов [GetLastPrice](/investAPI/marketdata#getlastprices) и [GetCandles](/investAPI/marketdata#getcandles), а также подписки на эти данные в рамках [stream-соединений](/investAPI/marketdata#marketdatastreamservice) сервиса. 

Если вы получаете данные по стакану или сделкам, объём этих сделок отображается в лотах. То есть параметр `quantity` метода [GetOrderBook](/investAPI/marketdata#getorderbook) и пакета [trade](/investAPI/marketdata#trade) в рамках [stream-соединений](/investAPI/marketdata#marketdatastreamservice) сервиса отображается в лотах.

### Цены облигаций и фьючерсов

Цены облигаций и фьючерсов в T-Invest API предоставляются в пунктах. Методика расчёта стоимости 
лота в валюте отличается в зависимости от типа биржевого инструмента. 

## Формулы расчёта реальной стоимости инструментов в валюте 

Значения: 

* **price** — текущая котировка ценной бумаги;
* **nominal** — номинал облигации;
* **min_price_increment** — шаг цены;
* **min_price_increment_amount** — стоимость шага цены;
* **lot** - лотность инструмента.

### Акции 

Формула расчёта: **price** * **lot**.

### Облигации 

Пункты цены для котировок облигаций — это проценты номинала облигации. Формула для пересчёта пунктов в валюту:
**price** / 100 * **nominal**.

### Валюта 

Формула расчёта: **price** * **lot** / **nominal**.

>**Важно**<br>
>При торговле валютой учитывайте, что у таких валют как Иена, Армянский драм и Тенге `nominal` отличный от `1`.

### Фьючерсы

Стоимость фьючерсов предоставляется в пунктах. Формула расчёта: **price** / **min_price_increment** * **min_price_increment_amount**.

Также при работе с фьючерсами важно учитывать размер гарантийного обеспечения. Узнать эти параметры фьючерсов
можно чрез метод [getFuturesMargin](/investAPI/instruments#getfuturesmargin). 

[Подробнее про срочный рынок](https://www.tbank.ru/invest/help/brokerage/account/forts/)

### Какие интервалы доступны при запросе исторических свечей? 

Метод [GetCandles](/investAPI/marketdata#getcandles) позволяет получать исторические свечи разных 
временных интервалов. Есть ограничения на максимальный и минимальный период запроса для каждого интервала 
свечей: 

|Запрошенный интервал свечей|Допустимый период запроса|
|:---|---:|
| CANDLE_INTERVAL_UNSPECIFIED | Интервал не определен.                |
| CANDLE_INTERVAL_1_MIN       | От 1 минуты до 1 дня (лимит 2400).    |
| CANDLE_INTERVAL_5_MIN       | От 5 минут до недели (лимит 2400).    |
| CANDLE_INTERVAL_15_MIN      | От 15 минут до 3 недель (лимит 2400). |
| CANDLE_INTERVAL_HOUR        | От 1 часа до 3 месяцев (лимит 2400).  |
| CANDLE_INTERVAL_DAY         | От 1 дня до 6 лет (лимит 2400).       |
| CANDLE_INTERVAL_2_MIN       | От 2 минут до 1 дня (лимит 1200).     |
| CANDLE_INTERVAL_3_MIN       | От 3 минут до 1 дня (лимит 750).      |
| CANDLE_INTERVAL_10_MIN      | От 10 минут до недели (лимит 1200).   |
| CANDLE_INTERVAL_30_MIN      | От 30 минут до 3 недель (лимит 1200). |
| CANDLE_INTERVAL_2_HOUR      | От 2 часов до 3 месяцев (лимит 2400). |
| CANDLE_INTERVAL_4_HOUR      | От 4 часов до 3 месяцев (лимит 700).  |
| CANDLE_INTERVAL_WEEK        | От 1 недели до 5 лет (лимит 300).     |
| CANDLE_INTERVAL_MONTH       | От 1 месяца до 10 лет (лимит 120).    |

>**Важно** <br>
>При запросе дневных свечей `CANDLE_INTERVAL_DAY` время, которое передаётся в полях `from` и `to`, игнорируется.<br>
>Например, при запросе дневной свечи по интервалу с 12:00 01.01.2021 по 07:00 02.01.2021 вернутся две дневные 
свечи за 01.01.2021 и за 02.01.2021.

>**Важно** <br>
>Если попытаться получить данные с временным интервалом меньше временного интервала данного таймфрейма, в ответе метода вернётся пустой массив. Например, если интервал при запросе дневных свечей (CANDLE_INTERVAL_DAY) инструмента будет 1 час.

### Как одним запросом получить последние цены по нескольким инструментам?

Через метод [GetLastPrices](/investAPI/marketdata#getlastprices) — в запросе передайте массив
идентификаторов инструментов.

### Как подписаться на разные типы данных в рамках stream-соединения сервиса котировок? 

Bidirectional stream сервиса котировок поддерживает одновременную подписку на разные типы данных — свечи,
стаканы, сделки и другие в рамках одного соединения. 

Для этого нужно последовательно отправить пакеты подписки на разные данные — то есть отдельно подписаться подписаться на свечи, стаканы и так далее. Подробнее смотрите в примерах выбранного вами SDK.

### Внебиржевые инструменты в T-Invest API 

Сейчас T-Invest API предполагает работу только с биржевыми инструментами.

### Какие данные отливаются в стриминг стаканов? 

Пока только биржевые. Внебиржевые стаканы, например, TRRE, не транслируются в режиме стриминга.

### Валюты в T-Invest API

Получить список доступных валют можно через метод [getInstruments/currencies](/investAPI/instruments#currencies).

Обратите внимание: лотность валют ограничена лотностью, которую предоставляет биржа. Например, операции
с евро и долларами возможны только на количества, кратные 1000.

### Почему отличаются исторические цены в T-Invest API и других источниках?

Исторические данные [Т-Инвестиций](https://www.tbank.ru/invest/) могут отличаться от данных,
которые предоставляют другие сервисы. Это может быть связано как с различными источниками первичных данных,
так и с различными алгоритмами их обработки и агрегации. 

### Как получить исторические рыночные данные?

Через метод [Загрузка исторических рыночных данных в виде архива](/investAPI/get_history/).

### Какое максимальное количество запросов на подписку в [MarketDataStream](/investAPI/marketdata/#marketdatastream)?

Для всех типов подписок в методе [MarketDataStream](/investAPI/marketdata/#marketdatastream) установлены ограничения максимального количества запросов на подписку.

Максимальное количество запросов в минуту — 100. Если количество запросов за минуту превысит 100, для всех элементов будет установлен статус [SUBSCRIPTION_STATUS_TOO_MANY_REQUESTS](/investAPI/marketdata/#subscriptionstatus).

### Как узнать дату, с которой можно получить свечи по инструменту?

Чтобы понять, с какой даты запрашивать свечи по инструменту, в [сервисе инструментов](/investAPI/head-instruments/) T-Invest API есть параметры `first_1min_candle_date` и `first_1day_candle_date`.

Они возвращаются в методах получения информации об инструментах. Параметр `first_1min_candle_date` возвращает дату первой минутной свечи, `first_1day_candle_date` — дату первой дневной свечи.

### Как узнать доступности торгов инструментом через API?

По параметру `api_trade_available_flag` в методах [getTradingStatus](/investAPI/marketdata/#gettradingstatus) или [FindInstrument](/investAPI/instruments/#findinstrument).

### Какой идентификатор инструмента использовать для получения данных в сервисе котировок?

Все методы сервиса котировок принимают на вход параметр `instrumentId`, в котором можно передать значение **instrument_uid** или **FIGI**.

[Подробнее об идентификаторах инструментов](/investAPI/faq_identification/)