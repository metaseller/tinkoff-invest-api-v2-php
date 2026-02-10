---
sidebar_position: 5
---

# FAQ
### Можно ли узнать идентификатор поручения из операции? 

Нет, сейчас такой информации в операции нет, но мы работаем над этим. 

### Почему в операции пустой FIGI? 

Такое может быть у операций внесения денежных средств и подобных — у них нет связанного с операцией биржевого
инструмента.

### Будут ли отображаться операции по бумагам, которые прошли делистинг?

Да. Также операции по бумагам будут отображаться после различных [корпоративных действий](/invest/intro/useful-info/faq_corp_action).

### Параметр `quantity` передается в лотах или количествах?

В рамках сервиса операций параметр **quantity** всегда передается в количестве штук инструмента.

### Как с помощью T-Invest API получить брокерский отчет? 

Через метод [GetBrokerReport](/invest/services/operations/methods#getbrokerreport).

Обратите внимание: получение брокерского отчета асинхронно — сначала вы запрашиваете формирование
отчета, отправляя пакет [generate_broker_report_request](/invest/services/operations/methods#generatebrokerreportrequest), и
получаете идентификатор задачи формирования отчета — параметр **task_id.** После этого можно запрашивать
отчет по его идентификатору. 

Если формирование отчета еще не закончено, вы получите соответствующее сообщение об ошибке.

[Подробнее о брокерском отчете](https://www.tbank.ru/invest/account/help/trade-on-bs/get-report/)

### Как получить информацию о позициях и доходности портфеля?

Одним из способов:

- Подпишитесь на [PortfolioStream](/invest/services/operations/methods#portfoliostream). В стриме не отображаются бумаги, заблокированные биржей. 
- Используйте методы [GetPortfolio](/invest/services/operations/methods#getportfolio) и [GetPossitions](/invest/services/operations/methods#getpositions). Через них также можно получить бумаги, заблокированные биржей. 

### Как получить информацию об операциях?

Через [getOperationsByCursor](/invest/services/operations/methods#getoperationsbycursor). Метод возвращает постраничную информацию обо всех операциях, в том числе отмененных, поддерживает пагинацию и расширенную фильтрацию.
Во входных параметрах запроса достаточно указать только **account_id**.

Также в T-Invest API есть метод [getOperations](/invest/services/operations/methods#getoperations) — это более старая версия [getOperationsByCursor](/invest/services/operations/methods#getoperationsbycursor). Мы рекомендуем использовать [getOperationsByCursor](/invest/services/operations/methods#getoperationsbycursor).

:::caution
Метод [getOperations](/invest/services/operations/methods#getoperations) возвращает только последнюю тысячу операций.
:::

### Как понять, какие бумаги в портфеле заблокированы по решению ЦБ?

В методах [getPortfolio](/invest/services/operations/methods#getportfolio) и [getPositions](/invest/services/operations/methods#getpositions) есть специальные булевы параметры **exchange_blocked** и **blocked**. Они принимают значение `true`, если инструмент заблокирован депозитарием.

### В чем различие между параметрами `positions.blocked` и `positions.blocked_lots` в методе [getPortfolio](/invest/services/operations/methods#getportfolio)? 

- **positions.blocked_lots** — количество заблокированных бумаг на счете. Используется при выставлении лимитных заявок. 
- **positions.blocked** — булевый параметр. Отображает, заблокирован ли инструмент депозитарием.

### Что за значения приходят в `positions.expectedYield` в методе [getPortfolio](/invest/services/operations/methods#getportfolio)?

В параметрах **positions.expectedYield** и **positions.expectedYieldFifo** возвращается значение текущей рассчитанной доходности позиции — это значение в валюте инструмента.