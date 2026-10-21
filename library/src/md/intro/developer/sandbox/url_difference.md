---
sidebar_position: 2
---

# Песочница и prod

Адреса для вызова методов: 

- На продовом контуре — `invest-public-api.tbank.ru:443`.

- В песочнице — `sandbox-invest-public-api.tbank.ru:443`.

В песочнице вы можете выполнять практически те же запросы, что и на prod-контуре. Это сделано для поддержания единообразия 
кода и легкости перехода из песочницы на prod.

[Подробнее про различия контуров](/invest/intro/developer/sandbox/)

Исключения в работе методов и сервисов:

| Сервисы                                                                                     | Prod-контур | Песочница |
|---------------------------------------------------------------------------------------------|-------------|-----------|
| [Сервис инструментов](/invest/services/instruments/head-instruments/)                       | Да          | Да        |
| [Сервис аккаунтов](/invest/services/accounts/head-account/)                                 | Да          | Да        |
| [getMarginAttributes](/invest/services/accounts/users#getmarginattributes)                  | Да          | Да        |
| [Сервис операций](/invest/services/operations/head-operations/)                             | Да          | Да        |
| [getBrokerReport](/invest/services/operations/methods#/#getbrokerreport)                    | Да          | Нет       |
| [PortfolioStream](/invest/services/operations/methods#/#portfoliostream)                    | Да          | Да        |
| [PositionsStream](/invest/services/operations/methods#/#positionsstream)                    | Да          | Да        |
| [getDividendsForeignIssuer](/invest/services/operations/methods##getdividendsforeignissuer) | Да          | Нет       |
| [getWithdrawLimits](/invest/services/operations/methods##getwithdrawlimits)                 | Да          | Да        |
| [Сервис котировок](/invest/services/quotes/head-marketdata/)                                | Да          | Да        |
| [Сервис стоп-заявок](/invest/services/stop-orders/head-stoporders/)                         | Да          | Да        |
| [Песочницы](/invest/intro/developer/sandbox//)                                              | Да          | Да        |
| [Сервис торговых поручений](/invest/services/orders/head-orders/)                           | Да          | Да        |
| [TradeStream](/invest/services/orders/methods#tradesstream)                                 | Да          | Да        |
| [OrderStateStream](/invest/services/orders/methods#orderstatestream)                        | Да          | Да        |
