<?php

use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Tinkoff\Invest\V1\Instrument;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;
use Tinkoff\Invest\V1\MarketDataRequest;
use Tinkoff\Invest\V1\MarketDataResponse;
use Tinkoff\Invest\V1\OrderBookInstrument;
use Tinkoff\Invest\V1\SharesResponse;
use Tinkoff\Invest\V1\SubscribeOrderBookRequest;
use Tinkoff\Invest\V1\SubscriptionAction;
use Tinkoff\Invest\V1\MarketDataStreamServiceClient;

require(__DIR__ . '/../vendor/autoload.php');

/**
 * Ваш токен доступа к API
 *
 * @see https://tinkoff.github.io/investAPI/token/
 */
$token = '<Your Tinkoff Invest Account Token>';

/** Пример получения обновляемого через Stream ({@link MarketDataStreamServiceClient}) стакана по тикеру FB */

$factory = TinkoffClientsFactory::create($token);

/**
 * Пример получения справочника всех Shares инструментов
 *
 * PS: Само собой, если вам нужен только один инструмент, разумнее использовать метод GetInstrumentBy
 *
 * @see https://tinkoff.github.io/investAPI/instruments/#getinstrumentby
 * @see https://tinkoff.github.io/investAPI/instruments/#instrumentrequest
 */

$instruments_request = new InstrumentsRequest();
$instruments_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

/** @var SharesResponse $response */
list($response, $status) = $factory->instrumentsServiceClient->Shares($instruments_request)
    ->wait();

/** @var Instrument[] $instruments_dict */
$instruments_dict = $response->getInstruments();

/**
 * Находим в справочнике (коль он у нас весь есть) нужный нам инструмент
 */
foreach ($instruments_dict as $instrument) {
    if ($instrument->getTicker() === 'FB') {
        $meta_instrument = $instrument;

        break;
    }
}

if (empty($meta_instrument)) {
    echo('Instrument not found');

    die();
}

/** Создаем подписку на данные {@link MarketDataRequest}, конкретно по {@link SubscribeOrderBookRequest} по FIGI инструмента META/FB */
$subscription = (new MarketDataRequest())
    ->setSubscribeOrderBookRequest(
        (new SubscribeOrderBookRequest())
            ->setSubscriptionAction(SubscriptionAction::SUBSCRIPTION_ACTION_SUBSCRIBE)
            ->setInstruments([
                (new OrderBookInstrument())
                    ->setFigi($meta_instrument->getFigi())
                    ->setDepth(10)
            ])
    );

$stream = $factory->marketDataStreamServiceClient->MarketDataStream();
$stream->write($subscription);

$connection_lost_timeout = null;

/** @var MarketDataResponse $market_data_response */
while ($market_data_response = $stream->read()) {
    if ($orderbook = $market_data_response->getOrderbook()) {
        echo 'Есть данные' . PHP_EOL;

        $connection_lost_timeout = null;
    } elseif ($market_data_response->hasPing()) {
        echo 'Есть пинг' . PHP_EOL;

        $connection_lost_timeout = null;
    } elseif (!$connection_lost_timeout) {
        echo 'Таймер старт' . PHP_EOL;

        $connection_lost_timeout = time();
    }

    if ($connection_lost_timeout) {
        if ($connection_lost_timeout - time() > 4 * 60) {
            echo 'Отключились по таймауту' . PHP_EOL;

            $stream->cancel();

            break;
        } else {
            echo 'Разрыв случился. Ждем таймаут' . PHP_EOL;
        }
    }
}

if (!empty($connection_lost_timeout)) {
    echo 'Вышли из цикла по прерыванию' . PHP_EOL;
} else {
    echo 'Вышли из цикла по нарушению условия' . PHP_EOL;
}

$stream->cancel();
