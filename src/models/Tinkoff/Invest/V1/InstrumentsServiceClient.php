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
     * Метод получения графика выплат купонов по облигации.
     * @param \Tinkoff\Invest\V1\GetBondCouponsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBondCoupons(\Tinkoff\Invest\V1\GetBondCouponsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetBondCoupons',
        $argument,
        ['\Tinkoff\Invest\V1\GetBondCouponsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения событий по облигации
     * @param \Tinkoff\Invest\V1\GetBondEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBondEvents(\Tinkoff\Invest\V1\GetBondEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetBondEvents',
        $argument,
        ['\Tinkoff\Invest\V1\GetBondEventsResponse', 'decode'],
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
     * Метод получения опциона по его идентификатору.
     * @param \Tinkoff\Invest\V1\InstrumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function OptionBy(\Tinkoff\Invest\V1\InstrumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/OptionBy',
        $argument,
        ['\Tinkoff\Invest\V1\OptionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deprecated Метод получения списка опционов.
     * @param \Tinkoff\Invest\V1\InstrumentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Options(\Tinkoff\Invest\V1\InstrumentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/Options',
        $argument,
        ['\Tinkoff\Invest\V1\OptionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения списка опционов.
     * @param \Tinkoff\Invest\V1\FilterOptionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function OptionsBy(\Tinkoff\Invest\V1\FilterOptionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/OptionsBy',
        $argument,
        ['\Tinkoff\Invest\V1\OptionsResponse', 'decode'],
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
     * Метод получения индикативных инструментов (индексов, товаров и др.)
     * @param \Tinkoff\Invest\V1\IndicativesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Indicatives(\Tinkoff\Invest\V1\IndicativesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/Indicatives',
        $argument,
        ['\Tinkoff\Invest\V1\IndicativesResponse', 'decode'],
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

    /**
     * Метод получения актива по его идентификатору.
     * @param \Tinkoff\Invest\V1\AssetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAssetBy(\Tinkoff\Invest\V1\AssetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetAssetBy',
        $argument,
        ['\Tinkoff\Invest\V1\AssetResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения списка активов. Метод работает для всех инструментов, за исключением срочных - опционов и фьючерсов.
     * @param \Tinkoff\Invest\V1\AssetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAssets(\Tinkoff\Invest\V1\AssetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetAssets',
        $argument,
        ['\Tinkoff\Invest\V1\AssetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения списка избранных инструментов.
     * @param \Tinkoff\Invest\V1\GetFavoritesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetFavorites(\Tinkoff\Invest\V1\GetFavoritesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetFavorites',
        $argument,
        ['\Tinkoff\Invest\V1\GetFavoritesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод редактирования списка избранных инструментов.
     * @param \Tinkoff\Invest\V1\EditFavoritesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function EditFavorites(\Tinkoff\Invest\V1\EditFavoritesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/EditFavorites',
        $argument,
        ['\Tinkoff\Invest\V1\EditFavoritesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения списка стран.
     * @param \Tinkoff\Invest\V1\GetCountriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCountries(\Tinkoff\Invest\V1\GetCountriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetCountries',
        $argument,
        ['\Tinkoff\Invest\V1\GetCountriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод поиска инструмента.
     * @param \Tinkoff\Invest\V1\FindInstrumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FindInstrument(\Tinkoff\Invest\V1\FindInstrumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/FindInstrument',
        $argument,
        ['\Tinkoff\Invest\V1\FindInstrumentResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения списка брендов.
     * @param \Tinkoff\Invest\V1\GetBrandsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBrands(\Tinkoff\Invest\V1\GetBrandsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetBrands',
        $argument,
        ['\Tinkoff\Invest\V1\GetBrandsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения бренда по его идентификатору.
     * @param \Tinkoff\Invest\V1\GetBrandRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBrandBy(\Tinkoff\Invest\V1\GetBrandRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetBrandBy',
        $argument,
        ['\Tinkoff\Invest\V1\Brand', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения фундаментальных показателей по активу
     * @param \Tinkoff\Invest\V1\GetAssetFundamentalsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAssetFundamentals(\Tinkoff\Invest\V1\GetAssetFundamentalsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetAssetFundamentals',
        $argument,
        ['\Tinkoff\Invest\V1\GetAssetFundamentalsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения расписания выхода отчетностей эмитентов
     * @param \Tinkoff\Invest\V1\GetAssetReportsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAssetReports(\Tinkoff\Invest\V1\GetAssetReportsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetAssetReports',
        $argument,
        ['\Tinkoff\Invest\V1\GetAssetReportsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения мнения аналитиков по инструменту
     * @param \Tinkoff\Invest\V1\GetConsensusForecastsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConsensusForecasts(\Tinkoff\Invest\V1\GetConsensusForecastsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetConsensusForecasts',
        $argument,
        ['\Tinkoff\Invest\V1\GetConsensusForecastsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения прогнозов инвестдомов по инструменту
     * @param \Tinkoff\Invest\V1\GetForecastRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetForecastBy(\Tinkoff\Invest\V1\GetForecastRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetForecastBy',
        $argument,
        ['\Tinkoff\Invest\V1\GetForecastResponse', 'decode'],
        $metadata, $options);
    }

}
