---
sidebar_position: 1
---

# Методы
## Методы SandboxService
Методы для работы с песочницей T-Invest API.

### OpenSandboxAccount
Зарегистрировать счет.

- Тело запроса — [OpenSandboxAccountRequest](#opensandboxaccountrequest)

- Тело ответа — [OpenSandboxAccountResponse](#opensandboxaccountresponse)


### GetSandboxAccounts
Счета пользователя.

- Тело запроса — [GetAccountsRequest](#getaccountsrequest)

- Тело ответа — [GetAccountsResponse](#getaccountsresponse)


### CloseSandboxAccount
Закрыть счет.

- Тело запроса — [CloseSandboxAccountRequest](#closesandboxaccountrequest)

- Тело ответа — [CloseSandboxAccountResponse](#closesandboxaccountresponse)


### PostSandboxOrder
Выставить заявку.

- Тело запроса — [PostOrderRequest](#postorderrequest)

- Тело ответа — [PostOrderResponse](#postorderresponse)



### PostSandboxOrderAsync
PostSandboxOrderAsync — выставить заявку асинхронным методом
Особенности работы приведены в [статье](/invest/services/orders/async).

- Тело запроса — [PostOrderAsyncRequest](#postorderasyncrequest)

- Тело ответа — [PostOrderAsyncResponse](#postorderasyncresponse)



### ReplaceSandboxOrder
Изменить выставленную заявку.

- Тело запроса — [ReplaceOrderRequest](#replaceorderrequest)

- Тело ответа — [PostOrderResponse](#postorderresponse)


### GetSandboxOrders
Получить список активных заявок по счету.

- Тело запроса — [GetOrdersRequest](#getordersrequest)

- Тело ответа — [GetOrdersResponse](#getordersresponse)


### CancelSandboxOrder
Отменить заявку.

- Тело запроса — [CancelOrderRequest](#cancelorderrequest)

- Тело ответа — [CancelOrderResponse](#cancelorderresponse)


### GetSandboxOrderState
Получить статус заявки. Заявки в песочнице хранятся 7 дней.

- Тело запроса — [GetOrderStateRequest](#getorderstaterequest)

- Тело ответа — [OrderState](#orderstate)


### GetSandboxOrderPrice
GetSandboxOrderPrice — получить предварительную стоимость для лимитной заявки.

- Тело запроса — [GetOrderPriceRequest](#getorderpricerequest)

- Тело ответа — [GetOrderPriceResponse](#getorderpriceresponse)


### GetSandboxPositions
Список позиций по виртуальному счету.

- Тело запроса — [PositionsRequest](#positionsrequest)

- Тело ответа — [PositionsResponse](#positionsresponse)


### GetSandboxOperations
Получить операции по счету.
При работе с методом учитывайте [особенности взаимодействия](/invest/services/operations/operations_problems).

- Тело запроса — [OperationsRequest](#operationsrequest)

- Тело ответа — [OperationsResponse](#operationsresponse)


### GetSandboxOperationsByCursor
Получить операции по счету с пагинацией.
При работе с методом учитывайте [особенности взаимодействия](/invest/services/operations/operations_problems).

- Тело запроса — [GetOperationsByCursorRequest](#getoperationsbycursorrequest)

- Тело ответа — [GetOperationsByCursorResponse](#getoperationsbycursorresponse)


### GetSandboxPortfolio
Портфель по счету.

- Тело запроса — [PortfolioRequest](#portfoliorequest)

- Тело ответа — [PortfolioResponse](#portfolioresponse)


### SandboxPayIn
Пополнить счет.

- Тело запроса — [SandboxPayInRequest](#sandboxpayinrequest)

- Тело ответа — [SandboxPayInResponse](#sandboxpayinresponse)


### GetSandboxWithdrawLimits
Доступный остаток для вывода средств.

- Тело запроса — [WithdrawLimitsRequest](#withdrawlimitsrequest)

- Тело ответа — [WithdrawLimitsResponse](#withdrawlimitsresponse)


### GetSandboxMaxLots
Расчет количества доступных для покупки/продажи лотов.

- Тело запроса — [GetMaxLotsRequest](#getmaxlotsrequest)

- Тело ответа — [GetMaxLotsResponse](#getmaxlotsresponse)



### PostSandboxStopOrder
PostSandboxStopOrder — выставить стоп-заявку.

- Тело запроса — [PostStopOrderRequest](#poststoporderrequest)

- Тело ответа — [PostStopOrderResponse](#poststoporderresponse)


### GetSandboxStopOrders
GetSandboxStopOrders — получить список активных стоп-заявок по счету.

- Тело запроса — [GetStopOrdersRequest](#getstopordersrequest)

- Тело ответа — [GetStopOrdersResponse](#getstopordersresponse)


### CancelSandboxStopOrder
CancelSandboxStopOrder — отменить стоп-заявку.

- Тело запроса — [CancelStopOrderRequest](#cancelstoporderrequest)

- Тело ответа — [CancelStopOrderResponse](#cancelstoporderresponse)


## Сообщения методов


### OpenSandboxAccountRequest
Запрос открытия счета в песочнице.


| Field | Type | Description |
| ----- | ---- | ----------- |
| name | Массив объектов [string](#string) | Название счета |


### OpenSandboxAccountResponse
Номер открытого счета в песочнице.


| Field | Type | Description |
| ----- | ---- | ----------- |
| account_id |  [string](#string) | Номер счета |


### CloseSandboxAccountRequest
Запрос закрытия счета в песочнице.


| Field | Type | Description |
| ----- | ---- | ----------- |
| account_id |  [string](#string) | Номер счета |



### CloseSandboxAccountResponse
Результат закрытия счета в песочнице.

Пустой ответ.


### SandboxPayInRequest
Запрос пополнения счета в песочнице.


| Field | Type | Description |
| ----- | ---- | ----------- |
| account_id |  [string](#string) | Номер счета |
| amount |  [MoneyValue](#moneyvalue) | Сумма пополнения счета в рублях |



### SandboxPayInResponse
Результат пополнения счета, текущий баланс.


| Field | Type | Description |
| ----- | ---- | ----------- |
| balance |  [MoneyValue](#moneyvalue) | Текущий баланс счета |


## Нестандартные типы данных

### MoneyValue
Денежная сумма в определенной валюте

| Field | Type | Description |
| ----- | ---- | ----------- |
| currency |  [string](#string) | Строковый ISO-код валюты |
| units |  [int64](#int64) | Целая часть суммы, может быть отрицательным числом |
| nano |  [int32](#int32) | Дробная часть суммы, может быть отрицательным числом |


### Quotation
Котировка - денежная сумма без указания валюты

| Field | Type | Description |
| ----- | ---- | ----------- |
| units |  [int64](#int64) | Целая часть суммы, может быть отрицательным числом |
| nano |  [int32](#int32) | Дробная часть суммы, может быть отрицательным числом |

