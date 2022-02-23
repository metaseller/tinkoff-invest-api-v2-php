<?php

require(__DIR__ . '/../vendor/autoload.php');

use Metaseller\TinkoffInvestApi2\helpers\ValueHelper;
use Metaseller\TinkoffInvestApi2\providers\InstrumentsProvider;
use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Tinkoff\Invest\V1\GetLastPricesRequest;
use Tinkoff\Invest\V1\GetLastPricesResponse;
use Tinkoff\Invest\V1\LastPrice;
use Tinkoff\Invest\V1\PortfolioPosition;
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
 * Пример получения подробной информации о портфеле аккаунта
 */

$factory = TinkoffClientsFactory::create($token);

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
list($response, $status) = $factory->operationsServiceClient->GetPortfolio($request)->wait();

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

$instruments_provider = new InstrumentsProvider($factory, true, true, true, true);

/** @var PortfolioPosition $position */
foreach ($positions as $position) {
    $dictionary_instrument = $instruments_provider->instrumentByFigi($position->getFigi());
    $futures_data = $dictionary_instrument->getInstrumentType() === 'futures' ? $instruments_provider->getFuturesData($dictionary_instrument) : null;

    $quantity = $position->getQuantity();
    $quantity_value = $quantity ? ValueHelper::toDecimal($quantity) : 'ERR';

    $average_price = $position->getAveragePositionPrice();
    $average_price_value = $average_price ? ValueHelper::toCurrency($average_price, $dictionary_instrument, $futures_data) : 'ERR';
    $currency = $average_price ? $average_price->getCurrency() : '';

    $expected_yield = $position->getExpectedYield();
    $expected_yield_value = $expected_yield ? ValueHelper::toCurrency($expected_yield, $dictionary_instrument, $futures_data) : 'ERR';

    $display = '[' . $position->getInstrumentType() . '][' . $position->getFigi() . '][' . $dictionary_instrument->getTicker() . '] ' . $dictionary_instrument->getName();
    $display .= $quantity_value . ' шт.';
    $display .= '(ср. цена. ' . $average_price_value . ' ' . $currency . ') ';
    $display .= 'доходность ' . $expected_yield_value . ' ' . $currency;

    echo $display . PHP_EOL;
}

echo PHP_EOL . PHP_EOL;

/** Пример получения цены фьючерса в рублях */

$test_futures = $instruments_provider->futureByTicker('AUH2');
//$test_futures = $instruments_provider->futureByFigi('FUTAFKS03220');
$test_futures_data = $instruments_provider->getFuturesData($test_futures);

echo 'Futures data:' . PHP_EOL;
var_dump($test_futures->serializeToJsonString());
var_dump($test_futures_data->serializeToJsonString());

echo PHP_EOL;

$last_prices_request = new GetLastPricesRequest();
$last_prices_request->setFigi([$test_futures->getFigi()]);

/** @var GetLastPricesResponse $response */
list($response, $status) = $factory->marketDataServiceClient->GetLastPrices($last_prices_request)->wait();

if ($response) {
    /** @var LastPrice $last_price */
    $last_price = $response->getLastPrices()[0];

    $price = $last_price->getPrice();

    $price_in_points = $price ? ValueHelper::toDecimal($price) : 'ERR';
    $price_in_currency = $price ? ValueHelper::toCurrency($price, $test_futures, $test_futures_data) : 'ERR';

    $display = 'Последняя цена по инструменту [' . $test_futures->getFigi() . '][' . $test_futures->getTicker() . ']';
    $display .= ' ' . $price_in_points . ' пт. = ' . $price_in_currency . ' ' . $test_futures->getCurrency();

    echo $display . PHP_EOL;
}


