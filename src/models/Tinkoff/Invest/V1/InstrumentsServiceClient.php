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
     * TradingSchedules — расписания торговых площадок
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
     * BondBy — получить облигацию по ее идентификатору
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
     * Bonds — список облигаций
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
     * GetBondCoupons — график выплат купонов по облигации
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
     * GetBondEvents — события по облигации
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
     * CurrencyBy — получить валюту по ее идентификатору
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
     * Currencies — список валют
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
     * EtfBy — получить инвестиционный фонд по его идентификатору
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
     * Etfs — список инвестиционных фондов
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
     * FutureBy — получить фьючерс по его идентификатору
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
     * Futures — список фьючерсов
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
     * OptionBy — получить опцион по его идентификатору
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
     * Deprecated Options — список опционов
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
     * OptionsBy — список опционов
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
     * ShareBy — получить акцию по ее идентификатору
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
     * Shares — список акций
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
     * Indicatives — индикативные инструменты — индексы, товары и другие
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
     * GetAccruedInterests — накопленный купонный доход по облигации
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
     * GetFuturesMargin — размера гарантийного обеспечения по фьючерсам
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
     * GetInstrumentBy — основная информация об инструменте
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
     * GetDividends — события выплаты дивидендов по инструменту
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
     * GetAssetBy — получить актив по его идентификатору
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
     * GetAssets — список активов
     * Метод работает для всех инструментов, кроме срочных — фьючерсов и опционов
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
     * GetFavorites — получить список избранных инструментов
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
     * EditFavorites — отредактировать список избранных инструментов
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
     * CreateFavoriteGroup — создать новую группу избранных инструментов
     * @param \Tinkoff\Invest\V1\CreateFavoriteGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateFavoriteGroup(\Tinkoff\Invest\V1\CreateFavoriteGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/CreateFavoriteGroup',
        $argument,
        ['\Tinkoff\Invest\V1\CreateFavoriteGroupResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * DeleteFavoriteGroup — удалить группу избранных инструментов
     * @param \Tinkoff\Invest\V1\DeleteFavoriteGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteFavoriteGroup(\Tinkoff\Invest\V1\DeleteFavoriteGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/DeleteFavoriteGroup',
        $argument,
        ['\Tinkoff\Invest\V1\DeleteFavoriteGroupResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetFavoriteGroups — список групп избранных инструментов
     * @param \Tinkoff\Invest\V1\GetFavoriteGroupsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetFavoriteGroups(\Tinkoff\Invest\V1\GetFavoriteGroupsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetFavoriteGroups',
        $argument,
        ['\Tinkoff\Invest\V1\GetFavoriteGroupsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetCountries — список стран
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
     * FindInstrument — найти инструмент
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
     * GetBrands — список брендов
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
     * GetBrandBy — получить бренд по его идентификатору
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
     * GetAssetFundamentals — фундаментальные показатели по активу
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
     * GetAssetReports — расписания выхода отчетностей эмитентов
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
     * GetConsensusForecasts — мнения аналитиков по инструменту
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
     * GetForecastBy — прогнозы инвестдомов по инструменту
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

    /**
     * GetRiskRates — ставки риска по инструменту
     * @param \Tinkoff\Invest\V1\RiskRatesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRiskRates(\Tinkoff\Invest\V1\RiskRatesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetRiskRates',
        $argument,
        ['\Tinkoff\Invest\V1\RiskRatesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetInsiderDeals —  сделки инсайдеров по инструментам
     * @param \Tinkoff\Invest\V1\GetInsiderDealsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInsiderDeals(\Tinkoff\Invest\V1\GetInsiderDealsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/GetInsiderDeals',
        $argument,
        ['\Tinkoff\Invest\V1\GetInsiderDealsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * StructuredNoteBy — получить структурную ноту по ее идентификатору
     * @param \Tinkoff\Invest\V1\InstrumentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StructuredNoteBy(\Tinkoff\Invest\V1\InstrumentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/StructuredNoteBy',
        $argument,
        ['\Tinkoff\Invest\V1\StructuredNoteResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * StructuredNotes — список структурных нот
     * @param \Tinkoff\Invest\V1\InstrumentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StructuredNotes(\Tinkoff\Invest\V1\InstrumentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.InstrumentsService/StructuredNotes',
        $argument,
        ['\Tinkoff\Invest\V1\StructuredNotesResponse', 'decode'],
        $metadata, $options);
    }

}
