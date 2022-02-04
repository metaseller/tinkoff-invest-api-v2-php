<?php

use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Tinkoff\Invest\V1\Instrument;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;
use Tinkoff\Invest\V1\MarketDataRequest;
use Tinkoff\Invest\V1\MarketDataResponse;
use Tinkoff\Invest\V1\Order;
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
    }
}

$stream->cancel();
