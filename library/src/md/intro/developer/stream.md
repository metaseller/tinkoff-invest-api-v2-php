# Stream-соединения

В T-Invest API реализовано несколько Stream-соединений:

- [Стрим исполнения поручений пользователя](/invest/services/orders/head-orders/#stream) — для получения всех совершенных сделок.

- [Bidirectional-стрим получения биржевой информации](/invest/services/quotes/head-marketdata/#bidirectional-stream) — биржевая информация о стаканах, свечах и другие данные.

- [Server-side стрим](/invest/services/quotes/marketdata/#marketdatastreamservice) — соединение для трансляции биржевой информации клиентам, которые не поддерживают bidirectional-стримы.

## Ping

Во всех Stream-соединениях реализована проверка активности стрима. При использовании сервисов T-Invest API рекомендуем добавлять проверки на получение пинга.

### Значения Ping-responce сообщений для стримов

| Stream-соединение                                                                                                  | Ping интервал (ms)              |
|:-------------------------------------------------------------------------------------------------------------------|:--------------------------------|
| [Стрим исполнения поручений пользователя](/invest/services/orders/head-orders/#stream)                             | 120000                          |
| [Bidirectional-стрим получения биржевой информации](/invest/services/quotes/head-marketdata/#bidirectional-stream) | 120000                          |
| [Server-side стрим](/invest/services/quotes/marketdata/#marketdatastreamservice)                                   | 120000                          |

## WebSocket

Для получения стриминговых сообщений через WebSocket реализован отдельный сервис — у него своя лимитная политика.