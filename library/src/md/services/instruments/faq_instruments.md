---
sidebar_position: 4
---

# FAQ

### Что такое FIGI инструмента?

**FIGI** (Financial Instrument Global Identifier) — глобальный идентификатор
финансового инструмента. Представляет собой 12-символьный код из латинских букв и цифр и
определяется как идентификатор ценной бумаги на торговой площадке (бирже), которая
является некоторым «источником цен».

Учитывайте, что не у всех инструментов, которые доступны в Т-Инвестициях, есть общепринятый
FIGI — поэтому уникальность инструментов с другими источниками не гарантируется. 

Узнать актуальный FIGI-идентификатор инструмента можно через методы [сервиса инструментов](/invest/services/instruments/head-instruments).

:::caution
Сейчас основной идентификатор внутри Т-Инвестиций — UID. Он позволяет избежать возможной путаницы.
:::

### Как найти FIGI инструмента по его названию, тикеру или ISIN?

Через методы поиска инструментов по идентификатору — [BondBy](/invest/services/instruments/methods#bondby), 
[CurrencyBy](/invest/services/instruments/methods#currencyby), [EtfBy](/invest/services/instruments/methods#etfby), 
[FutureBy](/invest/services/instruments/methods#futureby), [ShareBy](/invest/services/instruments/methods#shareby). Они позволяют получить 
информацию об инструменте, зная его FIGI или связку **ticker** + **class_code**. 

Если вы не знаете эти идентификаторы, получить полный список инструментов определенного типа можно через методы запроса
списков инструментов — [Bonds](/invest/services/instruments/methods#bonds), [Currencies](/invest/services/instruments/methods#currencies), [Etfs](/invest/services/instruments/methods#etfs), [Futures](/invest/services/instruments/methods#futures), [Shares](/invest/services/instruments/methods#shares). Выполните поиск по
известным параметрам самостоятельно — это можно сделать в коде робота или через любый доступный gRPC-клиент,
например, Kreya. [Инструкция по настройке Kreya](/invest/intro/developer/protocols/grpc#kreya).

### Что такое `class_code` и где его найти?

**class_code** — это технический параметр «Режим торгов». Используется для обозначения секции биржи, на
которой торгуется инструмент. 

Чтобы его узнать, получите детали по инструменту через методы [сервиса инструментов](/invest/services/instruments/head-instruments).

### Как понять, что бумага доступна для торговли через T-Invest API?

Чтобы получить все доступные для торговли инструменты определенного типа, передайте параметр **instrument_status** = **INSTRUMENT_STATUS_BASE** в нужном методе: 

* [Bonds](/invest/services/instruments/methods#bonds).
* [Currencies](/invest/services/instruments/methods#currencies).
* [Etfs](/invest/services/instruments/methods#etfs).
* [Futures](/invest/services/instruments/methods#futures).
* [Shares](/invest/services/instruments/methods#shares).

Если вам не нужно получать полный список инструментов, используйте параметр **api_trade_available_flag** из ответа методов получения инструмента по его идентификатору — [BondBy](/invest/services/instruments/methods#bondby), [CurrencyBy](/invest/services/instruments/methods#currencyby), [EtfBy](/invest/services/instruments/methods#etfby), [FutureBy](/invest/services/instruments/methods#futureby), [ShareBy](/invest/services/instruments/methods#shareby). Он отвечает за доступность инструмента для торгов через T-Invest API.

Также учитывайте расписание работы бирж и торговый статус инструмента. [Подробнее](/invest/intro/intro/faq_trading_status).

### Что такое накопленный купонный доход облигации и как его узнать?

**Купон, или купонный доход** — это процентные выплаты держателям облигаций со стороны эмитента, то есть
компании или госоргана, выпустивших этот тип ценных бумаг.

Даты выплат процентов по облигациям и размер купона известны заранее. Размер купона задается в процентах от
номинала — то есть от цены облигации при ее выпуске. Величина купона может быть фиксированной или плавающей —
привязанной к инфляции, ключевой ставке Центробанка России или другим ориентирам. Иногда у облигации
может не быть купона. [Купонный доход по облигациям](https://www.tbank.ru/invest/account/help/get-profit/coupon-yield).

Получить календарь купонных выплат можно через метод [GetAccruedInterests](/invest/services/instruments/methods#getaccruedinterests).

### Как узнать стоимость шага цены (min_price_increment_amount) фьючерса?

Этот параметр может изменяться довольно часто в течение дня, поэтому для его получения есть 
отдельный метод сервиса инструментов — [GetFuturesMargin](/invest/services/instruments/methods#getfuturesmargin).

### Как узнать, на какой бирже исполняются расчеты по инструменту?

В T-Invest API есть параметр [real_exchange](/invest/services/instruments/methods#realexchange) — он передается для определения биржи, на которой исполняются расчеты
по финансовому инструменту.

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
* [CurrencyBy](/invest/services/instruments/methods#currencyby) — получить валюту по ее идентификатору.
* [Currencies](/invest/services/instruments/methods#currencies) — получить список валют.
* [OptionBy](/invest/services/instruments/methods#optionby) — получить опцион по его идентификатору.
* [OptionsBy](/invest/services/instruments/methods#optionsby) — получить список опционов по идентификатору базового актива.
* [Options](/invest/services/instruments/methods#options) — получить опционы.

### Как найти базовый актив фьючерса? <a id="1.8"></a>

Чтобы найти базовый актив фьючерса, можно использовать метод [FindInstrument](/invest/services/instruments/methods#findinstrument) — для этого в **query** передайте 
значение параметра **basic_asset_position_uid**, которое возвращается в методах [GetFutureBy](/invest/services/instruments/methods#futureby) и [GetFutures](/invest/services/instruments/methods#futures).

### Как получить и изменить список избранных инструментов?

<ul>
<li><p>Список избранных инструментов можно получить через метод <a href="/invest/services/instruments/methods#getfavorites">GetFavorites</a> — в ответе возвращаются инструменты, которые робот добавил в избранное через метод <a href="/invest/services/instruments/methods#editfavorites">EditFavorites</a>.</p>
</li>
<li><p>Добавить или удалить инструменты из списка избранных можно через метод <a href="/invest/services/instruments/methods#editfavorites">EditFavorites</a>. С помощью него можно автоматизировать выделение наиболее интересных инструментов через редактирование списка избранных инструментов.</p>
<p> Ограничение на использование метода — 100 инструментов. Если вы передадите больше 100 инструментов, вернется ошибка с кодом <code>30091</code> и сообщением <code>quantity of instruments can&#39;t be more than 100</code>.</p>
</li>
</ul>

:::caution
<p>Если вы хотите добавить валюту в список избранных инструментов, это нужно делать через валюту с лотностью 1. Инструменты валюты с разной лотностью имеют разные значения идентификаторов.</p>
<p>У позиции (валюты) есть разные инструменты, которыми можно торговать. Например, у доллара это могут быть инструменты с лотностью в 1 доллар или 1000 долларов.</p>
<p>Примеры идентификаторов:</p>
<ul>
<li>FIGI доллара США с лотностью <code>1000</code> — <code>TCS0013HGFT4</code>, а FIGI доллара США с лотностью <code>1</code> — <code>USD000UTSTOM</code>.</li>
<li>FIGI евро с лотностью <code>1000</code> — <code>BBG0013HJJ31</code>, а FIGI доллара США с лотностью <code>1</code> — <code>EUR000UTSTOM</code>.</li>
</ul>
:::

### Как отличить инструмент доступный для ИИС?

В методах для получения информации об инструментах есть флаг **for_iis_flag** — он принимает булевое значение в
зависимости от доступности инструмента для ИИС.

### Как получить информацию об активах?

<p>В T-Invest API есть два метода для получения активов:</p>
<ol>
<li><p><a href="/invest/services/instruments/methods#getassets">getAssets</a> — получить список всех активов. Метод работает для всех инструментов, кроме срочных: опционов и фьючерсов. Возвращает краткую информацию об активе: </p>
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

### Как получить информацию об брендах?

В T-Invest API есть два метода для получения брендов:

1. [Brands](/invest/services/instruments/methods#getbrands) — получить список всех брендов.

2. [BrandBy](/invest/services/instruments/methods#getbrandby) — найти бренд по его идентификатору.

### Как по позиции найти инструмент? 

Для поиска инструмента по идентификатору позиции (**position_uid**) есть тип идентификатора инструмента — **INSTRUMENT_ID_TYPE_POSITION_UID**.

Использовать `id_type = INSTRUMENT_ID_TYPE_POSITION_UID` можно в методах:

* [InstrumentBy](/invest/services/instruments/methods#getinstrumentby) — получить основную информацию об инструменте.
* [BondBy](/invest/services/instruments/methods#bondby) — получить облигацию по ее идентификатору.
* [ShareBy](/invest/services/instruments/methods#shareby) — получить акцию по ее идентификатору.
* [EtfBy](/invest/services/instruments/methods#etfby) — получить инвестиционный фонд по его идентификатору.
* [FutureBy](/invest/services/instruments/methods#futureby) — получить фьючерс по его идентификатору.
* [OptionBy](/invest/services/instruments/methods#optionby) — получить опцион по его идентификатору.
* [CurrencyBy](/invest/services/instruments/methods#currencyby) — получить валюту по ее идентификатору.

### Ставки риска и их коэффициенты 

Чтобы лучше понять тему, вы можете ознакомиться с материалами, указанными в ссылках. Здесь мы приведем лишь краткое определения и раскроем суть параметров.

**Ставка риска** — показатель, используемый брокером для расчета суммы, которую вам нужно иметь на счете, чтобы
открыть или поддерживать непокрытую позицию. Чем ниже ставка риска, тем крупнее может быть непокрытая позиция — то есть
брокер будет готов одолжить больше активов. И наоборот: с высокой ставкой риска размер кредитного плеча в сделке будет
небольшим или его не будет вообще. [Подробнее о ставках риска](https://www.tbank.ru/invest/help/brokerage/account/margin/about/#q5).

**Уровни риска**.  Клиенты российских брокеров — физические лица — делятся на несколько категорий. 
Каждой категории соответствует свое кредитное плечо. 
В методах сервиса инструментов в параметрах **dshort_client** и **dlong_client** передается ставка риска уже с учетом категории.

**Кредитное плечо** — беспроцентный заем, который брокер предоставляет инвестору для совершения сделок на более крупные
суммы. Это соотношение между собственными средствами трейдера и заемными деньгами, которые предоставляет брокер или 
дилинговый центр на специальных условиях.

**Начальная маржа** — стоимость всех ликвидных активов и фьючерсов в портфеле инвестора, приведенная к рублям по
биржевому курсу и умноженная на ставки риска этих активов.

**Скорректированная маржа** — показатель, аналогичный начальной марже, но учитывающий выставленные вами лимитные заявки
на увеличение позиции (на любую покупку или на продажу в шорт).

**Минимальная маржа** — половина от начальной или скорректированной маржи портфеля.

**Лонг, или длинная позиция** — это сделка по покупке актива, когда инвестор ожидает роста его цены. Если инвесторы 
хотят заработать на растущем рынке, они торгуют в лонг. 

**Шорт, или короткая позиция** — это сделка по продаже полученного в долг актива с целью выкупа его дешевле через 
некоторое время и заработка на разнице цен. Когда инвесторы хотят получить прибыль за счет снижения стоимости актива,
они торгуют в шорт — также это называется «игрой на понижение» или «непокрытой продажей». [Подробнее о торговле в шорт](https://www.tbank.ru/invest/help/brokerage/account/margin/short/).

<p>В методах сервиса инструментов есть параметры, связанные со ставками риска:</p>
<ul>
<li><p><b>klong</b> — коэффициент ставки риска длинной позиции по клиенту:</p>
<ul>
<li>2 — клиент со стандартным уровнем риска (КСУР);</li>
<li>1 — клиент с повышенным уровнем риска (КПУР).</li>
</ul>
</li>
<li><p><b>kshort</b> — коэффициент ставки риска короткой позиции по клиенту:</p>
<ul>
<li>2 – клиент со стандартным уровнем риска (КСУР);</li>
<li>1 – клиент с повышенным уровнем риска (КПУР).</li>
</ul>
</li>
<li><p><b>dlong</b> — ставка риска начальной маржи для КСУР лонг.  </p>
</li>
<li><b>dshort</b> — ставка риска начальной маржи для КСУР шорт.  </li>
<li><b>dlong_min</b> — ставка риска начальной маржи для КПУР лонг.  </li>
<li><b>dshort_min</b> — ставка риска начальной маржи для КПУР шорт.  </li>
</ul>

Коэффициенты маржинальной торговли есть только у инструментов из [перечня ликвидного имущества](https://www.tbank.ru/invest/margin/equities/).

### Как узнать, торгуется ли инструмент на выходных? 

В методах инструментов есть флаг **weekend_flag**:

- `true` — инструмент торгуется;
- `false` — инструмент не торгуется.

### Какие заявки можно выставить по опционам? 

Сейчас торговля опционами через API недоступна. 

### Что такое `liquidity_flag`? 

**Ликвидность** — это способность быстро продать актив по рыночной цене, то есть без скидок. Чем быстрее это можно сделать, тем выше ликвидность актива. 

   Ликвидность инструмента на фондовом рынке оценивают по количеству совершаемых сделок — то есть по объему торгов — и величине спреда. 

**Спред** — это разница между максимальными ценами заявок на покупку и минимальными ценами заявок на продажу. Чем больше сделок и меньше разница, тем выше ликвидность.

Раз в полчаса брокер рассчитывает ликвидность по всем финансовым инструментам: 

- Для облигаций **liquidity** = `((Среднедневная цена * current_nominal)/100) * (Дневной объем торгов)`.
- В остальных случаях **liquidity** = `(Среднедневная цена) * (Дневной объем торгов)`.

На основе значения **liqudity** для разных типов финансовых инструментов устанавливается значение флага **liquidity_flag**:

- `true` — инструмент считается ликвидным;
- `false` — инструмент не считается ликвидным.

### Корпоративные действия и изменение идентификатора инструмента 

**Корпоративные действия** — это события, связанные с ценной бумагой: например, сплит, консолидация, конвертация и другие.  Каждое корпоративное действие индивидуально и имеет свои условия.

Некоторые корпоративные действия приводят к изменению инструмента и его параметров на бирже — новый тикер, изменение лотности, шага цены, стоимости. После таких событий:

* создается новый инструмент с новыми идентификаторами — FIGI, UID;
* позиция переносится на новый инструмент;
* операции начинают проводиться по созданному инструменту;
* старый инструмент помечается удаленным и становится недоступен в API;
* исторические данные по инструменту, который существовал до корпоративного действия, больше недоступны.

### Как скачать логотип компании? 

В методах [GetBondBy](/invest/services/instruments/methods#bondby), [GetBonds](/invest/services/instruments/methods#bonds), [GetShareBy](/invest/services/instruments/methods#shareby), [GetShares](/invest/services/instruments/methods#shares),
[GetEtfBy](/invest/services/instruments/methods#etfby), [GetEtfs](/invest/services/instruments/methods#etfs), [GetFutureBy](/invest/services/instruments/methods#futureby), [GetFutures](/invest/services/instruments/methods#futures),
[GetCurrencyBy](/invest/services/instruments/methods#currencyby) и [GetCurrencies](/invest/services/instruments/methods#currencies) есть информация о бренде, в том числе логотип компании.

Чтобы скачать логотип, сформируйте запрос вида `https://invest-brands.cdn-tinkoff.ru/<logoName<size>.png>`, где `<logoName<size>.png>` — логотип компании с размерами в точках. Доступные размеры — 160x, 320x, 640x.

**Пример** 

Логотип компании TCS Group — `US87238U20333.png`. Запрос будет одним из следующих:

| Размер логотипа |                                                       Запрос                                                             |
|:----------------|:-------------------------------------------------------------------------------------------------------------------------|
|       160x     | [https://invest-brands.cdn-tinkoff.ru/US87238U20333x160.png](https://invest-brands.cdn-tinkoff.ru/US87238U20333x160.png) |
|       320x      | [https://invest-brands.cdn-tinkoff.ru/US87238U20333x320.png](https://invest-brands.cdn-tinkoff.ru/US87238U20333x320.png) |
|       640x      | [https://invest-brands.cdn-tinkoff.ru/US87238U20333x640.png](https://invest-brands.cdn-tinkoff.ru/US87238U20333x640.png) |