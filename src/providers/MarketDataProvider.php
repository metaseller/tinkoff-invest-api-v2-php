<?php

namespace Metaseller\TinkoffInvestApi2\providers;

use Google\Protobuf\Internal\RepeatedField;
use Metaseller\TinkoffInvestApi2\exceptions\RequestException;
use Metaseller\TinkoffInvestApi2\exceptions\ValidateException;
use Metaseller\TinkoffInvestApi2\helpers\ArrayHelper;
use Metaseller\TinkoffInvestApi2\helpers\InstrumentsHelper;
use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Throwable;
use Tinkoff\Invest\V1\Bond;
use Tinkoff\Invest\V1\Currency;
use Tinkoff\Invest\V1\Etf;
use Tinkoff\Invest\V1\Future;
use Tinkoff\Invest\V1\GetOrderBookRequest;
use Tinkoff\Invest\V1\GetOrderBookResponse;
use Tinkoff\Invest\V1\Instrument;
use Tinkoff\Invest\V1\Order;
use Tinkoff\Invest\V1\Quotation;
use Tinkoff\Invest\V1\Share;

/**
 * Провайдер рыночных данных сервиса Tinkoff Invest API 2
 *
 * @package Metaseller\TinkoffInvestApi2
 */
class MarketDataProvider extends BaseDataProvider
{
    /**
     * Метод создания нового экземпляра провайдера
     *
     * @param TinkoffClientsFactory|null $model Экземпляр фабрики клиентов доступа к сервису Tinkoff Invest API 2 или <code>null</code>, если инициализация планируется позднее
     *
     * @return static Созданный экземпляр провайдера
     */
    public static function create(?TinkoffClientsFactory $model = null): self
    {
        return new static($model);
    }

    /**
     * Метод получения стакана заявок
     *
     * @param Instrument|Bond|Etf|Currency|Share|Future $instrument Инструмент
     * @param int $depth Глубина стакана
     * @param bool $raise Признак необходимость бросить исключение, если возникла ошибка исполнения. По умолчанию равно <code>true</code>
     *
     * @return Order[][]|null Ассоциативный массив вида
     *  <pre>
     *      'asks' => [
     *          {@link Order},
     *          ...
     *      ],
     *      'bids' => [
     *          {@link Order},
     *          ...
     *      ],
     *
     * @throws RequestException
     * @throws Throwable
     * @throws ValidateException
     */
    public function getOrderbook($instrument, int $depth = 3, bool $raise = true): ?array
    {
        if (!InstrumentsHelper::isInstrumentModelValid($instrument)) {
            throw new ValidateException('Instrument model is not valid');
        }

        try {
            $orderbook_request = new GetOrderBookRequest();

            $orderbook_request->setDepth($depth);
            $orderbook_request->setInstrumentId($instrument->getFigi());

            $clients_factory = $this->getClientsFactory();

            /** @var GetOrderBookResponse $response */
            list($response, $status) = $clients_factory
                ->marketDataServiceClient
                ->GetOrderBook($orderbook_request)
                ->wait()
            ;

            $clients_factory->processRequestStatus($status);

            if (!$response) {
                throw new RequestException('Response is empty');
            }

            /** @var RepeatedField|Order[] $asks */
            $asks = $response->getAsks();

            /** @var RepeatedField|Order[] $bids */
            $bids = $response->getBids();

            return [
                'asks' => !empty($asks) && $asks->count() > 0 ? ArrayHelper::repeatedFieldToArray($asks) : [],
                'bids' => !empty($bids) && $bids->count() > 0 ? ArrayHelper::repeatedFieldToArray($bids) : [],
            ];
        } catch (Throwable $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения границ цен
     *
     * @param Instrument|Bond|Etf|Currency|Share|Future $instrument Инструмент
     *
     * @param bool $raise
     *
     * @return Quotation[]|null[] Массив лучших цен вида
     *  <pre>
     *      [
     *          'ask' => {@link Quotation}|null,
     *          'bid' => {@link Quotation}|null,
     *      ]
     *  </pre>
     *
     * @throws Throwable
     */
    public function getOrderbookTopPrices($instrument, bool $raise = true): array
    {
        try {
            $orderbook = $this->getOrderbook($instrument, 1);

            $top_ask_price = $orderbook['asks'][0] ?? null;
            $top_bid_price = $orderbook['bids'][0] ?? null;

            return [
                'ask' => $top_ask_price ? $top_ask_price->getPrice() : null,
                'bid' => $top_bid_price ? $top_bid_price->getPrice() : null,
            ];
        } catch (Throwable $e) {
            if ($raise) {
                throw  $e;
            }

            return [];
        }
    }
}
