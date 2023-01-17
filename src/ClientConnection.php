<?php

namespace Metaseller\TinkoffInvestApi2;

use Grpc\ChannelCredentials;

/**
 * Модель получения настроек соединения с сервисом Tinkoff Invest API 2
 *
 * @package Metaseller\TinkoffInvestApi2
 */
class ClientConnection
{
    /**
     * @var string Адрес домена сервиса Tinkoff Invest API 2
     *
     * @see https://tinkoff.github.io/investAPI/
     */
    public const TINKOFF_INVEST_API2_HOSTNAME = 'invest-public-api.tinkoff.ru';

    /**
     * @var string Адрес домена сервиса Tinkoff Invest API 2 (песочница)
     *
     * @see https://tinkoff.github.io/investAPI/
     */
    public const TINKOFF_INVEST_API2_HOSTNAME_SANDBOX = 'sandbox-invest-public-api.tinkoff.ru';

    /**
     * @var int Порт сервиса Tinkoff Invest API 2
     *
     * @see https://tinkoff.github.io/investAPI/
     */
    public const TINKOFF_INVEST_API2_PORT = 443;

    /**
     * Метод получения опций соединения с сервисом Tinkoff Invest API 2
     *
     * @param string $api_token Токен доступа к Tinkoff Invest API 2
     * @param string $app_name Значение AppName для запросов к Tinkoff Invest API 2. По умолчанию равно {@link TinkoffClientsFactory::DEFAULT_APP_NAME}
     *
     * @return array Массив опций соединения с сервисом Tinkoff Invest API 2
     */
    public static function getOptions(string $api_token, string $app_name = TinkoffClientsFactory::DEFAULT_APP_NAME): array
    {
        $certificate_path = dirname(__FILE__) . '/../etc/tinkoff-ru.pem';

        $cert = file_get_contents($certificate_path);

        return [
            'credentials' => ChannelCredentials::createSsl($cert),
            'grpc.enable_http_proxy' => 0,
            'grpc.ssl_target_name_override' => static::getApiDomain(),
            'update_metadata' => function($meta_data) use ($api_token, $app_name) {
                $meta_data['authorization'] = ['Bearer ' . $api_token];
                $meta_data['x-app-name'] = [$app_name];

                return $meta_data;
            }
        ];
    }

    /**
     * Метод получения полного адреса сервиса Tinkoff Invest API 2
     *
     * @return string Полного адреса сервиса Tinkoff Invest API 2
     */
    public static function getHostname(): string
    {
        return static::getApiDomain() . ':' . static::TINKOFF_INVEST_API2_PORT;
    }

    /**
     * Метод получения домена сервиса Tinkoff Invest API 2
     *
     * @return string Домен сервиса Tinkoff Invest API 2
     */
    public static function getApiDomain(): string
    {
        return static::isSandboxModeEnabled()
            ? static::TINKOFF_INVEST_API2_HOSTNAME_SANDBOX
            : static::TINKOFF_INVEST_API2_HOSTNAME
        ;
    }

    /**
     * Метод определения режима работы API из значения переменной окружения <code>getenv('TINKOFF_API2_SANDBOX_MODE')</code>
     *
     * @return bool Флаг активности режима "Песочницы"
     */
    public static function isSandboxModeEnabled(): bool
    {
        $env_value = getenv('TINKOFF_API2_SANDBOX_MODE');

        return $env_value !== 'false' && ((bool) $env_value !== false);
    }
}
