<?php

namespace Metaseller\TinkoffInvestApi2\providers;

use Exception;
use Google\Protobuf\Internal\RepeatedField;
use Metaseller\TinkoffInvestApi2\exceptions\InstrumentNotFoundException;
use Metaseller\TinkoffInvestApi2\exceptions\RequestException;
use Metaseller\TinkoffInvestApi2\exceptions\ValidateException;
use Metaseller\TinkoffInvestApi2\helpers\ArrayHelper;
use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Tinkoff\Invest\V1\Bond;
use Tinkoff\Invest\V1\BondResponse;
use Tinkoff\Invest\V1\BondsResponse;
use Tinkoff\Invest\V1\Currency;
use Tinkoff\Invest\V1\CurrencyResponse;
use Tinkoff\Invest\V1\Etf;
use Tinkoff\Invest\V1\EtfResponse;
use Tinkoff\Invest\V1\EtfsResponse;
use Tinkoff\Invest\V1\Future;
use Tinkoff\Invest\V1\FutureResponse;
use Tinkoff\Invest\V1\FuturesResponse;
use Tinkoff\Invest\V1\GetFuturesMarginRequest;
use Tinkoff\Invest\V1\GetFuturesMarginResponse;
use Tinkoff\Invest\V1\Instrument;
use Tinkoff\Invest\V1\InstrumentIdType;
use Tinkoff\Invest\V1\InstrumentRequest;
use Tinkoff\Invest\V1\InstrumentResponse;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;
use Tinkoff\Invest\V1\InstrumentType;
use Tinkoff\Invest\V1\SecurityTradingStatus;
use Tinkoff\Invest\V1\Share;
use Tinkoff\Invest\V1\ShareResponse;
use Tinkoff\Invest\V1\SharesResponse;

/**
 * Провайдер данных справочника инструментов сервиса Tinkoff Invest API 2
 *
 * @package Metaseller\TinkoffInvestApi2
 */
class InstrumentsProvider extends BaseDataProvider
{
    /**
     * @var array Кеш справочников инструментов
     */
    protected $_instruments_dictionaries = [];

    /**
     * @var array Кеш справочников инструментов по тикеру
     */
    protected $_cached_instruments = [];

    /**
     * @var bool Флаг, необходимости предзагрузки справочника облигаций в кэш
     *
     * Это происходит либо в конструкторе, если сразу определена модель фабрики клиентов или позднее, как только провайдер будет готов
     */
    protected $_need_preload_bonds = false;

    /**
     * @var bool Флаг, означающий, что полный справочник облигаций был загружен в кэш
     */
    protected $_is_bonds_loaded = false;

    /**
     * @var bool Флаг, необходимости предзагрузки справочника валют в кэш
     *
     * Это происходит либо в конструкторе, если сразу определена модель фабрики клиентов или позднее, как только провайдер будет готов
     */
    protected $_need_preload_currencies = false;

    /**
     * @var bool Флаг, означающий, что полный справочник валют был загружен в кэш
     */
    protected $_is_currencies_loaded = false;

    /**
     * @var bool Флаг, необходимости предзагрузки справочника фондов в кэш
     *
     * Это происходит либо в конструкторе, если сразу определена модель фабрики клиентов или позднее, как только провайдер будет готов
     */
    protected $_need_preload_etfs = false;

    /**
     * @var bool Флаг, означающий, что полный справочник фондов был загружен в кэш
     */
    protected $_is_etfs_loaded = false;

    /**
     * @var bool Флаг, необходимости предзагрузки справочника акций в кэш
     *
     * Это происходит либо в конструкторе, если сразу определена модель фабрики клиентов или позднее, как только провайдер будет готов
     */
    protected $_need_preload_shares = false;

    /**
     * @var bool Флаг, означающий, что полный справочник акций был загружен в кэш
     */
    protected $_is_shares_loaded = false;

    /**
     * @var bool Флаг, необходимости предзагрузки справочника фьючерсов в кэш
     *
     * Это происходит либо в конструкторе, если сразу определена модель фабрики клиентов или позднее, как только провайдер будет готов
     */
    protected $_need_preload_futures = false;

    /**
     * @var bool Флаг, означающий, что полный справочник фьючерсов был загружен в кэш
     */
    protected $_is_futures_loaded = false;

    /**
     * Конструктор класса
     *
     * @param TinkoffClientsFactory|null $model Экземпляр фабрики клиентов доступа к сервису Tinkoff Invest API 2 или <code>null</code>, если инициализация планируется позднее
     * @param bool $preload_shares Флаг необходимости инициализировать кеш акций, путем загрузки полного справочника через API запрос. По умолчанию равно <code>false</code>
     * @param bool $preload_etfs Флаг необходимости инициализировать кеш фондов, путем загрузки полного справочника через API запрос. По умолчанию равно <code>false</code>
     * @param bool $preload_currencies Флаг необходимости инициализировать кеш валют, путем загрузки полного справочника через API запрос. По умолчанию равно <code>false</code>
     * @param bool $preload_bonds Флаг необходимости инициализировать кеш облигаций, путем загрузки полного справочника через API запрос. По умолчанию равно <code>false</code>
     * @param bool $preload_futures Флаг необходимости инициализировать кеш фьючерсов, путем загрузки полного справочника через API запрос. По умолчанию равно <code>false</code>
     */
    public function __construct(
        ?TinkoffClientsFactory $model = null,
        bool $preload_shares = false,
        bool $preload_etfs = false,
        bool $preload_currencies = false,
        bool $preload_bonds = false,
        bool $preload_futures = false
    )
    {
        $this->_need_preload_shares = $preload_shares;
        $this->_need_preload_etfs = $preload_etfs;
        $this->_need_preload_currencies = $preload_currencies;
        $this->_need_preload_bonds = $preload_bonds;
        $this->_need_preload_futures = $preload_futures;

        parent::__construct($model);
    }

    /**
     * Метод создания нового экземпляра провайдера
     *
     * @param TinkoffClientsFactory|null $model Экземпляр фабрики клиентов доступа к сервису Tinkoff Invest API 2 или <code>null</code>, если инициализация планируется позднее
     * @param bool $preload_shares Флаг необходимости инициализировать кеш акций, путем загрузки полного справочника через API запрос. По умолчанию равно <code>false</code>
     * @param bool $preload_etfs Флаг необходимости инициализировать кеш фондов, путем загрузки полного справочника через API запрос. По умолчанию равно <code>false</code>
     * @param bool $preload_currencies Флаг необходимости инициализировать кеш валют, путем загрузки полного справочника через API запрос. По умолчанию равно <code>false</code>
     * @param bool $preload_bonds Флаг необходимости инициализировать кеш облигаций, путем загрузки полного справочника через API запрос. По умолчанию равно <code>false</code>
     * @param bool $preload_futures Флаг необходимости инициализировать кеш фьючерсов, путем загрузки полного справочника через API запрос. По умолчанию равно <code>false</code>
     *
     * @return static Созданный экземпляр провайдера
     */
    public static function create(
        ?TinkoffClientsFactory $model = null,
        bool $preload_shares = false,
        bool $preload_etfs = true,
        bool $preload_currencies = false,
        bool $preload_bonds = false,
        bool $preload_futures = false
    ): self
    {
        return new static($model, $preload_shares, $preload_etfs, $preload_currencies, $preload_bonds, $preload_futures);
    }

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function setClientsFactory(TinkoffClientsFactory $model): self
    {
        parent::setClientsFactory($model);

        if ($this->_need_preload_bonds) {
            $this->loadAllBonds();
        }

        if ($this->_need_preload_currencies) {
            $this->loadAllCurrencies();
        }

        if ($this->_need_preload_etfs) {
            $this->loadAllEtfs();
        }

        if ($this->_need_preload_shares) {
            $this->loadAllShares();
        }

        if ($this->_need_preload_futures) {
            $this->loadAllFutures();
        }

        return $this;
    }

    /**
     * Метод получения полного справочника инструментов типа {@link Bond}
     *
     * @param bool $refresh  Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Bond[] Справочник инструментов типа {@link Bond}
     *
     * @throws Exception
     */
    public function allBonds(bool $refresh = false, bool $raise = true): array
    {
        try {
            if ($refresh || !$this->_is_bonds_loaded) {
                return $this->loadAllBonds();
            }

            return $this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_BOND];
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return [];
        }
    }

    /**
     * Метод получения инструмента типа {@link Bond} по тикеру
     *
     * ВАЖНО: Использование тикера для поиска инструментов идея "так себе", потому что одному тикеру может соответствовать несколько
     * инструментов с разным FIGI. В методе сделана доработка, чтобы он пытался найти инструмент, у которого "tradingStatus":"SECURITY_TRADING_STATUS_NORMAL_TRADING".
     * Метод вернет первый найденный инструмент с таким tradingStatus, если такового не обнаружится, то метод вернет ПОСЛЕДНИЙ в списке инструмент с указанным тикером
     *
     * @param string $ticker Тикер инструмента
     * @param string|null $class_name Режим торгов или <code>null</code>, тогда будет возвращен первый найденный
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Bond|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function bondByTicker(string $ticker, ?string $class_name = null, bool $refresh = false, bool $raise = true): ?Bond
    {
        try {
            if ($class_name) {
                if (!$refresh && $instrument = $this->getCachedInstrumentByTicker(InstrumentType::INSTRUMENT_TYPE_BOND, $ticker, $class_name)) {
                    return $instrument;
                }

                $instruments_request = new InstrumentRequest();

                $instruments_request->setId($ticker);
                $instruments_request->setIdType(InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER);
                $instruments_request->setClassCode($class_name);

                $clients_factory = $this->getClientsFactory();

                /** @var BondResponse $response */
                list($response, $status) = $clients_factory
                    ->instrumentsServiceClient
                    ->BondBy($instruments_request)
                    ->wait()
                ;

                $clients_factory->processRequestStatus($status);

                if (!$response || !($instrument = $response->getInstrument())) {
                    throw new InstrumentNotFoundException('Instrument is not found');
                }

                $this->cacheToDictionary([$instrument]);

                return $instrument;
            }

            return static::searchInstrumentById(
                $this->allBonds($refresh, true),
                InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER,
                $ticker
            );
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения инструмента типа {@link Bond} по FIGI
     *
     * @param string $figi FIGI инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Bond|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function bondByFigi(string $figi, bool $refresh = false, bool $raise = true): ?Bond
    {
        try {
            if (!$refresh && $instrument = $this->getCachedInstrumentByFigi(InstrumentType::INSTRUMENT_TYPE_BOND, $figi)) {
                return $instrument;
            }

            return static::searchInstrumentById(
                $this->allBonds($refresh, true),
                InstrumentIdType::INSTRUMENT_ID_TYPE_FIGI,
                $figi
            );
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения инструмента типа {@link Bond} по UID
     *
     * @param string $uid UID инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Bond|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function bondByUid(string $uid, bool $refresh = false, bool $raise = true): ?Bond
    {
        try {
            if (!$refresh && $instrument = $this->getCachedInstrumentByUid(InstrumentType::INSTRUMENT_TYPE_BOND, $uid)) {
                return $instrument;
            }

            return static::searchInstrumentById(
                $this->allBonds($refresh, true),
                InstrumentIdType::INSTRUMENT_ID_TYPE_UID,
                $uid
            );
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения полного справочника инструментов типа {@link Currency}
     *
     * @param bool $refresh  Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Currency[] Справочник инструментов типа {@link Currency}
     *
     * @throws Exception
     */
    public function allCurrencies(bool $refresh = false, bool $raise = true): array
    {
        try {
            if ($refresh || !$this->_is_currencies_loaded) {
                return $this->loadAllCurrencies();
            }

            return $this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_CURRENCY];
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return [];
        }
    }

    /**
     * Метод получения инструмента типа {@link Currency} по тикеру
     *
     * @param string $ticker Тикер инструмента
     * @param string|null $class_name Режим торгов или <code>null</code>, тогда будет возвращен первый найденный
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Currency|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function currencyByTicker(string $ticker, ?string $class_name = null, bool $refresh = false, bool $raise = true): ?Currency
    {
        try {
            if ($class_name) {
                if (!$refresh && $instrument = $this->getCachedInstrumentByTicker(InstrumentType::INSTRUMENT_TYPE_CURRENCY, $ticker, $class_name)) {
                    return $instrument;
                }

                $instruments_request = new InstrumentRequest();

                $instruments_request->setId($ticker);
                $instruments_request->setIdType(InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER);
                $instruments_request->setClassCode($class_name);

                $clients_factory = $this->getClientsFactory();

                /** @var CurrencyResponse $response */
                list($response, $status) = $clients_factory
                    ->instrumentsServiceClient
                    ->CurrencyBy($instruments_request)
                    ->wait()
                ;

                $clients_factory->processRequestStatus($status);

                if (!$response || !($instrument = $response->getInstrument())) {
                    throw new InstrumentNotFoundException('Instrument is not found');
                }

                $this->cacheToDictionary([$instrument]);

                return $instrument;
            }

            return static::searchInstrumentById(
                $this->allCurrencies($refresh, true),
                InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER,
                $ticker
            );
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения инструмента типа {@link Currency} по FIGI
     *
     * @param string $figi FIGI инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Currency|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function currencyByFigi(string $figi, bool $refresh = false, bool $raise = true): ?Currency
    {
        try {
            if (!$refresh && $instrument = $this->getCachedInstrumentByFigi(InstrumentType::INSTRUMENT_TYPE_CURRENCY, $figi)) {
                return $instrument;
            }

            return static::searchInstrumentById(
                $this->allCurrencies($refresh, true),
                InstrumentIdType::INSTRUMENT_ID_TYPE_FIGI,
                $figi
            );
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения инструмента типа {@link Currency} по UID
     *
     * @param string $uid UID инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Currency|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function currencyByUid(string $uid, bool $refresh = false, bool $raise = true): ?Currency
    {
        try {
            if (!$refresh && $instrument = $this->getCachedInstrumentByUid(InstrumentType::INSTRUMENT_TYPE_CURRENCY, $uid)) {
                return $instrument;
            }

            return static::searchInstrumentById(
                $this->allCurrencies($refresh, true),
                InstrumentIdType::INSTRUMENT_ID_TYPE_UID,
                $uid
            );
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения полного справочника инструментов типа {@link Etf}
     *
     * @param bool $refresh  Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Etf[] Справочник инструментов типа {@link Etf}
     *
     * @throws Exception
     */
    public function allEtfs(bool $refresh = false, bool $raise = true): array
    {
        try {
            if ($refresh || !$this->_is_etfs_loaded) {
                return $this->loadAllEtfs();
            }

            return $this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_ETF];
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return [];
        }
    }

    /**
     * Метод получения инструмента типа {@link Etf} по тикеру
     *
     * ВАЖНО: Использование тикера для поиска инструментов идея "так себе", потому что одному тикеру может соответствовать несколько
     * инструментов с разным FIGI. В методе сделана доработка, чтобы он пытался найти инструмент, у которого "tradingStatus":"SECURITY_TRADING_STATUS_NORMAL_TRADING".
     * Метод вернет первый найденный инструмент с таким tradingStatus, если такового не обнаружится, то метод вернет ПОСЛЕДНИЙ в списке инструмент с указанным тикером
     *
     * @param string $ticker Тикер инструмента
     * @param string|null $class_name Режим торгов или <code>null</code>, тогда будет возвращен первый найденный
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Etf|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function etfByTicker(string $ticker, ?string $class_name = null, bool $refresh = false, bool $raise = true): ?Etf
    {
        try {
            if ($class_name) {
                if (!$refresh && $instrument = $this->getCachedInstrumentByTicker(InstrumentType::INSTRUMENT_TYPE_ETF, $ticker, $class_name)) {
                    return $instrument;
                }

                $instruments_request = new InstrumentRequest();

                $instruments_request->setId($ticker);
                $instruments_request->setIdType(InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER);
                $instruments_request->setClassCode($class_name);

                $clients_factory = $this->getClientsFactory();

                /** @var EtfResponse $response */
                list($response, $status) = $clients_factory
                    ->instrumentsServiceClient
                    ->EtfBy($instruments_request)
                    ->wait()
                ;

                $clients_factory->processRequestStatus($status);

                if (!$response || !($instrument = $response->getInstrument())) {
                    throw new InstrumentNotFoundException('Instrument is not found');
                }

                $this->cacheToDictionary([$instrument]);

                return $instrument;
            }

            return static::searchInstrumentById(
                $this->allEtfs($refresh, true),
                InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER,
                $ticker
            );
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения инструмента типа {@link Etf} по FIGI
     *
     * @param string $figi FIGI инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Etf|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function etfByFigi(string $figi, bool $refresh = false, bool $raise = true): ?Etf
    {
        try {
            if (!$refresh && $instrument = $this->getCachedInstrumentByFigi(InstrumentType::INSTRUMENT_TYPE_ETF, $figi)) {
                return $instrument;
            }

            return static::searchInstrumentById(
                $this->allEtfs($refresh, true),
                InstrumentIdType::INSTRUMENT_ID_TYPE_FIGI,
                $figi
            );
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения инструмента типа {@link Etf} по UID
     *
     * @param string $uid UID инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Etf|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function etfByUid(string $uid, bool $refresh = false, bool $raise = true): ?Etf
    {
        try {
            if (!$refresh && $instrument = $this->getCachedInstrumentByUid(InstrumentType::INSTRUMENT_TYPE_ETF, $uid)) {
                return $instrument;
            }

            return static::searchInstrumentById(
                $this->allEtfs($refresh, true),
                InstrumentIdType::INSTRUMENT_ID_TYPE_UID,
                $uid
            );
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения полного справочника инструментов типа {@link Future}
     *
     * @param bool $refresh  Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Future[] Справочник инструментов типа {@link Future}
     *
     * @throws Exception
     */
    public function allFutures(bool $refresh = false, bool $raise = true): array
    {
        try {
            if ($refresh || !$this->_is_futures_loaded) {
                return $this->loadAllFutures();
            }

            return $this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_FUTURES];
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return [];
        }
    }

    /**
     * Метод получения инструмента типа {@link Future} по тикеру
     *
     * @param string $ticker Тикер инструмента
     * @param string|null $class_name Режим торгов или <code>null</code>, тогда будет возвращен первый найденный
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Future|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function futureByTicker(string $ticker, ?string $class_name = null, bool $refresh = false, bool $raise = true): ?Future
    {
        try {
            if ($class_name) {
                if (!$refresh && $instrument = $this->getCachedInstrumentByTicker(InstrumentType::INSTRUMENT_TYPE_FUTURES, $ticker, $class_name)) {
                    return $instrument;
                }

                $instruments_request = new InstrumentRequest();

                $instruments_request->setId($ticker);
                $instruments_request->setIdType(InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER);
                $instruments_request->setClassCode($class_name);

                $clients_factory = $this->getClientsFactory();

                /** @var FutureResponse $response */
                list($response, $status) = $clients_factory
                    ->instrumentsServiceClient
                    ->FutureBy($instruments_request)
                    ->wait()
                ;

                $clients_factory->processRequestStatus($status);

                if (!$response || !($instrument = $response->getInstrument())) {
                    throw new InstrumentNotFoundException('Instrument is not found');
                }

                $this->cacheToDictionary([$instrument]);

                return $instrument;
            }

            return static::searchInstrumentById(
                $this->allFutures($refresh, true),
                InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER,
                $ticker
            );
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения инструмента типа {@link Future} по FIGI
     *
     * @param string $figi FIGI инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Future|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function futureByFigi(string $figi, bool $refresh = false, bool $raise = true): ?Future
    {
        try {
            if (!$refresh && $instrument = $this->getCachedInstrumentByFigi(InstrumentType::INSTRUMENT_TYPE_FUTURES, $figi)) {
                return $instrument;
            }

            return static::searchInstrumentById(
                $this->allFutures($refresh, true),
                InstrumentIdType::INSTRUMENT_ID_TYPE_FIGI,
                $figi
            );
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения инструмента типа {@link Future} по UID
     *
     * @param string $uid FIGI инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Future|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function futureByUid(string $uid, bool $refresh = false, bool $raise = true): ?Future
    {
        try {
            if (!$refresh && $instrument = $this->getCachedInstrumentByUid(InstrumentType::INSTRUMENT_TYPE_FUTURES, $uid)) {
                return $instrument;
            }

            return static::searchInstrumentById(
                $this->allFutures($refresh, true),
                InstrumentIdType::INSTRUMENT_ID_TYPE_UID,
                $uid
            );
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения полного справочника инструментов типа {@link Share}
     *
     * @param bool $refresh  Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Share[] Справочник инструментов типа {@link Share}
     *
     * @throws Exception
     */
    public function allShares(bool $refresh = false, bool $raise = true): array
    {
        try {
            if ($refresh || !$this->_is_shares_loaded) {
                return $this->loadAllShares();
            }

            return $this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_SHARE];
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return [];
        }
    }

    /**
     * Метод получения инструмента типа {@link Share} по тикеру
     *
     * ВАЖНО: Использование тикера для поиска инструментов идея "так себе", потому что одному тикеру может соответствовать несколько
     * инструментов с разным FIGI. В методе сделана доработка, чтобы он пытался найти инструмент, у которого "tradingStatus":"SECURITY_TRADING_STATUS_NORMAL_TRADING".
     * Метод вернет первый найденный инструмент с таким tradingStatus, если такового не обнаружится, то метод вернет ПОСЛЕДНИЙ в списке инструмент с указанным тикером
     *
     * @param string $ticker Тикер инструмента
     * @param string|null $class_name Режим торгов или <code>null</code>, тогда будет возвращен первый найденный
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Share|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function shareByTicker(string $ticker, ?string $class_name = null, bool $refresh = false, bool $raise = true): ?Share
    {
        try {
            if ($class_name) {
                if (!$refresh && $instrument = $this->getCachedInstrumentByTicker(InstrumentType::INSTRUMENT_TYPE_SHARE, $ticker, $class_name)) {
                    return $instrument;
                }

                $instruments_request = new InstrumentRequest();

                $instruments_request->setId($ticker);
                $instruments_request->setIdType(InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER);
                $instruments_request->setClassCode($class_name);

                $clients_factory = $this->getClientsFactory();

                /** @var ShareResponse $response */
                list($response, $status) = $clients_factory
                    ->instrumentsServiceClient
                    ->ShareBy($instruments_request)
                    ->wait()
                ;

                $clients_factory->processRequestStatus($status);

                if (!$response || !($instrument = $response->getInstrument())) {
                    throw new InstrumentNotFoundException('Instrument is not found');
                }

                $this->cacheToDictionary([$instrument]);

                return $instrument;
            }

            return static::searchInstrumentById(
                $this->allShares($refresh, true),
                InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER,
                $ticker
            );
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения инструмента типа {@link Share} по FIGI
     *
     * @param string $figi FIGI инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Share|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function shareByFigi(string $figi, bool $refresh = false, bool $raise = true): ?Share
    {
        try {
            if (!$refresh && $instrument = $this->getCachedInstrumentByFigi(InstrumentType::INSTRUMENT_TYPE_SHARE, $figi)) {
                return $instrument;
            }

            return static::searchInstrumentById(
                $this->allShares($refresh, true),
                InstrumentIdType::INSTRUMENT_ID_TYPE_FIGI,
                $figi
            );
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения инструмента типа {@link Share} по UID
     *
     * @param string $uid UID инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Share|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function shareByUid(string $uid, bool $refresh = false, bool $raise = true): ?Share
    {
        try {
            if (!$refresh && $instrument = $this->getCachedInstrumentByUid(InstrumentType::INSTRUMENT_TYPE_SHARE, $uid)) {
                return $instrument;
            }

            return static::searchInstrumentById(
                $this->allShares($refresh, true),
                InstrumentIdType::INSTRUMENT_ID_TYPE_UID,
                $uid
            );
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод поиска инструмента по FIGI
     *
     * @param string $figi FIGI инструмента
     *
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Bond|Currency|Etf|Future|Instrument|Share|null Найденный экземпляр инструмента или <code>null</code>
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function searchByFigi(string $figi, bool $raise = true)
    {
        $types = [
            InstrumentType::INSTRUMENT_TYPE_SHARE,
            InstrumentType::INSTRUMENT_TYPE_ETF,
            InstrumentType::INSTRUMENT_TYPE_CURRENCY,
            InstrumentType::INSTRUMENT_TYPE_BOND,
            InstrumentType::INSTRUMENT_TYPE_FUTURES,
        ];

        try {
            for ($i = 1; $i <= 3; $i++) {
                if ($i === 1) {
                    /** В первый раунд поиска ищем по доступному кэшу среди типизированных экземпляров инструментов */
                    foreach ($types as $type) {
                        if ($instrument = $this->getCachedInstrumentByFigi($type, $figi)) {
                            return $instrument;
                        }
                    }
                } elseif ($i === 2) {
                    /** Во второй раунд поиска дозагружаем справочники через API и ищем по ним среди типизированных экземпляров инструментов */
                    if ($instrument = $this->shareByFigi($figi, false, false)) {
                        return $instrument;
                    }

                    if ($instrument = $this->etfByFigi($figi, false, false)) {
                        return $instrument;
                    }

                    if ($instrument = $this->currencyByFigi($figi, false, false)) {
                        return $instrument;
                    }

                    if ($instrument = $this->bondByFigi($figi, false, false)) {
                        return $instrument;
                    }

                    if ($instrument = $this->futureByFigi($figi, false, false)) {
                        return $instrument;
                    }
                } elseif ($i === 3) {
                    /** В третий раунд поиска ищем не типизированный экземпляр инструмента */
                    if ($instrument = $this->instrumentByFigi($figi, false, false)) {
                        return $instrument;
                    }
                }
            }

            throw new InstrumentNotFoundException('Instrument is not found');
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод поиска инструмента по UID
     *
     * @param string $uid UID инструмента
     *
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Bond|Currency|Etf|Future|Instrument|Share|null Найденный экземпляр инструмента или <code>null</code>
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function searchByUid(string $uid, bool $raise = true)
    {
        $types = [
            InstrumentType::INSTRUMENT_TYPE_SHARE,
            InstrumentType::INSTRUMENT_TYPE_ETF,
            InstrumentType::INSTRUMENT_TYPE_CURRENCY,
            InstrumentType::INSTRUMENT_TYPE_BOND,
            InstrumentType::INSTRUMENT_TYPE_FUTURES,
        ];

        try {
            for ($i = 1; $i <= 3; $i++) {
                if ($i === 1) {
                    /** В первый раунд поиска ищем по доступному кэшу среди типизированных экземпляров инструментов */
                    foreach ($types as $type) {
                        if ($instrument = $this->getCachedInstrumentByUid($type, $uid)) {
                            return $instrument;
                        }
                    }
                } elseif ($i === 2) {
                    /** Во второй раунд поиска дозагружаем справочники через API и ищем по ним среди типизированных экземпляров инструментов */
                    if ($instrument = $this->shareByUid($uid, false, false)) {
                        return $instrument;
                    }

                    if ($instrument = $this->etfByUid($uid, false, false)) {
                        return $instrument;
                    }

                    if ($instrument = $this->currencyByUid($uid, false, false)) {
                        return $instrument;
                    }

                    if ($instrument = $this->bondByUid($uid, false, false)) {
                        return $instrument;
                    }

                    if ($instrument = $this->futureByUid($uid, false, false)) {
                        return $instrument;
                    }
                } elseif ($i === 3) {
                    /** В третий раунд поиска ищем не типизированный экземпляр инструмента */
                    if ($instrument = $this->instrumentByUid($uid, false, false)) {
                        return $instrument;
                    }
                }
            }

            throw new InstrumentNotFoundException('Instrument is not found');
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод поиска инструмента по тикеру
     *
     * @param string $ticker Тикер инструмента
     * @param string|null $class_name Режим торгов или <code>null</code>, тогда будет возвращен первый найденный
     *
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Bond|Currency|Etf|Future|Instrument|Share|null Найденный экземпляр инструмента или <code>null</code>
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function searchByTicker(string $ticker, ?string $class_name = null, bool $raise = true)
    {
        $types = [
            InstrumentType::INSTRUMENT_TYPE_SHARE,
            InstrumentType::INSTRUMENT_TYPE_ETF,
            InstrumentType::INSTRUMENT_TYPE_CURRENCY,
            InstrumentType::INSTRUMENT_TYPE_BOND,
            InstrumentType::INSTRUMENT_TYPE_FUTURES,
        ];

        try {
            for ($i = 1; $i <= 2; $i++) {
                if ($i === 1) {
                    /** В первый раунд поиска ищем по доступному кэшу среди типизированных экземпляров инструментов */
                    foreach ($types as $type) {
                        if ($instrument = $this->getCachedInstrumentByTicker($type, $ticker, $class_name)) {
                            return $instrument;
                        }
                    }
                } elseif ($i === 2) {
                    /** Во второй раунд поиска ищем через методы получения типизированных экземпляров инструментов */
                    if ($instrument = $this->shareByTicker($ticker, $class_name, false, false)) {
                        return $instrument;
                    }

                    if ($instrument = $this->etfByTicker($ticker, $class_name, false, false)) {
                        return $instrument;
                    }

                    if ($instrument = $this->currencyByTicker($ticker, $class_name, false, false)) {
                        return $instrument;
                    }

                    if ($instrument = $this->bondByTicker($ticker, $class_name, false, false)) {
                        return $instrument;
                    }

                    if ($instrument = $this->futureByTicker($ticker, $class_name, false, false)) {
                        return $instrument;
                    }

                    if ($instrument = $this->instrumentByTicker($ticker, $class_name, false, false)) {
                        return $instrument;
                    }
                }
            }

            throw new InstrumentNotFoundException('Instrument is not found');
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения инструмента типа {@link Instrument} по тикеру
     *
     * Модель, содержащая основную информацию об инструменте.
     *
     * ВАЖНО: Использование тикера для поиска инструментов идея "так себе", потому что одному тикеру может соответствовать несколько
     * инструментов с разным FIGI.
     *
     * @param string $ticker Тикер инструмента
     * @param string|null $class_name Режим торгов или <code>null</code>, тогда будет возвращен первый найденный
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Instrument|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws Exception
     */
    public function instrumentByTicker(string $ticker, ?string $class_name = null, bool $refresh = false, bool $raise = true): ?Instrument
    {
        try {
            $instrument_id_type = InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER;

            if ($class_name) {
                if (!$refresh && $instrument = $this->getCachedInstrumentByTicker(InstrumentType::INSTRUMENT_TYPE_UNSPECIFIED, $ticker, $class_name)) {
                    return $instrument;
                }

                $instruments_request = new InstrumentRequest();

                $instruments_request->setId($ticker);
                $instruments_request->setIdType($instrument_id_type);
                $instruments_request->setClassCode($class_name);

                $clients_factory = $this->getClientsFactory();

                /** @var InstrumentResponse $response */
                list($response, $status) = $clients_factory
                    ->instrumentsServiceClient
                    ->GetInstrumentBy($instruments_request)
                    ->wait()
                ;

                $clients_factory->processRequestStatus($status);

                if (!$response || !($instrument = $response->getInstrument())) {
                    throw new InstrumentNotFoundException('Instrument is not found');
                }

                $this->cacheToDictionary([$instrument]);

                return $instrument;
            }

            throw new InstrumentNotFoundException('Instrument is not found');
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения инструмента типа {@link Instrument} по FIGI
     *
     * Модель, содержащая основную информацию об инструменте
     *
     * @param string $figi FIGI инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Instrument|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function instrumentByFigi(string $figi, bool $refresh = false, bool $raise = true): ?Instrument
    {
        try {
            $instrument_id_type = InstrumentIdType::INSTRUMENT_ID_TYPE_FIGI;

            if (!$refresh && $instrument = $this->getCachedInstrumentByFigi(InstrumentType::INSTRUMENT_TYPE_UNSPECIFIED, $figi)) {
                return $instrument;
            }

            $instruments_request = new InstrumentRequest();

            $instruments_request->setId($figi);
            $instruments_request->setIdType($instrument_id_type);

            $clients_factory = $this->getClientsFactory();

            /** @var InstrumentResponse $response */
            list($response, $status) = $clients_factory
                ->instrumentsServiceClient
                ->GetInstrumentBy($instruments_request)
                ->wait()
            ;

            $clients_factory->processRequestStatus($status);

            if (!$response || !($instrument = $response->getInstrument())) {
                throw new InstrumentNotFoundException('Instrument is not found');
            }

            $this->cacheToDictionary([$instrument]);

            return $instrument;
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения инструмента типа {@link Instrument} по UID
     *
     * Модель, содержащая основную информацию об инструменте
     *
     * @param string $uid UID инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     * @param bool $raise Признак необходимость бросить исключение, если инструмент не найден. По умолчанию равно <code>true</code>
     *
     * @return Instrument|null Экземпляр инструмента или <code>null</code>, если инструмент не найден и не требуется бросок исключения
     *
     * @throws InstrumentNotFoundException
     * @throws Exception
     */
    public function instrumentByUid(string $uid, bool $refresh = false, bool $raise = true): ?Instrument
    {
        try {
            $instrument_id_type = InstrumentIdType::INSTRUMENT_ID_TYPE_UID;

            if (!$refresh && $instrument = $this->getCachedInstrumentByUid(InstrumentType::INSTRUMENT_TYPE_UNSPECIFIED, $uid)) {
                return $instrument;
            }

            $instruments_request = new InstrumentRequest();

            $instruments_request->setId($uid);
            $instruments_request->setIdType($instrument_id_type);

            $clients_factory = $this->getClientsFactory();

            /** @var InstrumentResponse $response */
            list($response, $status) = $clients_factory
                ->instrumentsServiceClient
                ->GetInstrumentBy($instruments_request)
                ->wait()
            ;

            $clients_factory->processRequestStatus($status);

            if (!$response || !($instrument = $response->getInstrument())) {
                throw new InstrumentNotFoundException('Instrument is not found');
            }

            $this->cacheToDictionary([$instrument]);

            return $instrument;
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения спец. информации о фьючерсе
     *
     * @param Future|Instrument $instrument Инструмент типа фьючерс
     *
     * @return GetFuturesMarginResponse Спец. информация о фьючерсе
     *
     * @throws InstrumentNotFoundException
     * @throws ValidateException
     * @throws RequestException
     *
     * @see https://tinkoff.github.io/investAPI/instruments/#getfuturesmargin
     */
    public function getFuturesData($instrument): GetFuturesMarginResponse
    {
        if ($instrument instanceof Future || (($instrument instanceof Instrument) && $instrument->getInstrumentType() === 'futures')) {
            $futures_data_request = new GetFuturesMarginRequest();
            $futures_data_request->setFigi($instrument->getFigi());

            $clients_factory = $this->getClientsFactory();

            /** @var GetFuturesMarginResponse $response */
            list($response, $status) = $clients_factory
                ->instrumentsServiceClient
                ->GetFuturesMargin($futures_data_request)
                ->wait()
            ;

            $clients_factory->processRequestStatus($status);

            if (!$response) {
                throw new InstrumentNotFoundException('Futures data is not found');
            }

            return $response;
        }

        throw new ValidateException('Instrument should be Future type');
    }

    /**
     * @inheritDoc
     */
    public function resetCachedProviderData(): self
    {
        if ($this->_instruments_dictionaries) {
            unset ($this->_instruments_dictionaries);
        }

        if ($this->_cached_instruments) {
            unset ($this->_cached_instruments);
        }

        $this->_instruments_dictionaries = [];
        $this->_cached_instruments = [];

        $this->_is_bonds_loaded = false;
        $this->_is_currencies_loaded = false;
        $this->_is_etfs_loaded = false;
        $this->_is_futures_loaded = false;
        $this->_is_shares_loaded = false;

        return $this;
    }

    /**
     * Метод запрашивает через запрос к API справочник всех облигаций и кеширует загруженный список в текущий экземпляр провайдера
     *
     * @return Bond[] Массив загруженных инструментов
     *
     * @throws Exception
     */
    protected function loadAllBonds(): array
    {
        $instruments_request = new InstrumentsRequest();
        $instruments_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        $clients_factory = $this->getClientsFactory();

        /** @var BondsResponse $response */
        list($response, $status) = $clients_factory
            ->instrumentsServiceClient
            ->Bonds($instruments_request)
            ->wait()
        ;

        $clients_factory->processRequestStatus($status);

        /** @var Bond[] $instruments */
        $instruments = ArrayHelper::repeatedFieldToArray($response->getInstruments());

        if (!empty($this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_BOND])) {
            unset($this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_BOND]);
        }

        $this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_BOND] = $instruments;
        $this->_is_bonds_loaded = true;

        return $this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_BOND];
    }

    /**
     * Метод запрашивает через запрос к API справочник всех валют и кеширует загруженный список в текущий экземпляр провайдера
     *
     * @return Currency[] Массив загруженных инструментов
     *
     * @throws Exception
     */
    protected function loadAllCurrencies(): array
    {
        $instruments_request = new InstrumentsRequest();
        $instruments_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        $clients_factory = $this->getClientsFactory();

        /** @var BondsResponse $response */
        list($response, $status) = $clients_factory
            ->instrumentsServiceClient
            ->Currencies($instruments_request)
            ->wait()
        ;

        $clients_factory->processRequestStatus($status);

        /** @var Currency[] $instruments */
        $instruments = ArrayHelper::repeatedFieldToArray($response->getInstruments());

        if (!empty($this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_CURRENCY])) {
            unset($this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_CURRENCY]);
        }

        $this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_CURRENCY] = $instruments;
        $this->_is_currencies_loaded = true;

        return $this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_CURRENCY];
    }

    /**
     * Метод запрашивает через запрос к API справочник всех фондов и кеширует загруженный список в текущий экземпляр провайдера
     *
     * @return Etf[] Массив загруженных инструментов
     *
     * @throws Exception
     */
    protected function loadAllEtfs(): array
    {
        $instruments_request = new InstrumentsRequest();
        $instruments_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        $clients_factory = $this->getClientsFactory();

        /** @var EtfsResponse $response */
        list($response, $status) = $clients_factory
            ->instrumentsServiceClient
            ->Etfs($instruments_request)
            ->wait()
        ;

        $clients_factory->processRequestStatus($status);

        /** @var Etf[] $instruments */
        $instruments = ArrayHelper::repeatedFieldToArray($response->getInstruments());

        if (!empty($this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_ETF])) {
            unset($this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_ETF]);
        }

        $this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_ETF] = $instruments;
        $this->_is_etfs_loaded = true;

        return $this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_ETF];
    }

    /**
     * Метод запрашивает через запрос к API справочник всех акций и кеширует загруженный список в текущий экземпляр провайдера
     *
     * @return Share[] Массив загруженных инструментов
     *
     * @throws Exception
     */
    protected function loadAllShares(): array
    {
        $instruments_request = new InstrumentsRequest();
        $instruments_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        $clients_factory = $this->getClientsFactory();

        /** @var SharesResponse $response */
        list($response, $status) = $clients_factory
            ->instrumentsServiceClient
            ->Shares($instruments_request)
            ->wait()
        ;

        $clients_factory->processRequestStatus($status);

        /** @var Share[] $instruments */
        $instruments = ArrayHelper::repeatedFieldToArray($response->getInstruments());

        if (!empty($this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_SHARE])) {
            unset($this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_SHARE]);
        }

        $this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_SHARE] = $instruments;
        $this->_is_shares_loaded = true;

        return $this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_SHARE];
    }

    /**
     * Метод запрашивает через запрос к API справочник всех фьючерсов и кеширует загруженный список в текущий экземпляр провайдера
     *
     * @return Future[] Массив загруженных инструментов
     *
     * @throws Exception
     */
    protected function loadAllFutures(): array
    {
        $instruments_request = new InstrumentsRequest();
        $instruments_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        $clients_factory = $this->getClientsFactory();

        /** @var FuturesResponse $response */
        list($response, $status) = $clients_factory
            ->instrumentsServiceClient
            ->Futures($instruments_request)
            ->wait()
        ;

        $clients_factory->processRequestStatus($status);

        /** @var Future[] $instruments */
        $instruments = ArrayHelper::repeatedFieldToArray($response->getInstruments());

        if (!empty($this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_FUTURES])) {
            unset($this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_FUTURES]);
        }

        $this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_FUTURES] = $instruments;
        $this->_is_futures_loaded = true;

        return $this->_instruments_dictionaries[InstrumentType::INSTRUMENT_TYPE_FUTURES];
    }

    /**
     * Метод кеширует справочник инструментов в рамках экземпляра класса
     *
     * @param Bond[]|Currency[]|Etf[]|Future[]|Share[]|Instrument[]|RepeatedField $instruments Массив инструментов для помещения в кэш
     *
     * @return void
     *
     * @throws Exception
     */
    protected function cacheToDictionary($instruments): void
    {
        foreach ($instruments as $instrument) {
            $ticker = $instrument->getTicker();
            $figi = $instrument->getFigi();
            $uid = $instrument->getUid();

            $class_code = $instrument->getClassCode();

            switch(true) {
                case ($instrument instanceof Bond):
                    $type = InstrumentType::INSTRUMENT_TYPE_BOND;

                    break;
                case ($instrument instanceof Currency):
                    $type = InstrumentType::INSTRUMENT_TYPE_CURRENCY;

                    break;
                case ($instrument instanceof Etf):
                    $type = InstrumentType::INSTRUMENT_TYPE_ETF;

                    break;
                case ($instrument instanceof Future):
                    $type = InstrumentType::INSTRUMENT_TYPE_FUTURES;

                    break;
                case ($instrument instanceof Share):
                    $type = InstrumentType::INSTRUMENT_TYPE_SHARE;

                    break;
                case ($instrument instanceof Instrument):
                    $type = InstrumentType::INSTRUMENT_TYPE_UNSPECIFIED;

                    break;
                default:
                    throw new Exception('Unsupported instrument type');
            }

            $this->_cached_instruments[$type][InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER][$ticker][$class_code] = $instrument;
            $this->_cached_instruments[$type][InstrumentIdType::INSTRUMENT_ID_TYPE_FIGI][$figi] = $instrument;
            $this->_cached_instruments[$type][InstrumentIdType::INSTRUMENT_ID_TYPE_UID][$uid] = $instrument;
        }
    }

    /**
     * Метод поиска инструмента по закешированному справочнику по тикеру
     *
     * @param int $instrument_type Тип инструмента {@link InstrumentType}
     * @param string $ticker Тикер инструмента
     * @param string $class_name Режим торгов
     *
     * @return Bond|Currency|Etf|Future|Share|Instrument|null
     *
     * @see https://tinkoff.github.io/investAPI/faq_identification/
     */
    protected function getCachedInstrumentByTicker(int $instrument_type, string $ticker, string $class_name)
    {
        return $this->_cached_instruments[$instrument_type][InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER][$ticker][$class_name] ?? null;
    }

    /**
     * Метод поиска инструмента по закешированному справочнику по FIGI
     *
     * @param int $instrument_type Тип инструмента {@link InstrumentType}
     * @param string $figi FIGI инструмента
     *
     * @return Bond|Currency|Etf|Future|Share|Instrument|null
     */
    protected function getCachedInstrumentByFigi(int $instrument_type, string $figi)
    {
        return $this->_cached_instruments[$instrument_type][InstrumentIdType::INSTRUMENT_ID_TYPE_FIGI][$figi] ?? null;
    }

    /**
     * Метод поиска инструмента по закешированному справочнику по UID
     *
     * @param int $instrument_type Тип инструмента {@link InstrumentType}
     * @param string $uid UID инструмента
     *
     * @return Bond|Currency|Etf|Future|Share|Instrument|null
     */
    protected function getCachedInstrumentByUid(int $instrument_type, string $uid)
    {
        return $this->_cached_instruments[$instrument_type][InstrumentIdType::INSTRUMENT_ID_TYPE_UID][$uid] ?? null;
    }

    /**
     * Метод поиска по массиву инструмента по тикеру
     *
     * @param RepeatedField|Bond[]|Etf[]|Future[]|Share[]|Currency[] $instruments Массив инструментов для поиска
     * @param string $ticker Тикер для поиска
     *
     * @return Bond|Etf|Future|Share|Currency
     *
     * @throws InstrumentNotFoundException
     */
    protected static function searchInstrumentByTicker($instruments, string $ticker)
    {
        foreach ($instruments as $instrument) {
            if ($instrument->getTicker() === $ticker) {
                $factor_1 = $instrument->getTradingStatus() === SecurityTradingStatus::SECURITY_TRADING_STATUS_NORMAL_TRADING;
                $factor_2 = $instrument->getApiTradeAvailableFlag();
                $factor_3 = $instrument->getBuyAvailableFlag();
                $factor_4 = $instrument->getSellAvailableFlag();

                $found_instrument_candidates[0] = $instrument;

                if ($factor_1) {
                    $found_instrument_candidates[1] = $instrument;
                }

                if ($factor_1 && $factor_2) {
                    $found_instrument_candidates[2] = $instrument;
                }

                if ($factor_1 && $factor_2 && $factor_3) {
                    $found_instrument_candidates[3] = $instrument;
                }

                if ($factor_1 && $factor_2 && $factor_3 && $factor_4) {
                    return $instrument;
                }
            }
        }

        if (!empty($found_instrument_candidates)) {
            return end($found_instrument_candidates);
        }

        throw new InstrumentNotFoundException('Instrument is not found');
    }

    /**
     * Метод поиска по массиву инструмента по идентификатору
     *
     * @param RepeatedField|Bond[]|Etf[]|Future[]|Share[]|Currency[] $instruments Массив инструментов для поиска
     * @param int $instrument_id_type Тип идентификатора {@link InstrumentIdType}
     * @param string $id Тикер для поиска
     *
     * @return Bond|Etf|Future|Share|Currency
     *
     * @throws InstrumentNotFoundException
     */
    protected static function searchInstrumentById($instruments, int $instrument_id_type, string $id)
    {
        if ($instrument_id_type === InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER) {
            return static::searchInstrumentByTicker($instruments, $id);
        }

        foreach ($instruments as $instrument) {
            if ($instrument_id_type === InstrumentIdType::INSTRUMENT_ID_TYPE_FIGI && $instrument->getFigi() === $id) {
                return $instrument;
            }

            if ($instrument_id_type === InstrumentIdType::INSTRUMENT_ID_TYPE_UID && $instrument->getUid() === $id) {
                return $instrument;
            }
        }

        throw new InstrumentNotFoundException('Instrument is not found');
    }
}
