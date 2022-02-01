<?php

require(__DIR__ . '/../vendor/autoload.php');

use Metaseller\TinkoffInvestApi2\ClientConnection;
use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Tinkoff\Invest\V1\Account;
use Tinkoff\Invest\V1\GetAccountsRequest;
use Tinkoff\Invest\V1\GetAccountsResponse;
use Tinkoff\Invest\V1\GetInfoRequest;
use Tinkoff\Invest\V1\GetInfoResponse;
use Tinkoff\Invest\V1\UsersServiceClient;

/**
 * Ваш токен доступа к API
 *
 * @see https://tinkoff.github.io/investAPI/token/
 */
$token = '<Your Tinkoff Invest Account Token>';

/** ВЕРСИЯ 2 (Инициализация клиентов с использованием прямого создания моделей клиентов) */

/**
 * Создаем экземпляр подключения к сервису, используя {@link UsersServiceClient}
 */
$user_service_client = new UsersServiceClient(ClientConnection::getHostname(), ClientConnection::getOptions($token));

/**
 * Создаем экземпляр запроса информации об аккаунте к сервису
 *
 * Запрос не принимает никаких параметров на вход
 *
 * @see https://tinkoff.github.io/investAPI/users/#getinforequest
 */
$request = new GetInfoRequest();

/**
 * @var GetInfoResponse $response - Получаем ответ, содержащий информацию о пользователе
 */
list($response, $status) = $user_service_client->GetInfo($request)->wait();

/** Выводим полученную информацию */
var_dump(['user_info' => [
    'prem_status' => $response->getPremStatus(),
    'qual_status' => $response->getQualStatus(),
    'qualified_for_work_with' => $response->getQualifiedForWorkWith(),
]]);

/**
 * @var GetAccountsResponse $response - Получаем ответ, содержащий информацию об аккаунтах
 */
list($response, $status) = $user_service_client->GetAccounts(new GetAccountsRequest())->wait();

/** Выводим полученную информацию */
/** @var Account $account */
foreach ($response->getAccounts() as $account) {
    echo $account->getName() . ' => ' . $account->getId() . PHP_EOL;
}
