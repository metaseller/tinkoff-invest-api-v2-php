<?php

require(__DIR__ . '/../vendor/autoload.php');

use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Tinkoff\Invest\V1\PortfolioRequest;
use Tinkoff\Invest\V1\PortfolioResponse;

/**
 * Ваш токен доступа к API
 *
 * @see https://tinkoff.github.io/investAPI/token/
 */
$token = '<Your Tinkoff Invest Account Token>';
$account_id = '<Your Tinkoff Invest Account Id>';

/**
 * Пример получения информации о портфеле аккаунта
 */

$tinkoff_api = TinkoffClientsFactory::create($token);

/**
 * Создаем экземпляр запроса информации о текущем портфеле
 *
 * @see https://tinkoff.github.io/investAPI/operations/#portfoliorequest
 */
$request = new PortfolioRequest();
$request->setAccountId($account_id);

/**
 * @var PortfolioResponse $response - Получаем ответ, содержащий информацию о портфеле
 */
list($response, $status) = $tinkoff_api->operationsServiceClient->GetPortfolio($request)->wait();

/** Выводим полученную информацию */
var_dump(['portfolio_info' => [
    'total_amount_shares' => $response->getTotalAmountShares()->serializeToJsonString(),
    'total_amount_bonds' => $response->getTotalAmountBonds()->serializeToJsonString(),
    'total_amount_etf' => $response->getTotalAmountEtf()->serializeToJsonString(),
    'total_amount_futures' => $response->getTotalAmountFutures()->serializeToJsonString(),
    'total_amount_currencies' => $response->getTotalAmountCurrencies()->serializeToJsonString(),
]]);

$positions = $response->getPositions();

echo 'Available portfolio positions:' . PHP_EOL;

/** @var \Tinkoff\Invest\V1\PortfolioPosition $position */
foreach ($positions as $position) {
    $quantity = $position->getQuantity();

    echo $position->getInstrumentType() . ' ' . $position->getFigi() . ' ' . ($quantity->getUnits() + $quantity->getNano() / pow(10, 9)) . ' шт.' . PHP_EOL;
}
