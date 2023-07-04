<?php

namespace Metaseller\TinkoffInvestApi2\providers;

use Exception;
use Google\Protobuf\Internal\RepeatedField;
use Metaseller\TinkoffInvestApi2\exceptions\InstrumentNotFoundException;
use Metaseller\TinkoffInvestApi2\exceptions\ValidateException;
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
use Tinkoff\Invest\V1\SecurityTradingStatus;
use Tinkoff\Invest\V1\Share;
use Tinkoff\Invest\V1\ShareResponse;
use Tinkoff\Invest\V1\SharesResponse;

/**
 * Базовая модель провайдера данных сервиса Tinkoff Invest API 2
 *
 * @package Metaseller\TinkoffInvestApi2
 */
class InstrumentsProvider extends BaseDataProvider
{
    /**
     * @var array Кеш справочников инструментов
     */
    protected $_dictionary = [];

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
        TinkoffClientsFactory $model = null,
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
        TinkoffClientsFactory $model = null,
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
    public function bondByTicker(string $ticker, string $class_name = null, bool $refresh = false, bool $raise = true): ?Bond
    {
        try {
            $found_instrument_candidate_1 = null;
            $found_instrument_candidate_2 = null;

            $instrument_type = 'bond';
            $instrument_id_type = InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER;

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByTicker($instrument_type, $ticker, $class_name)) {
                    return $instrument;
                }
            }

            if ($class_name) {
                $instruments_request = new InstrumentRequest();
                $instruments_request->setId($ticker);
                $instruments_request->setIdType($instrument_id_type);
                $instruments_request->setClassCode($class_name);

                /** @var BondResponse $response */
                list($response, $status) = $this->_clients_factory_model
                    ->instrumentsServiceClient
                    ->BondBy($instruments_request)
                    ->wait();

                if (!$response || !($instrument = $response->getInstrument())) {
                    throw new InstrumentNotFoundException('Instrument is not found');
                }

                $this->cacheToDictionary([$instrument]);

                return $instrument;
            }

            if (!$this->_is_bonds_loaded || $refresh) {
                $instruments = $this->loadAllBonds();

                foreach ($instruments as $instrument) {
                    if ($instrument->getTicker() === $ticker) {
                        $found_instrument_candidate_1 = $instrument;

                        if ($instrument->getTradingStatus() === SecurityTradingStatus::SECURITY_TRADING_STATUS_NORMAL_TRADING) {
                            $found_instrument_candidate_2 = $instrument;
                        }

                        if ($instrument->getTradingStatus() === SecurityTradingStatus::SECURITY_TRADING_STATUS_NORMAL_TRADING && $instrument->getApiTradeAvailableFlag()) {
                            return $instrument;
                        }
                    }
                }
            }

            if ($found_instrument_candidate_2) {
                return $found_instrument_candidate_2;
            }

            if ($found_instrument_candidate_1) {
                return $found_instrument_candidate_1;
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
            $instrument_type = 'bond';

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByFigi($instrument_type, $figi)) {
                    return $instrument;
                }
            }

            if (!$this->_is_bonds_loaded || $refresh) {
                $instruments = $this->loadAllBonds();

                foreach ($instruments as $instrument) {
                    if ($instrument->getFigi() === $figi) {
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
            $instrument_type = 'bond';

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByUid($instrument_type, $uid)) {
                    return $instrument;
                }
            }

            if (!$this->_is_bonds_loaded || $refresh) {
                $instruments = $this->loadAllBonds();

                foreach ($instruments as $instrument) {
                    if ($instrument->getUid() === $uid) {
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
    public function currencyByTicker(string $ticker, string $class_name = null, bool $refresh = false, bool $raise = true): ?Currency
    {
        try {
            $instrument_type = 'currency';
            $instrument_id_type = InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER;

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByTicker($instrument_type, $ticker, $class_name)) {
                    return $instrument;
                }
            }

            if ($class_name) {
                $instruments_request = new InstrumentRequest();
                $instruments_request->setId($ticker);
                $instruments_request->setIdType($instrument_id_type);
                $instruments_request->setClassCode($class_name);

                /** @var CurrencyResponse $response */
                list($response, $status) = $this->_clients_factory_model
                    ->instrumentsServiceClient
                    ->CurrencyBy($instruments_request)
                    ->wait();

                if (!$response || !($instrument = $response->getInstrument())) {
                    throw new InstrumentNotFoundException('Instrument is not found');
                }

                $this->cacheToDictionary([$instrument]);

                return $instrument;
            }

            if (!$this->_is_currencies_loaded || $refresh) {
                $instruments = $this->loadAllCurrencies();

                foreach ($instruments as $instrument) {
                    if ($instrument->getTicker() === $ticker) {
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
            $instrument_type = 'currency';

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByFigi($instrument_type, $figi)) {
                    return $instrument;
                }
            }

            if (!$this->_is_currencies_loaded || $refresh) {
                $instruments = $this->loadAllCurrencies();

                foreach ($instruments as $instrument) {
                    if ($instrument->getFigi() === $figi) {
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
            $instrument_type = 'currency';

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByUid($instrument_type, $uid)) {
                    return $instrument;
                }
            }

            if (!$this->_is_currencies_loaded || $refresh) {
                $instruments = $this->loadAllCurrencies();

                foreach ($instruments as $instrument) {
                    if ($instrument->getUid() === $uid) {
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
    public function etfByTicker(string $ticker, string $class_name = null, bool $refresh = false, bool $raise = true): ?Etf
    {
        try {
            $found_instrument_candidate_1 = null;
            $found_instrument_candidate_2 = null;

            $instrument_type = 'etf';
            $instrument_id_type = InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER;

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByTicker($instrument_type, $ticker, $class_name)) {
                    return $instrument;
                }
            }

            if ($class_name) {
                $instruments_request = new InstrumentRequest();
                $instruments_request->setId($ticker);
                $instruments_request->setIdType($instrument_id_type);
                $instruments_request->setClassCode($class_name);

                /** @var EtfResponse $response */
                list($response, $status) = $this->_clients_factory_model
                    ->instrumentsServiceClient
                    ->EtfBy($instruments_request)
                    ->wait();

                if (!$response || !($instrument = $response->getInstrument())) {
                    throw new InstrumentNotFoundException('Instrument is not found');
                }

                $this->cacheToDictionary([$instrument]);

                return $instrument;
            }

            if (!$this->_is_etfs_loaded || $refresh) {
                $instruments = $this->loadAllEtfs();

                foreach ($instruments as $instrument) {
                    if ($instrument->getTicker() === $ticker) {
                        $found_instrument_candidate_1 = $instrument;

                        if ($instrument->getTradingStatus() === SecurityTradingStatus::SECURITY_TRADING_STATUS_NORMAL_TRADING) {
                            $found_instrument_candidate_2 = $instrument;
                        }

                        if ($instrument->getTradingStatus() === SecurityTradingStatus::SECURITY_TRADING_STATUS_NORMAL_TRADING && $instrument->getApiTradeAvailableFlag()) {
                            return $instrument;
                        }
                    }
                }
            }

            if ($found_instrument_candidate_2) {
                return $found_instrument_candidate_2;
            }

            if ($found_instrument_candidate_1) {
                return $found_instrument_candidate_1;
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
            $instrument_type = 'etf';

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByFigi($instrument_type, $figi)) {
                    return $instrument;
                }
            }

            if (!$this->_is_etfs_loaded || $refresh) {
                $instruments = $this->loadAllEtfs();

                foreach ($instruments as $instrument) {
                    if ($instrument->getFigi() === $figi) {
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
            $instrument_type = 'etf';

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByUid($instrument_type, $uid)) {
                    return $instrument;
                }
            }

            if (!$this->_is_etfs_loaded || $refresh) {
                $instruments = $this->loadAllEtfs();

                foreach ($instruments as $instrument) {
                    if ($instrument->getUid() === $uid) {
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
    public function futureByTicker(string $ticker, string $class_name = null, bool $refresh = false, bool $raise = true): ?Future
    {
        try {
            $instrument_type = 'future';
            $instrument_id_type = InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER;

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByTicker($instrument_type, $ticker, $class_name)) {
                    return $instrument;
                }
            }

            if ($class_name) {
                $instruments_request = new InstrumentRequest();
                $instruments_request->setId($ticker);
                $instruments_request->setIdType($instrument_id_type);
                $instruments_request->setClassCode($class_name);

                /** @var FutureResponse $response */
                list($response, $status) = $this->_clients_factory_model
                    ->instrumentsServiceClient
                    ->FutureBy($instruments_request)
                    ->wait();

                if (!$response || !($instrument = $response->getInstrument())) {
                    throw new InstrumentNotFoundException('Instrument is not found');
                }

                $this->cacheToDictionary([$instrument]);

                return $instrument;
            }

            if (!$this->_is_futures_loaded || $refresh) {
                $instruments = $this->loadAllFutures();

                foreach ($instruments as $instrument) {
                    if ($instrument->getTicker() === $ticker) {
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
            $instrument_type = 'future';

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByFigi($instrument_type, $figi)) {
                    return $instrument;
                }
            }

            if (!$this->_is_futures_loaded || $refresh) {
                $instruments = $this->loadAllFutures();

                foreach ($instruments as $instrument) {
                    if ($instrument->getFigi() === $figi) {
                        return $instrument;
                    }
                }
            }

            throw new InstrumentNotFoundException('Instrument not found');
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
            $instrument_type = 'future';

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByUid($instrument_type, $uid)) {
                    return $instrument;
                }
            }

            if (!$this->_is_futures_loaded || $refresh) {
                $instruments = $this->loadAllFutures();

                foreach ($instruments as $instrument) {
                    if ($instrument->getUid() === $uid) {
                        return $instrument;
                    }
                }
            }

            throw new InstrumentNotFoundException('Instrument not found');
        } catch (InstrumentNotFoundException $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
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
    public function shareByTicker(string $ticker, string $class_name = null, bool $refresh = false, bool $raise = true): ?Share
    {
        try {
            $found_instrument_candidate_1 = null;
            $found_instrument_candidate_2 = null;

            $instrument_type = 'share';
            $instrument_id_type = InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER;

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByTicker($instrument_type, $ticker, $class_name)) {
                    return $instrument;
                }
            }

            if ($class_name) {
                $instruments_request = new InstrumentRequest();
                $instruments_request->setId($ticker);
                $instruments_request->setIdType($instrument_id_type);
                $instruments_request->setClassCode($class_name);

                /** @var ShareResponse $response */
                list($response, $status) = $this->_clients_factory_model
                    ->instrumentsServiceClient
                    ->ShareBy($instruments_request)
                    ->wait();

                if (!$response || !($instrument = $response->getInstrument())) {
                    throw new InstrumentNotFoundException('Instrument is not found');
                }

                $this->cacheToDictionary([$instrument]);

                return $instrument;
            }

            if (!$this->_is_shares_loaded || $refresh) {
                $instruments = $this->loadAllShares();

                foreach ($instruments as $instrument) {
                    if ($instrument->getTicker() === $ticker) {
                        $found_instrument_candidate_1 = $instrument;

                        if ($instrument->getTradingStatus() === SecurityTradingStatus::SECURITY_TRADING_STATUS_NORMAL_TRADING) {
                            $found_instrument_candidate_2 = $instrument;
                        }

                        if ($instrument->getTradingStatus() === SecurityTradingStatus::SECURITY_TRADING_STATUS_NORMAL_TRADING && $instrument->getApiTradeAvailableFlag()) {
                            return $instrument;
                        }
                    }
                }
            }

            if ($found_instrument_candidate_2) {
                return $found_instrument_candidate_2;
            }

            if ($found_instrument_candidate_1) {
                return $found_instrument_candidate_1;
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
            $instrument_type = 'share';

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByFigi($instrument_type, $figi)) {
                    return $instrument;
                }
            }

            if (!$this->_is_shares_loaded || $refresh) {
                $instruments = $this->loadAllShares();

                foreach ($instruments as $instrument) {
                    if ($instrument->getFigi() === $figi) {
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
            $instrument_type = 'share';

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByUid($instrument_type, $uid)) {
                    return $instrument;
                }
            }

            if (!$this->_is_shares_loaded || $refresh) {
                $instruments = $this->loadAllShares();

                foreach ($instruments as $instrument) {
                    if ($instrument->getUid() === $uid) {
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
        try {
            for ($i = 1; $i <= 3; $i++) {
                if ($i === 1) {
                    /** В первый раунд поиска ищем по доступному кэшу среди типизированных экземпляров инструментов */
                    if ($instrument = $this->getCachedInstrumentByFigi('share', $figi)) {
                        return $instrument;
                    }

                    if ($instrument = $this->getCachedInstrumentByFigi('etf', $figi)) {
                        return $instrument;
                    }

                    if ($instrument = $this->getCachedInstrumentByFigi('currency', $figi)) {
                        return $instrument;
                    }

                    if ($instrument = $this->getCachedInstrumentByFigi('bond', $figi)) {
                        return $instrument;
                    }

                    if ($instrument = $this->getCachedInstrumentByFigi('future', $figi)) {
                        return $instrument;
                    }
                } elseif ($i === 2) {
                    /** Во второй раунд поиска дозагружаем справочники через API и ищем по ним среди типизированных экземпляров инструментов */
                    if (!$this->_is_shares_loaded) {
                        $instruments = $this->loadAllShares();

                        foreach ($instruments as $instrument) {
                            if ($instrument->getFigi() === $figi) {
                                return $instrument;
                            }
                        }
                    }

                    if (!$this->_is_etfs_loaded) {
                        $instruments = $this->loadAllEtfs();

                        foreach ($instruments as $instrument) {
                            if ($instrument->getFigi() === $figi) {
                                return $instrument;
                            }
                        }
                    }

                    if (!$this->_is_currencies_loaded) {
                        $instruments = $this->loadAllCurrencies();

                        foreach ($instruments as $instrument) {
                            if ($instrument->getFigi() === $figi) {
                                return $instrument;
                            }
                        }
                    }

                    if (!$this->_is_bonds_loaded) {
                        $instruments = $this->loadAllBonds();

                        foreach ($instruments as $instrument) {
                            if ($instrument->getFigi() === $figi) {
                                return $instrument;
                            }
                        }
                    }

                    if (!$this->_is_futures_loaded) {
                        $instruments = $this->loadAllFutures();

                        foreach ($instruments as $instrument) {
                            if ($instrument->getFigi() === $figi) {
                                return $instrument;
                            }
                        }
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
        try {
            for ($i = 1; $i <= 3; $i++) {
                if ($i === 1) {
                    /** В первый раунд поиска ищем по доступному кэшу среди типизированных экземпляров инструментов */
                    if ($instrument = $this->getCachedInstrumentByUid('share', $uid)) {
                        return $instrument;
                    }

                    if ($instrument = $this->getCachedInstrumentByUid('etf', $uid)) {
                        return $instrument;
                    }

                    if ($instrument = $this->getCachedInstrumentByUid('currency', $uid)) {
                        return $instrument;
                    }

                    if ($instrument = $this->getCachedInstrumentByUid('bond', $uid)) {
                        return $instrument;
                    }

                    if ($instrument = $this->getCachedInstrumentByUid('future', $uid)) {
                        return $instrument;
                    }
                } elseif ($i === 2) {
                    /** Во второй раунд поиска дозагружаем справочники через API и ищем по ним среди типизированных экземпляров инструментов */
                    if (!$this->_is_shares_loaded) {
                        $instruments = $this->loadAllShares();

                        foreach ($instruments as $instrument) {
                            if ($instrument->getUid() === $uid) {
                                return $instrument;
                            }
                        }
                    }

                    if (!$this->_is_etfs_loaded) {
                        $instruments = $this->loadAllEtfs();

                        foreach ($instruments as $instrument) {
                            if ($instrument->getUid() === $uid) {
                                return $instrument;
                            }
                        }
                    }

                    if (!$this->_is_currencies_loaded) {
                        $instruments = $this->loadAllCurrencies();

                        foreach ($instruments as $instrument) {
                            if ($instrument->getUid() === $uid) {
                                return $instrument;
                            }
                        }
                    }

                    if (!$this->_is_bonds_loaded) {
                        $instruments = $this->loadAllBonds();

                        foreach ($instruments as $instrument) {
                            if ($instrument->getUid() === $uid) {
                                return $instrument;
                            }
                        }
                    }

                    if (!$this->_is_futures_loaded) {
                        $instruments = $this->loadAllFutures();

                        foreach ($instruments as $instrument) {
                            if ($instrument->getUid() === $uid) {
                                return $instrument;
                            }
                        }
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
    public function searchByTicker(string $ticker, string $class_name = null, bool $raise = true)
    {
        try {
            for ($i = 1; $i <= 2; $i++) {
                if ($i === 1) {
                    /** В первый раунд поиска ищем по доступному кэшу среди типизированных экземпляров инструментов */
                    if ($instrument = $this->getCachedInstrumentByTicker('share', $ticker, $class_name)) {
                        return $instrument;
                    }

                    if ($instrument = $this->getCachedInstrumentByTicker('etf', $ticker, $class_name)) {
                        return $instrument;
                    }

                    if ($instrument = $this->getCachedInstrumentByTicker('currency', $ticker, $class_name)) {
                        return $instrument;
                    }

                    if ($instrument = $this->getCachedInstrumentByTicker('bond', $ticker, $class_name)) {
                        return $instrument;
                    }

                    if ($instrument = $this->getCachedInstrumentByTicker('future', $ticker, $class_name)) {
                        return $instrument;
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
    public function instrumentByTicker(string $ticker, string $class_name = null, bool $refresh = false, bool $raise = true): ?Instrument
    {
        try {
            $instrument_type = 'instrument';
            $instrument_id_type = InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER;

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByTicker($instrument_type, $ticker, $class_name)) {
                    return $instrument;
                }
            }

            if ($class_name) {
                $instruments_request = new InstrumentRequest();
                $instruments_request->setId($ticker);
                $instruments_request->setIdType($instrument_id_type);
                $instruments_request->setClassCode($class_name);

                /** @var InstrumentResponse $response */
                list($response, $status) = $this->_clients_factory_model
                    ->instrumentsServiceClient
                    ->GetInstrumentBy($instruments_request)
                    ->wait();

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
            $instrument_type = 'instrument';
            $instrument_id_type = InstrumentIdType::INSTRUMENT_ID_TYPE_FIGI;

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByFigi($instrument_type, $figi)) {
                    return $instrument;
                }
            }

            $instruments_request = new InstrumentRequest();
            $instruments_request->setId($figi);
            $instruments_request->setIdType($instrument_id_type);

            /** @var InstrumentResponse $response */
            list($response, $status) = $this->_clients_factory_model
                ->instrumentsServiceClient
                ->GetInstrumentBy($instruments_request)
                ->wait();

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
            $instrument_type = 'instrument';
            $instrument_id_type = InstrumentIdType::INSTRUMENT_ID_TYPE_UID;

            if (!$refresh) {
                if ($instrument = $this->getCachedInstrumentByUid($instrument_type, $uid)) {
                    return $instrument;
                }
            }

            $instruments_request = new InstrumentRequest();
            $instruments_request->setId($uid);
            $instruments_request->setIdType($instrument_id_type);

            /** @var InstrumentResponse $response */
            list($response, $status) = $this->_clients_factory_model
                ->instrumentsServiceClient
                ->GetInstrumentBy($instruments_request)
                ->wait();

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
     *
     * @see https://tinkoff.github.io/investAPI/instruments/#getfuturesmargin
     */
    public function getFuturesData($instrument): GetFuturesMarginResponse
    {
        if ($instrument instanceof Future || (($instrument instanceof Instrument) && $instrument->getInstrumentType() === 'futures')) {
            $futures_data_request = new GetFuturesMarginRequest();
            $futures_data_request->setFigi($instrument->getFigi());

            /** @var GetFuturesMarginResponse $response */
            list($response, $status) = $this->_clients_factory_model->instrumentsServiceClient
                ->GetFuturesMargin($futures_data_request)
                ->wait()
            ;

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
        $this->_dictionary = [];

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
     * @return Bond[]|RepeatedField Массив загруженных инструментов
     *
     * @throws Exception
     */
    protected function loadAllBonds()
    {
        $instruments_request = new InstrumentsRequest();
        $instruments_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        /** @var BondsResponse $response */
        list($response, $status) = $this->_clients_factory_model
            ->instrumentsServiceClient
            ->Bonds($instruments_request)
            ->wait()
        ;

        /** @var Bond[]|RepeatedField $instruments */
        $instruments = $response->getInstruments();
        $this->cacheToDictionary($instruments);

        $this->_is_bonds_loaded = false;

        return $instruments;
    }

    /**
     * Метод запрашивает через запрос к API справочник всех валют и кеширует загруженный список в текущий экземпляр провайдера
     *
     * @return Currency[]|RepeatedField Массив загруженных инструментов
     *
     * @throws Exception
     */
    protected function loadAllCurrencies()
    {
        $instruments_request = new InstrumentsRequest();
        $instruments_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        /** @var BondsResponse $response */
        list($response, $status) = $this->_clients_factory_model
            ->instrumentsServiceClient
            ->Currencies($instruments_request)
            ->wait()
        ;

        /** @var Currency[]|RepeatedField $instruments */
        $instruments = $response->getInstruments();
        $this->cacheToDictionary($instruments);

        $this->_is_currencies_loaded = true;

        return $instruments;
    }

    /**
     * Метод запрашивает через запрос к API справочник всех фондов и кеширует загруженный список в текущий экземпляр провайдера
     *
     * @return Etf[]|RepeatedField Массив загруженных инструментов
     *
     * @throws Exception
     */
    protected function loadAllEtfs()
    {
        $instruments_request = new InstrumentsRequest();
        $instruments_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        /** @var EtfsResponse $response */
        list($response, $status) = $this->_clients_factory_model
            ->instrumentsServiceClient
            ->Etfs($instruments_request)
            ->wait()
        ;

        /** @var Etf[]|RepeatedField $instruments */
        $instruments = $response->getInstruments();
        $this->cacheToDictionary($instruments);

        $this->_is_etfs_loaded = true;

        return $instruments;
    }

    /**
     * Метод запрашивает через запрос к API справочник всех акций и кеширует загруженный список в текущий экземпляр провайдера
     *
     * @return Share[]|RepeatedField Массив загруженных инструментов
     *
     * @throws Exception
     */
    protected function loadAllShares()
    {
        $instruments_request = new InstrumentsRequest();
        $instruments_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        /** @var SharesResponse $response */
        list($response, $status) = $this->_clients_factory_model
            ->instrumentsServiceClient
            ->Shares($instruments_request)
            ->wait()
        ;

        /** @var Share[]|RepeatedField $instruments */
        $instruments = $response->getInstruments();
        $this->cacheToDictionary($instruments);

        $this->_is_shares_loaded = true;

        return $instruments;
    }

    /**
     * Метод запрашивает через запрос к API справочник всех фьючерсов и кеширует загруженный список в текущий экземпляр провайдера
     *
     * @return Future[]|RepeatedField Массив загруженных инструментов
     *
     * @throws Exception
     */
    protected function loadAllFutures()
    {
        $instruments_request = new InstrumentsRequest();
        $instruments_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        /** @var FuturesResponse $response */
        list($response, $status) = $this->_clients_factory_model
            ->instrumentsServiceClient
            ->Futures($instruments_request)
            ->wait()
        ;

        /** @var Future[]|RepeatedField $instruments */
        $instruments = $response->getInstruments();
        $this->cacheToDictionary($instruments);

        $this->_is_futures_loaded = true;

        return $instruments;
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
            $class_code = $instrument->getClassCode();
            $ticker = $instrument->getTicker();
            $figi = $instrument->getFigi();

            switch(true) {
                case ($instrument instanceof Bond):
                    $type = 'bond';

                    break;
                case ($instrument instanceof Currency):
                    $type = 'currency';

                    break;
                case ($instrument instanceof Etf):
                    $type = 'etf';

                    break;
                case ($instrument instanceof Future):
                    $type = 'future';

                    break;
                case ($instrument instanceof Share):
                    $type = 'share';

                    break;
                case ($instrument instanceof Instrument):
                    $type = 'instrument';

                    break;
                default:
                    throw new Exception('Unsupported instrument type');
            }

            $this->_dictionary[$type][InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER][$ticker][$class_code] = $instrument;
            $this->_dictionary[$type][InstrumentIdType::INSTRUMENT_ID_TYPE_FIGI][$figi] = $instrument;
        }
    }

    /**
     * Метод поиска инструмента по закешированному справочнику по тикеру
     *
     * @param string $instrument_type Тип инструмента
     * @param string $ticker Тикер инструмента
     * @param string|null $class_name Режим торгов или <code>null</code>
     *
     * @return Bond|Currency|Etf|Future|Share|Instrument|null
     *
     * @see https://tinkoff.github.io/investAPI/faq_identification/
     */
    protected function getCachedInstrumentByTicker(string $instrument_type, string $ticker, string $class_name = null)
    {
        $instrument_id_type = InstrumentIdType::INSTRUMENT_ID_TYPE_TICKER;

        if ($class_name) {
            if (!empty($this->_dictionary[$instrument_type][$instrument_id_type][$ticker][$class_name])) {
                return $this->_dictionary[$instrument_type][$instrument_id_type][$ticker][$class_name];
            }
        } else {
            if (!empty($this->_dictionary[$instrument_type][$instrument_id_type][$ticker])) {
                return reset($this->_dictionary[$instrument_type][$instrument_id_type][$ticker]);
            }
        }

        return null;
    }

    /**
     * Метод поиска инструмента по закешированному справочнику по FIGI
     *
     * @param string $instrument_type Тип инструмента
     * @param string $figi FIGI инструмента
     *
     * @return Bond|Currency|Etf|Future|Share|Instrument|null
     */
    protected function getCachedInstrumentByFigi(string $instrument_type, string $figi)
    {
        $instrument_id_type = InstrumentIdType::INSTRUMENT_ID_TYPE_FIGI;

        return $this->_dictionary[$instrument_type][$instrument_id_type][$figi] ?? null;
    }

    /**
     * Метод поиска инструмента по закешированному справочнику по UID
     *
     * @param string $instrument_type Тип инструмента
     * @param string $uid UID инструмента
     *
     * @return Bond|Currency|Etf|Future|Share|Instrument|null
     */
    protected function getCachedInstrumentByUid(string $instrument_type, string $uid)
    {
        $instrument_id_type = InstrumentIdType::INSTRUMENT_ID_TYPE_UID;

        return $this->_dictionary[$instrument_type][$instrument_id_type][$uid] ?? null;
    }
}
