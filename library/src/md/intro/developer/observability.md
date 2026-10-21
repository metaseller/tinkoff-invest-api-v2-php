# Диагностика и устранение ошибок


При взаимодействии с Т-Invest API есть возможность интегрироваться с системой мониторинга ошибок. 
Она помогает разработчикам обнаруживать, диагностировать и устранять проблемы, в ряде случаев, не дожидаясь, пока пользователи сообщат о сбоях. 
Реализованный сервис совместим с широко распространенным решением [Sentry](https://sentry.io/), которое поддерживает множество языков программирования, 
фреймворков и платформ, что делает её универсальным инструментом для команд любого масштаба.

## Что делает?

Библиотека автоматически перехватывает исключения, ошибки, предупреждения и другие проблемы в коде, собирает подробную информацию о них и предоставляет её разработчикам. 

Основные возможности:

- отслеживание ошибок (crash reporting) — фиксация исключений и стек-трейсов;
- мониторинг производительности (Performance Monitoring) — анализ медленных запросов, задержек и узких мест;
- отслеживание транзакций — наблюдение за цепочками вызовов в приложении;
- поддержка множества платформ — от веб-приложений (JavaScript, Python, Ruby) до мобильных (iOS, Android) и серверных (Node.js, Java, .NET);
- подходит как для стартапов, так и для промышленных решений;


## Как это работает?

Когда приложение, интегрированное с решением, сталкивается с ошибкой, библиотека автоматически выполняет следующие действия:

- перехватывает исключение;
- собирает контекст: стек-трейс, переменные окружения, данные пользователя, теги, кастомные метаданные;
- отправляет данные на сервер Т-Invest API;
- группирует похожие ошибки, чтобы избежать дублирования;

Далее команда разработки может просматривать и анализировать ошибки, получать уведомления о проблемах и принимать решения.


## Интеграция

Для подключения автоматической трансляции ошибок воспользуйтесь [инструкцией](https://docs.sentry.io/), соответствующей языку программирования, используемому в вашем проекте.

Популярные:

 - [Python](https://docs.sentry.io/platforms/python/integrations/grpc/);
 - [.NET](https://docs.sentry.io/platforms/dotnet/);
 - [Java/Kotlin](https://docs.sentry.io/platforms/java/);
 - [Go](https://docs.sentry.io/platforms/go/);


## Конфигурация

DSN (Data Source Name) — это уникальный идентификатор, который связывает ваше приложение с сервером. Он имеет формат:
```https://invest-piapi-errorhub@error-hub.tbank.ru/<app_code>``` , где `<app_code>` — это цифровой код вашего приложения,
придумайте уникальный номер, чтобы ваш проект можно было однозначно идентифицировать.

### Чувствительные данные

:::warning
Если вы не используете SDK при разработке приложения, вместе с информацией об ошибке будут отправлены данные, которые могут содержать чувствительную информацию, например, токен доступа.
Обязательно используйте фильтры, чтобы исключить эти данные из отчета.
Официальные SDK автоматически фильтруют персональные данные.
:::

### Примеры фильтров:

<details>
<summary>Python</summary>

     ```python
    import sentry_sdk
    import re

    from tinkoff.invest import  Client
    from tinkoff.invest import Client, GetMaxLotsRequest
    from sentry_sdk.integrations.grpc import GRPCIntegration


    BEARER_PATTERN = re.compile(r'Bearer\s+[a-zA-Z0-9\-_\.]+', re.IGNORECASE)


    def sanitize_bearer_tokens(event, hint):
        def _sanitize_value(value):
            if isinstance(value, str):
                # Заменяем Bearer токены на [Filtered]
                return BEARER_PATTERN.sub("[Filtered]", value)
            elif isinstance(value, dict):
                return {k: _sanitize_value(v) for k, v in value.items()}
            elif isinstance(value, (list, tuple)):
                return [_sanitize_value(item) for item in value]
            else:
                return value

        # Рекурсивно обходим всё событие
        return _sanitize_value(event)


    sentry_sdk.init(
        dsn="https://invest-piapi-errorhub@error-hub.tbank.ru/12345678",
        # Add request headers and IP for users,
        # see https://docs.sentry.io/platforms/python/data-management/data-collected/ for more info
        send_default_pii=False,
        integrations=[
            GRPCIntegration(),
            ],
        before_send=sanitize_bearer_tokens,
    )
     ```

</details>


<details>
<summary>.NET</summary>

     ```bash
     ```

</details>


<details>
<summary>Java/Kotlin</summary>

     ```Java/Kotlin
     ```

</details>


<details>
<summary>Go</summary>

     ```Go
     ```

</details>