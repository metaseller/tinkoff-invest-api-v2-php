<?php

namespace Metaseller\TinkoffInvestApi2;

use Exception;
use Metaseller\TinkoffInvestApi2\exceptions\RequestException;
use Tinkoff\Invest\V1\InstrumentsServiceClient;
use Tinkoff\Invest\V1\MarketDataServiceClient;
use Tinkoff\Invest\V1\MarketDataStreamServiceClient;
use Tinkoff\Invest\V1\OperationsServiceClient;
use Tinkoff\Invest\V1\OperationsStreamServiceClient;
use Tinkoff\Invest\V1\OrdersServiceClient;
use Tinkoff\Invest\V1\OrdersStreamServiceClient;
use Tinkoff\Invest\V1\SandboxServiceClient;
use Tinkoff\Invest\V1\StopOrdersServiceClient;
use Tinkoff\Invest\V1\UsersServiceClient;
use Grpc\Channel as GrpcChannel;

/**
 * Фабрика клиентов доступа к сервису Tinkoff Invest API 2
 *
 * @property-read InstrumentsServiceClient $instrumentsServiceClient Клиент с настройками по-умолчанию к сервису инструментов
 * @property-read MarketDataStreamServiceClient $marketDataStreamServiceClient Клиент с настройками по-умолчанию к Bidirectional-stream методам сервиса котировок
 * @property-read MarketDataServiceClient $marketDataServiceClient Клиент с настройками по-умолчанию к Unary методам сервиса котировок
 * @property-read OperationsServiceClient $operationsServiceClient Клиент с настройками по-умолчанию к сервису операций
 * @property-read OperationsStreamServiceClient $operationsStreamServiceClient Клиент с настройками по-умолчанию к Stream сервису операций
 * @property-read OrdersServiceClient $ordersServiceClient Клиент с настройками по-умолчанию к сервису торговых поручений
 * @property-read OrdersStreamServiceClient $ordersStreamServiceClient Клиент с настройками по-умолчанию к Stream сервису торговых поручений
 * @property-read SandboxServiceClient $sandboxServiceClient Клиент с настройками по-умолчанию к песочнице
 * @property-read StopOrdersServiceClient $stopOrdersServiceClient Клиент с настройками по-умолчанию к сервису стоп-заявок
 * @property-read UsersServiceClient $usersServiceClient Клиент с настройками по-умолчанию к сервису аккаунтов
 *
 * @package Metaseller\TinkoffInvestApi2
 */
class TinkoffClientsFactory
{
    use ModelTrait;

    /**
     * @var string AppName запросов по-умолчанию
     *
     * @see https://tinkoff.github.io/investAPI/grpc/#appname
     */
    public const DEFAULT_APP_NAME = 'metaseller.tinkoff-invest-api-v2-php';

    /**
     * @var string|null Передаваемое AppName запросов
     */
    protected $_app_name;

    /**
     * @var string|null Токен доступа к Tinkoff Invest API 2
     */
    protected $_api_token;

    /**
     * @var InstrumentsServiceClient|null Клиент к сервису инструментов
     *
     * @see https://tinkoff.github.io/investAPI/head-instruments/
     */
    protected $_instruments_service_client;

    /**
     * @var MarketDataStreamServiceClient|null Клиент к Bidirectional-stream методам сервиса котировок
     *
     * @see https://tinkoff.github.io/investAPI/head-instruments/
     */
    protected $_market_data_stream_service_client;

    /**
     * @var OperationsStreamServiceClient|null Клиент к Bidirectional-stream методам сервиса операций
     *
     * @see https://tinkoff.github.io/investAPI/head-instruments/
     */
    protected $_operations_stream_service_client;

    /**
     * @var MarketDataServiceClient|null Клиент к Unary методам сервиса котировок
     *
     * @see https://tinkoff.github.io/investAPI/head-marketdata/
     */
    protected $_market_data_service_client;

    /**
     * @var OperationsServiceClient|null Клиент к сервису операций
     *
     * @see https://tinkoff.github.io/investAPI/head-operations/
     */
    protected $_operations_service_client;

    /**
     * @var OrdersServiceClient|null Клиент к сервису торговых поручений
     *
     * @see https://tinkoff.github.io/investAPI/head-orders/
     */
    protected $_orders_service_client;

    /**
     * @var OrdersStreamServiceClient|null Клиент к Stream сервису торговых поручений
     *
     * @see https://tinkoff.github.io/investAPI/head-orders/
     */
    protected $_orders_stream_service_client;

    /**
     * @var SandboxServiceClient|null Клиент доступа к песочнице
     *
     * @see https://tinkoff.github.io/investAPI/head-sandbox/
     */
    protected $_sandbox_service_client;

    /**
     * @var StopOrdersServiceClient|null Клиент к сервису стоп-заявок
     *
     * @see https://tinkoff.github.io/investAPI/head-stoporders/
     */
    protected $_stop_orders_service_client;

    /**
     * @var UsersServiceClient|null Клиент к сервису аккаунтов
     *
     * @see https://tinkoff.github.io/investAPI/head-users/
     */
    protected $_users_service_client;

    /**
     * @var array Информация о последней ошибке исполнения запроса
     *
     * Пустой массив, если ошибки нет, либо массив вида
     *  <pre>
     *      [
     *          'x-tracking-id' => $status['metadata']['x-tracking-id'] ?? null,
     *          'code' => $status['code'] ?? null,
     *          'details' => $status['details'] ?? null,
     *          'message' => $status['metadata']['message'] ?? null,
     *      ]
     *  </pre>
     */
    protected $_last_error = [];

    /**
     * Конструктор класса
     *
     * @param string|null $api_token Токен доступа к Tinkoff Invest API 2
     * @param string|null $app_name Значение AppName для запросов к Tinkoff Invest API 2. Если установлено <code>null</code>,
     * то будет использовано значение {@link TinkoffClientsFactory::DEFAULT_APP_NAME}
     */
    public function __construct(?string $api_token = null, ?string $app_name = null)
    {
        if ($api_token) {
            $this->setApiToken($api_token)->setAppName($app_name ?: TinkoffClientsFactory::DEFAULT_APP_NAME);
        }
    }

    /**
     * Метод сеттер токена доступа к Tinkoff Invest API 2
     *
     * @param string $api_token Токен доступа к Tinkoff Invest API 2
     *
     * @return $this Текущий экземпляр модели
     */
    public function setApiToken(string $api_token): self
    {
        $this->_api_token = $api_token;
        $this->resetClients();

        return $this;
    }

    /**
     * Метод сеттер значения AppName для запросов к Tinkoff Invest API 2
     *
     * @param string $app_name AppName для запросов к Tinkoff Invest API 2
     *
     * @return $this Текущий экземпляр модели
     */
    public function setAppName(string $app_name): self
    {
        $this->_app_name = $app_name;
        $this->resetClients();

        return $this;
    }

    /**
     * Метод обработки статуса выполнения запроса.
     *
     * Если все хорошо - метод молчаливо заканчивает свою работу, и очищает значение {@link TinkoffClientsFactory::$_last_error},
     * в случае ошибки в эту переменную будут залогированы детали и будет брошено исключение
     *
     * @param mixed|array|null $status Статус выполнения запроса
     * @param bool $echo_to_stdout Флаг необходимости вывести подробности ошибки в stdOut.  По умолчанию равно <code>false</code>
     *
     * @return void
     *
     * @throws RequestException
     */
    public function processRequestStatus($status, bool $echo_to_stdout = false): void
    {
        if (!$status) {
            throw new RequestException('Response status is empty');
        }

        /** @var array $status Приводим stdClass к array */
        $status = json_decode(json_encode($status), true);
        $status_code = $status['code'] ?? null;

        if (!$status_code) {
            $this->_last_error = [];

            return;
        }

        $this->_last_error = [
            'x-tracking-id' => $status['metadata']['x-tracking-id'] ?? null,
            'code' => $status['code'] ?? null,
            'details' => $status['details'] ?? null,
            'message' => $status['metadata']['message'] ?? null,
        ];

        $log_error_message = 'Api Request Error: ' . json_encode($this->_last_error);

        if ($echo_to_stdout) {
            echo $log_error_message . PHP_EOL;
        }

        throw new RequestException($log_error_message);
    }

    /**
     * Метод геттер получения информации о последней ошибке
     *
     * @return array Пустой массив, если ошибки нет, либо массив вида
     *  <pre>
     *      [
     *          'x-tracking-id' => $status['metadata']['x-tracking-id'] ?? null,
     *          'code' => $status['code'] ?? null,
     *          'details' => $status['details'] ?? null,
     *          'message' => $status['metadata']['message'] ?? null,
     *      ]
     *  </pre>
     */
    public function getLastError(): array
    {
        return $this->_last_error;
    }

    /**
     * Метод получения клиента к сервису инструментов
     *
     * Если все параметры имеют значения по-умолчанию, то метод вернет созданный синглетон клиента в рамках
     * текущей модели фабрики. Если атрибуты имеют отличные от пустых значения, то всегда будет создан новый экземпляр
     * клиента.
     *
     * @param array $extra_options Массив параметров канала. При инициализации клиента рекурсивно объединяются со значением
     * {@link ClientConnection::getOptions()}. По умолчанию равно <code>[]</code>
     * @param GrpcChannel|null $channel Канал для повторного использования. По умолчанию равно <code>null</code>
     *
     * @return InstrumentsServiceClient Клиент к сервису инструментов
     *
     * @throws Exception
     */
    public function getInstrumentsServiceClient(array $extra_options = [], ?GrpcChannel $channel = null): InstrumentsServiceClient
    {
        if (!empty($extra_options) || !empty($channel)) {
            return new InstrumentsServiceClient(
                ClientConnection::getHostname(),
                array_merge_recursive($this->getBaseConnectionOptions(), $extra_options),
                $channel
            );
        } else {
            if (empty($this->_instruments_service_client)) {
                $this->_instruments_service_client = new InstrumentsServiceClient(
                    ClientConnection::getHostname(),
                    $this->getBaseConnectionOptions()
                );
            }

            return $this->_instruments_service_client;
        }
    }

    /**
     * Метод получения клиента к Bidirectional-stream методам сервиса котировок
     *
     * Если все параметры имеют значения по-умолчанию, то метод вернет созданный синглетон клиента в рамках
     * текущей модели фабрики. Если атрибуты имеют отличные от пустых значения, то всегда будет создан новый экземпляр
     * клиента.
     *
     * @param array $extra_options Массив параметров канала. При инициализации клиента рекурсивно объединяются со значением
     * {@link ClientConnection::getOptions()}. По умолчанию равно <code>[]</code>
     * @param GrpcChannel|null $channel Канал для повторного использования. По умолчанию равно <code>null</code>
     *
     * @return MarketDataStreamServiceClient Клиент к Bidirectional-stream методам сервиса котировок
     *
     * @throws Exception
     */
    public function getMarketDataStreamServiceClient(array $extra_options = [], ?GrpcChannel $channel = null): MarketDataStreamServiceClient
    {
        if (!empty($extra_options) || !empty($channel)) {
            return new MarketDataStreamServiceClient(
                ClientConnection::getHostname(),
                array_merge_recursive($this->getBaseConnectionOptions(), $extra_options),
                $channel
            );
        } else {
            if (empty($this->_market_data_stream_service_client)) {
                $this->_market_data_stream_service_client = new MarketDataStreamServiceClient(
                    ClientConnection::getHostname(),
                    $this->getBaseConnectionOptions()
                );
            }

            return $this->_market_data_stream_service_client;
        }
    }

    /**
     * Метод получения клиента к Unary методам сервиса котировок
     *
     * Если все параметры имеют значения по-умолчанию, то метод вернет созданный синглетон клиента в рамках
     * текущей модели фабрики. Если атрибуты имеют отличные от пустых значения, то всегда будет создан новый экземпляр
     * клиента.
     *
     * @param array $extra_options Массив параметров канала. При инициализации клиента рекурсивно объединяются со значением
     * {@link ClientConnection::getOptions()}. По умолчанию равно <code>[]</code>
     * @param GrpcChannel|null $channel Канал для повторного использования. По умолчанию равно <code>null</code>
     *
     * @return MarketDataServiceClient Клиент к Unary методам сервиса котировок
     *
     * @throws Exception
     */
    public function getMarketDataServiceClient(array $extra_options = [], ?GrpcChannel $channel = null): MarketDataServiceClient
    {
        if (!empty($extra_options) || !empty($channel)) {
            return new MarketDataServiceClient(
                ClientConnection::getHostname(),
                array_merge_recursive($this->getBaseConnectionOptions(), $extra_options),
                $channel
            );
        } else {
            if (empty($this->_market_data_service_client)) {
                $this->_market_data_service_client = new MarketDataServiceClient(
                    ClientConnection::getHostname(),
                    $this->getBaseConnectionOptions()
                );
            }

            return $this->_market_data_service_client;
        }
    }

    /**
     * Метод получения клиента к сервису операций
     *
     * Если все параметры имеют значения по-умолчанию, то метод вернет созданный синглетон клиента в рамках
     * текущей модели фабрики. Если атрибуты имеют отличные от пустых значения, то всегда будет создан новый экземпляр
     * клиента.
     *
     * @param array $extra_options Массив параметров канала. При инициализации клиента рекурсивно объединяются со значением
     * {@link ClientConnection::getOptions()}. По умолчанию равно <code>[]</code>
     * @param GrpcChannel|null $channel Канал для повторного использования. По умолчанию равно <code>null</code>
     *
     * @return OperationsServiceClient Клиент к сервису операций
     *
     * @throws Exception
     */
    public function getOperationsServiceClient(array $extra_options = [], ?GrpcChannel $channel = null): OperationsServiceClient
    {
        if (!empty($extra_options) || !empty($channel)) {
            return new OperationsServiceClient(
                ClientConnection::getHostname(),
                array_merge_recursive($this->getBaseConnectionOptions(), $extra_options),
                $channel
            );
        } else {
            if (empty($this->_operations_service_client)) {
                $this->_operations_service_client = new OperationsServiceClient(
                    ClientConnection::getHostname(),
                    $this->getBaseConnectionOptions()
                );
            }

            return $this->_operations_service_client;
        }
    }

    /**
     * Метод получения клиента к Bidirectional-stream методам сервиса операций
     *
     * Если все параметры имеют значения по-умолчанию, то метод вернет созданный синглетон клиента в рамках
     * текущей модели фабрики. Если атрибуты имеют отличные от пустых значения, то всегда будет создан новый экземпляр
     * клиента.
     *
     * @param array $extra_options Массив параметров канала. При инициализации клиента рекурсивно объединяются со значением
     * {@link ClientConnection::getOptions()}. По умолчанию равно <code>[]</code>
     * @param GrpcChannel|null $channel Канал для повторного использования. По умолчанию равно <code>null</code>
     *
     * @return OperationsStreamServiceClient Клиент к Bidirectional-stream методам сервиса котировок
     *
     * @throws Exception
     */
    public function getOperationsStreamServiceClient(array $extra_options = [], ?GrpcChannel $channel = null): OperationsStreamServiceClient
    {
        if (!empty($extra_options) || !empty($channel)) {
            return new OperationsStreamServiceClient(
                ClientConnection::getHostname(),
                array_merge_recursive($this->getBaseConnectionOptions(), $extra_options),
                $channel
            );
        } else {
            if (empty($this->_operations_stream_service_client)) {
                $this->_operations_stream_service_client = new OperationsStreamServiceClient(
                    ClientConnection::getHostname(),
                    $this->getBaseConnectionOptions()
                );
            }

            return $this->_operations_stream_service_client;
        }
    }

    /**
     * Метод получения клиента к сервису торговых поручений
     *
     * Если все параметры имеют значения по-умолчанию, то метод вернет созданный синглетон клиента в рамках
     * текущей модели фабрики. Если атрибуты имеют отличные от пустых значения, то всегда будет создан новый экземпляр
     * клиента.
     *
     * @param array $extra_options Массив параметров канала. При инициализации клиента рекурсивно объединяются со значением
     * {@link ClientConnection::getOptions()}. По умолчанию равно <code>[]</code>
     * @param GrpcChannel|null $channel Канал для повторного использования. По умолчанию равно <code>null</code>
     *
     * @return OrdersServiceClient Клиент к сервису торговых поручений
     *
     * @throws Exception
     */
    public function getOrdersServiceClient(array $extra_options = [], ?GrpcChannel $channel = null): OrdersServiceClient
    {
        if (!empty($extra_options) || !empty($channel)) {
            return new OrdersServiceClient(
                ClientConnection::getHostname(),
                array_merge_recursive($this->getBaseConnectionOptions(), $extra_options),
                $channel
            );
        } else {
            if (empty($this->_orders_service_client)) {
                $this->_orders_service_client = new OrdersServiceClient(
                    ClientConnection::getHostname(),
                    $this->getBaseConnectionOptions()
                );
            }

            return $this->_orders_service_client;
        }
    }

    /**
     * Метод получения клиента к Stream сервису торговых поручений
     *
     * Если все параметры имеют значения по-умолчанию, то метод вернет созданный синглетон клиента в рамках
     * текущей модели фабрики. Если атрибуты имеют отличные от пустых значения, то всегда будет создан новый экземпляр
     * клиента.
     *
     * @param array $extra_options Массив параметров канала. При инициализации клиента рекурсивно объединяются со значением
     * {@link ClientConnection::getOptions()}. По умолчанию равно <code>[]</code>
     * @param GrpcChannel|null $channel Канал для повторного использования. По умолчанию равно <code>null</code>
     *
     * @return OrdersStreamServiceClient Клиент к Stream сервису торговых поручений
     *
     * @throws Exception
     */
    public function getOrdersStreamServiceClient(array $extra_options = [], ?GrpcChannel $channel = null): OrdersStreamServiceClient
    {
        if (!empty($extra_options) || !empty($channel)) {
            return new OrdersStreamServiceClient(
                ClientConnection::getHostname(),
                array_merge_recursive($this->getBaseConnectionOptions(), $extra_options),
                $channel
            );
        } else {
            if (empty($this->_orders_stream_service_client)) {
                $this->_orders_stream_service_client = new OrdersStreamServiceClient(
                    ClientConnection::getHostname(),
                    $this->getBaseConnectionOptions()
                );
            }

            return $this->_orders_stream_service_client;
        }
    }

    /**
     * Метод получения клиента к песочнице
     *
     * Если все параметры имеют значения по-умолчанию, то метод вернет созданный синглетон клиента в рамках
     * текущей модели фабрики. Если атрибуты имеют отличные от пустых значения, то всегда будет создан новый экземпляр
     * клиента.
     *
     * @param array $extra_options Массив параметров канала. При инициализации клиента рекурсивно объединяются со значением
     * {@link ClientConnection::getOptions()}. По умолчанию равно <code>[]</code>
     * @param GrpcChannel|null $channel Канал для повторного использования. По умолчанию равно <code>null</code>
     *
     * @return SandboxServiceClient Клиент к песочнице
     *
     * @throws Exception
     */
    public function getSandboxServiceClient(array $extra_options = [], ?GrpcChannel $channel = null): SandboxServiceClient
    {
        if (!empty($extra_options) || !empty($channel)) {
            return new SandboxServiceClient(
                ClientConnection::getHostname(),
                array_merge_recursive($this->getBaseConnectionOptions(), $extra_options),
                $channel
            );
        } else {
            if (empty($this->_sandbox_service_client)) {
                $this->_sandbox_service_client = new SandboxServiceClient(
                    ClientConnection::getHostname(),
                    $this->getBaseConnectionOptions()
                );
            }

            return $this->_sandbox_service_client;
        }
    }

    /**
     * Метод получения клиента к сервису стоп-заявок
     *
     * Если все параметры имеют значения по-умолчанию, то метод вернет созданный синглетон клиента в рамках
     * текущей модели фабрики. Если атрибуты имеют отличные от пустых значения, то всегда будет создан новый экземпляр
     * клиента.
     *
     * @param array $extra_options Массив параметров канала. При инициализации клиента рекурсивно объединяются со значением
     * {@link ClientConnection::getOptions()}. По умолчанию равно <code>[]</code>
     * @param GrpcChannel|null $channel Канал для повторного использования. По умолчанию равно <code>null</code>
     *
     * @return StopOrdersServiceClient Клиент к сервису стоп-заявок
     *
     * @throws Exception
     */
    public function getStopOrdersServiceClient(array $extra_options = [], ?GrpcChannel $channel = null): StopOrdersServiceClient
    {
        if (!empty($extra_options) || !empty($channel)) {
            return new StopOrdersServiceClient(
                ClientConnection::getHostname(),
                array_merge_recursive($this->getBaseConnectionOptions(), $extra_options),
                $channel
            );
        } else {
            if (empty($this->_stop_orders_service_client)) {
                $this->_stop_orders_service_client = new StopOrdersServiceClient(
                    ClientConnection::getHostname(),
                    $this->getBaseConnectionOptions()
                );
            }

            return $this->_stop_orders_service_client;
        }
    }

    /**
     * Метод получения клиента Клиент к сервису аккаунтов
     *
     * Если все параметры имеют значения по-умолчанию, то метод вернет созданный синглетон клиента в рамках
     * текущей модели фабрики. Если атрибуты имеют отличные от пустых значения, то всегда будет создан новый экземпляр
     * клиента.
     *
     * @param array $extra_options Массив параметров канала. При инициализации клиента рекурсивно объединяются со значением
     * {@link ClientConnection::getOptions()}. По умолчанию равно <code>[]</code>
     * @param GrpcChannel|null $channel Канал для повторного использования. По умолчанию равно <code>null</code>
     *
     * @return UsersServiceClient Клиент к сервису аккаунтов
     *
     * @throws Exception
     */
    public function getUsersServiceClient(array $extra_options = [], ?GrpcChannel $channel = null): UsersServiceClient
    {
        if (!empty($extra_options) || !empty($channel)) {
            return new UsersServiceClient(
                ClientConnection::getHostname(),
                array_merge_recursive($this->getBaseConnectionOptions(), $extra_options),
                $channel
            );
        } else {
            if (empty($this->_users_service_client)) {
                $this->_users_service_client = new UsersServiceClient(
                    ClientConnection::getHostname(),
                    $this->getBaseConnectionOptions()
                );
            }

            return $this->_users_service_client;
        }
    }

    /**
     * Метод создания экземпляра Фабрики
     *
     * @param string|null $api_token Токен доступа к Tinkoff Invest API 2
     *
     * @return static Текущий экземпляр Фабрики клиентов
     */
    public static function create(?string $api_token): self
    {
        return new static($api_token);
    }

    /**
     * Метод сброса созданных моделей клиентов в рамках экземпляра фабрики
     */
    protected function resetClients(): void
    {
        $this->_instruments_service_client = null;
        $this->_market_data_service_client = null;
        $this->_market_data_stream_service_client = null;
        $this->_operations_service_client = null;
        $this->_orders_service_client = null;
        $this->_orders_stream_service_client = null;
        $this->_sandbox_service_client = null;
        $this->_stop_orders_service_client = null;
        $this->_users_service_client = null;
    }

    /**
     * Метод получения базовых опций для создания клиента к сервису
     *
     * @return array Ассоциативный массив базовых опций для создания клиента к сервису
     *
     * @throws Exception
     */
    protected function getBaseConnectionOptions(): array
    {
        if (empty($this->_api_token)) {
            throw new Exception('Api token is empty');
        }

        return ClientConnection::getOptions($this->_api_token);
    }
}
