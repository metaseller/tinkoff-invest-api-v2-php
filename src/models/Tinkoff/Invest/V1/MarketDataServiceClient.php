<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Tinkoff\Invest\V1;

/**
 */
class MarketDataServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * GetCandles — исторические свечи по инструменту
     * @param \Tinkoff\Invest\V1\GetCandlesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCandles(\Tinkoff\Invest\V1\GetCandlesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.MarketDataService/GetCandles',
        $argument,
        ['\Tinkoff\Invest\V1\GetCandlesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetLastPrices — цены последних сделок по инструментам
     * @param \Tinkoff\Invest\V1\GetLastPricesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetLastPrices(\Tinkoff\Invest\V1\GetLastPricesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.MarketDataService/GetLastPrices',
        $argument,
        ['\Tinkoff\Invest\V1\GetLastPricesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetOrderBook — стакан по инструменту
     * @param \Tinkoff\Invest\V1\GetOrderBookRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetOrderBook(\Tinkoff\Invest\V1\GetOrderBookRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.MarketDataService/GetOrderBook',
        $argument,
        ['\Tinkoff\Invest\V1\GetOrderBookResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetTradingStatus — статус торгов по инструменту
     * @param \Tinkoff\Invest\V1\GetTradingStatusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTradingStatus(\Tinkoff\Invest\V1\GetTradingStatusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.MarketDataService/GetTradingStatus',
        $argument,
        ['\Tinkoff\Invest\V1\GetTradingStatusResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetTradingStatuses — статус торгов по инструментам
     * @param \Tinkoff\Invest\V1\GetTradingStatusesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTradingStatuses(\Tinkoff\Invest\V1\GetTradingStatusesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.MarketDataService/GetTradingStatuses',
        $argument,
        ['\Tinkoff\Invest\V1\GetTradingStatusesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetLastTrades — обезличенные сделки
     * Обезличенные сделки по инструменту. Метод гарантирует получение информации за последний час.
     * @param \Tinkoff\Invest\V1\GetLastTradesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetLastTrades(\Tinkoff\Invest\V1\GetLastTradesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.MarketDataService/GetLastTrades',
        $argument,
        ['\Tinkoff\Invest\V1\GetLastTradesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetClosePrices — цены закрытия торговой сессии по инструментам
     * @param \Tinkoff\Invest\V1\GetClosePricesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetClosePrices(\Tinkoff\Invest\V1\GetClosePricesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.MarketDataService/GetClosePrices',
        $argument,
        ['\Tinkoff\Invest\V1\GetClosePricesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetTechAnalysis — технические индикаторы по инструменту
     * @param \Tinkoff\Invest\V1\GetTechAnalysisRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTechAnalysis(\Tinkoff\Invest\V1\GetTechAnalysisRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.MarketDataService/GetTechAnalysis',
        $argument,
        ['\Tinkoff\Invest\V1\GetTechAnalysisResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetMarketValues — рыночные данные по инструментам
     * @param \Tinkoff\Invest\V1\GetMarketValuesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMarketValues(\Tinkoff\Invest\V1\GetMarketValuesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.MarketDataService/GetMarketValues',
        $argument,
        ['\Tinkoff\Invest\V1\GetMarketValuesResponse', 'decode'],
        $metadata, $options);
    }

}
