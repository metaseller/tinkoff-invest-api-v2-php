<?php

use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Metaseller\TinkoffInvestApi2\providers\InstrumentsProvider;
use Tinkoff\Invest\V1\MarketDataRequest;
use Tinkoff\Invest\V1\MarketDataResponse;
use Tinkoff\Invest\V1\Order;
use Tinkoff\Invest\V1\OrderBookInstrument;
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
 * Берем нужный нам инструмент FB
 */

$instruments_provider = new InstrumentsProvider($factory);
$meta_instrument = $instruments_provider->shareByTicker('FB');

echo PHP_EOL . 'Get FB by Ticker without class_name:' . PHP_EOL;
var_dump($meta_instrument->serializeToJsonString());

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

/** В цикле получаем данные от сервера */

/** @var MarketDataResponse $market_data_response */
while ($market_data_response = $stream->read()) {
    if ($orderbook = $market_data_response->getOrderbook()) {
        /** @var Order[] $asks */
        $asks = $orderbook->getAsks();

        /** @var Order[] $bids */
        $bids = $orderbook->getBids();

        foreach ($asks as $ask) {
            $price = $ask->getPrice()
                    ->getUnits() + $ask->getPrice()
                    ->getNano() / pow(10, 9)
            ;

            echo 'ASK ' . $price . ' - ' . $ask->getQuantity() . PHP_EOL;
        }

        foreach ($bids as $bid) {
            $price = $bid->getPrice()
                    ->getUnits() + $bid->getPrice()
                    ->getNano() / pow(10, 9)
            ;

            echo 'BID ' . $price . ' - ' . $bid->getQuantity() . PHP_EOL;
        }

        echo 'Orderbook response finished' . PHP_EOL . PHP_EOL;
    } else {
        echo 'No orderbook data' . PHP_EOL;
    }

    if ($ping = $market_data_response->getPing()) {
        echo 'Ping? Pong!' . PHP_EOL;
    }
}

$stream->cancel();
