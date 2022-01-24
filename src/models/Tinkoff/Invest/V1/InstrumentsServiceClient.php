<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Tinkoff\Invest\V1;

/**
 */
class InstrumentsServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Метод получения расписания торгов торговых площадок.
     * @param \Tinkoff\Invest\V1\TradingSchedulesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TradingSchedules(\Tinkoff\Invest\V1\TradingSchedulesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/TradingSchedules',
        $argument,
        ['\Tinkoff\Invest\V1\TradingSchedulesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения облигации по её идентификатору.
     * @param \Tinkoff\Invest\V1\InstrumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BondBy(\Tinkoff\Invest\V1\InstrumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/BondBy',
        $argument,
        ['\Tinkoff\Invest\V1\BondResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения списка облигаций.
     * @param \Tinkoff\Invest\V1\InstrumentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Bonds(\Tinkoff\Invest\V1\InstrumentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/Bonds',
        $argument,
        ['\Tinkoff\Invest\V1\BondsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения валюты по её идентификатору.
     * @param \Tinkoff\Invest\V1\InstrumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CurrencyBy(\Tinkoff\Invest\V1\InstrumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/CurrencyBy',
        $argument,
        ['\Tinkoff\Invest\V1\CurrencyResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения списка валют.
     * @param \Tinkoff\Invest\V1\InstrumentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Currencies(\Tinkoff\Invest\V1\InstrumentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/Currencies',
        $argument,
        ['\Tinkoff\Invest\V1\CurrenciesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения инвестиционного фонда по его идентификатору.
     * @param \Tinkoff\Invest\V1\InstrumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function EtfBy(\Tinkoff\Invest\V1\InstrumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/EtfBy',
        $argument,
        ['\Tinkoff\Invest\V1\EtfResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения списка инвестиционных фондов.
     * @param \Tinkoff\Invest\V1\InstrumentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Etfs(\Tinkoff\Invest\V1\InstrumentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/Etfs',
        $argument,
        ['\Tinkoff\Invest\V1\EtfsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения фьючерса по его идентификатору.
     * @param \Tinkoff\Invest\V1\InstrumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FutureBy(\Tinkoff\Invest\V1\InstrumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/FutureBy',
        $argument,
        ['\Tinkoff\Invest\V1\FutureResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения списка фьючерсов.
     * @param \Tinkoff\Invest\V1\InstrumentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Futures(\Tinkoff\Invest\V1\InstrumentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/Futures',
        $argument,
        ['\Tinkoff\Invest\V1\FuturesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения акции по её идентификатору.
     * @param \Tinkoff\Invest\V1\InstrumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ShareBy(\Tinkoff\Invest\V1\InstrumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/ShareBy',
        $argument,
        ['\Tinkoff\Invest\V1\ShareResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения списка акций.
     * @param \Tinkoff\Invest\V1\InstrumentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Shares(\Tinkoff\Invest\V1\InstrumentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/Shares',
        $argument,
        ['\Tinkoff\Invest\V1\SharesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения накопленного купонного дохода по облигации.
     * @param \Tinkoff\Invest\V1\GetAccruedInterestsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAccruedInterests(\Tinkoff\Invest\V1\GetAccruedInterestsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetAccruedInterests',
        $argument,
        ['\Tinkoff\Invest\V1\GetAccruedInterestsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения размера гарантийного обеспечения по фьючерсам.
     * @param \Tinkoff\Invest\V1\GetFuturesMarginRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetFuturesMargin(\Tinkoff\Invest\V1\GetFuturesMarginRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetFuturesMargin',
        $argument,
        ['\Tinkoff\Invest\V1\GetFuturesMarginResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения основной информации об инструменте.
     * @param \Tinkoff\Invest\V1\InstrumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInstrumentBy(\Tinkoff\Invest\V1\InstrumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetInstrumentBy',
        $argument,
        ['\Tinkoff\Invest\V1\InstrumentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод для получения событий выплаты дивидендов по инструменту.
     * @param \Tinkoff\Invest\V1\GetDividendsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDividends(\Tinkoff\Invest\V1\GetDividendsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetDividends',
        $argument,
        ['\Tinkoff\Invest\V1\GetDividendsResponse', 'decode'],
        $metadata, $options);
    }

}
