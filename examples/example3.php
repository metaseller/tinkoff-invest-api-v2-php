<?php

use Google\Protobuf\Internal\RepeatedField;
use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Metaseller\TinkoffInvestApi2\providers\InstrumentsProvider;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;
use Tinkoff\Invest\V1\Share;
use Tinkoff\Invest\V1\SharesResponse;

require(__DIR__ . '/../vendor/autoload.php');

/** Пример работы с Провайдером инструментов {@link InstrumentsProvider} */

/**
 * Ваш токен доступа к API
 *
 * @see https://tinkoff.github.io/investAPI/token/
 */
$token = '<Your Tinkoff Invest Account Token>';

$factory = TinkoffClientsFactory::create($token);

/** Пример получения данных об инструментах через {@link InstrumentsProvider} */

$instruments_provider = InstrumentsProvider::create($factory);

echo 'Получаем инструмент SBERP по Figi:' . PHP_EOL;
var_dump($instruments_provider->shareByFigi('BBG0047315Y7', true)->serializeToJsonString());

echo PHP_EOL . 'Получаем SBERP по Ticker без указания class_name:' . PHP_EOL;
var_dump($instruments_provider->shareByTicker('SBERP')->serializeToJsonString());

echo PHP_EOL . 'Получаем SBERP по Ticker с прямым указанием class_name и указанием перезапросить закешированные данные:' . PHP_EOL;
var_dump($instruments_provider->shareByTicker('SBERP', 'TQBR', true)->serializeToJsonString());

echo PHP_EOL . 'Получаем TMOS по Ticker без указания class_name:' . PHP_EOL;
var_dump($instruments_provider->etfByTicker('TMOS')->serializeToJsonString());

/**
 * Разумным представляется инициализировать {@link InstrumentsProvider} с предварительной загрузкой нужных справочников
 *
 * Это дает задержку в инициализации, но последующий быстрый доступ к инструментам
 */

$instruments_provider = InstrumentsProvider::create($factory, true, true, true);


echo PHP_EOL . 'Ищем неопределенный инструмент по Figi:' . PHP_EOL;
var_dump($instruments_provider->searchByFigi('BBG0047315Y7')->serializeToJsonString());

try {
    var_dump($instruments_provider->searchByFigi('fake figi')->serializeToJsonString());
} catch (Throwable $e) {
    echo PHP_EOL . 'Пытаясь найти инструмент по невалидному FIGI получим исключение: ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . 'Либо так:'  . PHP_EOL;

var_dump($instruments_provider->searchByFigi('fake figi', false));

echo PHP_EOL . 'По предзагруженному кешу инструмент получаем быстро, без обращения к API' . PHP_EOL;
var_dump($instruments_provider->shareByTicker('FB')->serializeToJsonString());



/**
 * Пример получения справочника всех Shares инструментов, без использования провайдера
 *
 * PS: Само собой, если вам нужен только один инструмент, разумнее использовать метод GetInstrumentBy
 *
 * @see https://tinkoff.github.io/investAPI/instruments/#getinstrumentby
 * @see https://tinkoff.github.io/investAPI/instruments/#instrumentrequest
 *
 * ну или через {@link InstrumentsProvider}
 */

$instruments_request = new InstrumentsRequest();
$instruments_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

/** @var SharesResponse $response */
list($response, $status) = $factory->instrumentsServiceClient->Shares($instruments_request)
    ->wait();

/** @var Share[]|RepeatedField $instruments_dict */
$instruments_dict = $response->getInstruments();
