---
sidebar_position: 1
---

# Описание

Справочная информация о ценных бумагах.

## Получить параметры ценных бумаг

Первоочередная задача, которая стоит перед разработчиком торгового робота — получить справочную информацию об инструментах, 
торгуемых на бирже. Для этого в T-Invest API есть unary-методы. 

:::caution
Методы разделены по типам инструментов — акции, облигации, фонды и другие. Например, чтобы получить:
- список облигаций — используйте метод [Bonds](/invest/services/instruments/methods#bonds);
- информацию по конкретной облигации — [BondBy](/invest/services/instruments/methods#bondby).
:::

В методах для получения информации по конкретному инструменту в качестве идентификатора можно использовать 
FIGI, ISIN или связку тикер плюс класс-код. [Подробнее об особенностях идентификации инструментов](/invest/intro/intro/faq_identification/).

## Получить расписание торгов 

Чтобы определить время запуска или остановки торгового робота, разработчику также нужно учитывать 
расписание торгов на той или иной торговой площадке внутри брокера. [Подробнее о режимах торгов](/invest/intro/useful-info/markets).

Расписание торгов по конкретной бирже и по всему списку доступных торговых площадок в T-Invest API можно получить через 
метод [TradingSchedules](/invest/services/instruments/methods#tradingschedules). 

Расписание торгов можно получить на период не более одной недели с текущего дня — расписания в прошлом недоступны.

:::caution
Расписание торгов может меняться из-за внешних обстоятельств — специалисты Т-Инвестиций стараются максимально 
оперативно реагировать на такие изменения. Лучше не ориентироваться на расписание, запрошенное по длительному периоду, 
а запрашивать режимы торгов на более короткие интервалы — например, на текущий день.
:::

Также учитывайте, что в процессе работы торговой площадки торги по той или иной ценной бумаге могут 
приостанавливаться — например, из-за резко возросшей волатильности. Поэтому для определения доступности торгов в данный 
момент по конкретному инструменту лучше использовать параметр **trading_status**, который возвращается в рамках подписки 
на получение статуса инструмента [сервиса котировок](/invest/services/quotes/head-marketdata).

:::caution
Метод [TradingSchedules](/invest/services/instruments/methods#tradingschedules) возвращает торговое расписание на секции биржи внутри 
брокера. Это расписание может не совпадать с реальным расписанием торгов на бирже.
:::

## Получить расписания выплаты купонов по облигациям

Облигация — это долговая ценная бумага, почти как долговая расписка. Выпуская облигации, компания 
или государство берет деньги в долг и возвращает их с процентами. [Подробнее про облигации](https://www.tbank.ru/invest/help/educate/how-it-works/ways-to-invest/bonds/).

Купоны — это операции по регулярным выплатам процентов по облигации. Чтобы получить график выплаты купонов для запрошенного
периода времени, используйте метод [getAccruedInterests](/invest/services/instruments/methods#getaccruedinterests). 

## Получить размер гарантийного обеспечения (ГО) по фьючерсу

Фьючерс — это договор между покупателем и продавцом о поставке базового актива в будущем или выплате 
одной из сторон другой разницы между стоимостью контракта и стоимостью базового актива в 
будущем. [Подробнее про срочный рынок](https://www.tbank.ru/invest/help/brokerage/account/forts/).

Для операций с фьючерсами брокер «замораживает» определенный размер гарантийного обеспечения на счете
пользователя. Чтобы получить информацию о размере обеспечения, используйте методы [Futures](/invest/services/instruments/methods#futures), [FutureBy](/invest/services/instruments/methods#futureby) и
[getFuturesMargin](/invest/services/instruments/methods#getfuturesmargin).

Параметры **initial_margin_on_buy** и **initial_margin_on_sell** возвращают гарантийное обеспечение, рассчитанное биржей, а коэффициенты **dshort_client** и **dlong_client** определяют сумму заблокированных брокером средств при торговле фьючерсами.

:::caution
Метод возвращает примерное значение средств к блокировке, которое рассчитывается биржей.
Это значение не является конечным резервируемым объемом ГО — после заключения сделки заблокированная сумма может измениться.

Точную сумму денежных средств, которые блокируются брокером, можно посчитать через параметры **dshort_client** и **dlong_client** — они
определяют коэффициент блокируемых средств от суммы сделки.
:::

## Инструменты
### Получить и изменить список избранных инструментов

Список избранных инструментов можно получить через метод [GetFavorites](/invest/services/instruments/methods#getfavorites) — в ответе возвращаются инструменты, которые
робот добавил в избранное через метод [EditFavorites](/invest/services/instruments/methods#editfavorites).

Чтобы добавить или удалить инструменты из списка избранных, используйте метод [EditFavorites](/invest/services/instruments/methods#editfavorites). С помощью него можно 
автоматизировать выделение наиболее интересных инструментов через редактирование списка избранных инструментов.

Ограничение на использование метода — 100 инструментов. Если вы передадите больше 100 инструментов, вернется ошибка с 
кодом `30091` и сообщением `quantity of instruments can't be more than 100`.

:::caution
<p>Если вы хотите добавить валюту в список избранных инструментов, это нужно делать через валюту с лотностью 1.
Инструменты валюты с разной лотностью имеют разные значения идентификаторов.</p>
<p>У позиции (валюты) есть разные инструменты, которыми можно торговать. Например, у доллара это могут быть инструменты с
лотностью в 1 доллар или 1000 долларов.</p>
<p>Примеры идентификаторов:</p>
<ul>
<li>FIGI доллара США с лотностью <code>1000</code> — <code>TCS0013HGFT4</code>, а FIGI доллара США с лотностью <code>1</code> — 
<code>USD000UTSTOM</code>.</li>
<li>FIGI евро с лотностью <code>1000</code> — <code>BBG0013HJJ31</code>, а FIGI доллара США с лотностью <code>1</code> — 
<code>EUR000UTSTOM</code>.</li>
</ul>
:::

Все инструменты, которые вы добавили в избранное, будут отображаться в списке избранных в мобильном приложении Инвестиций 
и на сайте [Т-Инвестиции](https://www.tbank.ru/invest/favorites/).

### Определить биржу, на которой исполняются расчеты по инструменту

В T-Invest API есть параметр [real_exchange](/invest/services/instruments/methods#realexchange) — он передается для определения биржи, на которой исполняются расчеты по
финансовому инструменту.

Список методов:

* [GetInstrumentBy](/invest/services/instruments/methods#getinstrumentby) — получить основную информацию об инструменте.
* [BondBy](/invest/services/instruments/methods#bondby) — получить облигацию по ее идентификатору.
* [Bonds](/invest/services/instruments/methods#bonds) — получить список облигаций.
* [ShareBy](/invest/services/instruments/methods#shareby) — получить акцию по ее идентификатору.
* [Shares](/invest/services/instruments/methods#shares) — получить список акций.
* [EtfBy](/invest/services/instruments/methods#etfby) — получить инвестиционный фонд по его идентификатору.
* [Etfs](/invest/services/instruments/methods#etfs) — получить список инвестиционных фондов.
* [FutureBy](/invest/services/instruments/methods#futureby) — получить фьючерс по его идентификатору.
* [Futures](/invest/services/instruments/methods#futures) — получить список фьючерсов.
* [OptionBy](/invest/services/instruments/methods#optionby) — получить опцион по его идентификатору.
* [OptionsBy](/invest/services/instruments/methods#optionsby) и [Options](/invest/services/instruments/methods#options) — получить список опционов.
* [CurrencyBy](/invest/services/instruments/methods#currencyby) — получить валюту по ее идентификатору.
* [Currencies](/invest/services/instruments/methods#currencies) — получить список валют.

### Найти инструменты

Для поиска инструментов в T-Invest API используйте следующие методы — в зависимости от типа искомого инструмента:

* [GetInstrumentBy](/invest/services/instruments/methods#getinstrumentby) — получить основную информацию об инструменте.
* [BondBy](/invest/services/instruments/methods#bondby) — получить облигацию по ее идентификатору.
* [Bonds](/invest/services/instruments/methods#bonds) — получить список облигаций.
* [ShareBy](/invest/services/instruments/methods#shareby) — получить акцию по ее идентификатору.
* [Shares](/invest/services/instruments/methods#shares) — получить список акций.
* [EtfBy](/invest/services/instruments/methods#etfby) — получить инвестиционный фонд по его идентификатору.
* [Etfs](/invest/services/instruments/methods#etfs) — получить список инвестиционных фондов.
* [FutureBy](/invest/services/instruments/methods#futureby) — получить фьючерс по его идентификатору.
* [Futures](/invest/services/instruments/methods#futures) — получить список фьючерсов.
* [OptionBy](/invest/services/instruments/methods#optionby) — получить опцион по его идентификатору.
* [OptionsBy](/invest/services/instruments/methods#optionsby) и [Options](/invest/services/instruments/methods#options) — получить список опционов.
* [CurrencyBy](/invest/services/instruments/methods#currencyby) — получить валюту по ее идентификатору.
* [Currencies](/invest/services/instruments/methods#currencies) — получить список валют.
* [Indicatives](/invest/services/instruments/methods#indicatives) — получить список индексов и товаров.

Также у нас есть метод поиска инструмента по различным параметрам — [FindInstrument](/invest/services/instruments/methods#findinstrument). Он выполняет регистронезависимый
поиск по вхождению строки **query** согласно приоритету:

* `position_uid`;
* `uid`;
* `figi`;
* `isin`;
* `ticker`;
* `name`.

Чтобы найти базовый актив фьючерса, можно использовать метод [FindInstrument](/invest/services/instruments/methods#findinstrument) — для этого в **query** передайте значение 
параметра `basic_asset_position_uid`, которое возвращается в методах [GetFutureBy](/invest/services/instruments/methods#futureby) и [GetFutures](/invest/services/instruments/methods#futures).

### Посмотреть доступность торговли инструмента через API

Чтобы получить информацию о возможности торговли инструментом через API, используйте метод [FindInstrument](/invest/services/instruments/methods#findinstrument). 

В нем есть параметр **api_trade_available_flag** — если **api_trade_available_flag = true**, торговать инструментом через API можно.

### Получить справочник стран

Чтобы получить справочник стран, используйте метод [getCountries](/invest/services/instruments/methods#getcountriesrequest).
Он возвращает массив объектов с двухбуквенными и трехбуквенными кодами страны, а также ее полное и краткое название.

Полученный список стран можно применять для сопоставления страны риска актива.

### Получить активы

<p>В T-Invest API есть два метода для получения активов:</p>
<ol>
<li><p><a href="/invest/services/instruments/methods#getassets">getAssets</a> — получить список всех активов. Метод работает для все
х инструментов, кроме срочных: опционов и фьючерсов. Возвращает краткую информацию об активе: </p>
<ul>
<li>Идентификатор.</li>
<li>Тип актива.</li>
<li>Название актива.</li>
<li>Массив инструментов актива.</li>
</ul>
</li>
<li><p><a href="/invest/services/instruments/methods#getassetby">getAssetBy</a> — найти актив по его идентификатору.
Метод возвращает более подробную информацию о запрошенном активе. Набор данных отличается в зависимости от типа актива.</p>
</li>
</ol>

### Получить бренды 

В T-Invest API есть два метода для получения брендов:

1. [getBrands](/invest/services/instruments/methods#getbrands) — получить список всех брендов.

2. [getBrandBy](/invest/services/instruments/methods#getbrandby) — найти бренд по его идентификатору.

### Получить индикативные инструменты

Через метод [Indicatives](/invest/services/instruments/methods#indicatives) можно получить информацию об активах, которые не торгуются на бирже — например, по индексу 
IMOEX или нефти.

С идентификатором такого актива можно построить свечи через метод [getCandles](/invest/services/quotes/marketdata/#getcandles), как для других инструментов. Для 
построения свечей по индикативам в качестве идентификатора лучше использовать **UID**.

### Найти инструмент по позиции

Для поиска инструмента по идентификатору позиции (**position_uid**) есть тип идентификатора инструмента — **INSTRUMENT_ID_TYPE_POSITION_UID**.

Использовать `id_type = INSTRUMENT_ID_TYPE_POSITION_UID` можно в методах:

* [InstrumentBy](/invest/services/instruments/methods#getinstrumentby) — получить основную информацию об инструменте.
* [BondBy](/invest/services/instruments/methods#bondby) — получить облигацию по ее идентификатору.
* [ShareBy](/invest/services/instruments/methods#shareby) — получить акцию по ее идентификатору.
* [EtfBy](/invest/services/instruments/methods#etfby) — получить инвестиционный фонд по его идентификатору.
* [FutureBy](/invest/services/instruments/methods#futureby) — получить фьючерс по его идентификатору.
* [OptionBy](/invest/services/instruments/methods#optionby) — получить опцион по его идентификатору.
* [CurrencyBy](/invest/services/instruments/methods#currencyby) — получить валюту по ее идентификатору.

### Получить информацию по опционам

Для получения информации по опционам, страйкам и датам экспирации в T-Invest API есть следующие методы:

- [GetOptionBy](/invest/services/instruments/methods#optionby) — получить опцион по его идентификатору.
- [GetOptions](/invest/services/instruments/methods#options) — получить опционы.
- [getPositions](/invest/services/operations/methods#getpositions) — получить массив опционов в портфеле.

Также вы можете получить информацию о базовом активе опциона и найти его по идентификатору позиции базового инструмента — **basicAssetPositionUid**. 

:::caution
Сейчас через метод [FindInstrument](/invest/services/instruments/methods#findinstrument) получить информацию об опционах нельзя.
:::

### Получить торговые статусы инструментов и расписание торгов

[Статусы торговых инструментов и расписания торгов](/invest/intro/intro/faq_trading_status)

Также рекомендуем смотреть актуальную информацию по режимам и статусам торгов на сайтах [Московской биржи](https://www.moex.com/) и [СПБ биржи](https://spbexchange.ru/). 

### Определить доступность торговли инструментом квалифицированному инвестору

В методах сервиса инструментов есть флаг **for_qual_investor_flag** — он нужен, чтобы определить доступность торговли 
инструментом для неквалифицированных инструментов.

Флаг отображает доступность торговли инструментом только для квалифицированных инвесторов.

### Получить график выплаты дивидендов по инструменту

Чтобы получить информацию по срокам выплаты дивидендов по инструменту, используйте метод [getDividends](/invest/services/instruments/methods#getdividends).

Учитывайте, что входной параметр **to** (окончание запрашиваемого периода в часовом поясе UTC) фильтрует выходные данные 
по параметру **record_date** — дате фиксации реестра. 

### Получить фундаментальные показатели компаний

Метод [getAssetFundamentals](/invest/services/instruments/methods#getassetfundamentals) возвращает показатели компании по активу — как правило, акции компании. 

Обычно данные обновляются на следующий рабочий день после публикации, в редких случаях это может занять более недели. Информация доступна не по всем активам.

Ряд фундаментальных показателей, которые доступны в методе, могут не публиковаться компаниями или быть недоступными.
Некоторые значения зависят от финансового результата, например:

- **pe_ratio_ttm** — показывает соотношение рыночной капитализации компании к ее чистой прибыли только при наличии прибыли;

- **price_to_sales_ttm** — не рассчитывается при отсутствии выручки;

- **ebitda_ttm** — не рассчитывается для некоторых секторов экономики.

Метод возвращает все параметры контракта. Значение `0` в ответе следует приравнивать к отсутствию данных. 

## Пагинация

В ряде методов сервиса используется пагинация. Структура **paging**:

Запрос:

| Поле | Тип             | Описание |
| ----- |-----------------| ----------- |
| **limit** | [int32](#int32) | Количество запрашиваемых записей |
| **page_number** | [int32](#int32) | Номер страницы |


Ответ:

| Поле | Тип             | Описание |
| ----- |-----------------| ----------- |
| **limit** | [int32](#int32) | Количество запрашиваемых записей |
| **page_number** | [int32](#int32) | Номер страницы |
| **total_count** | [int32](#int32) | Всего записей |
