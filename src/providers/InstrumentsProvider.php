<?php

namespace Metaseller\TinkoffInvestApi2\providers;

use Exception;
use Google\Protobuf\Internal\RepeatedField;
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
use Tinkoff\Invest\V1\Instrument;
use Tinkoff\Invest\V1\InstrumentIdType;
use Tinkoff\Invest\V1\InstrumentRequest;
use Tinkoff\Invest\V1\InstrumentResponse;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;
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
     *
     * @throws Exception
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
     *
     * @throws Exception
     */
    public static function create(
        TinkoffClientsFactory $model = null,
        bool $preload_shares = true,
        bool $preload_etfs = true,
        bool $preload_currencies = true,
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
     * @param string $ticker Тикер инструмента
     * @param string|null $class_name Режим торгов или <code>null</code>, тогда будет возвращен первый найденный
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     *
     * @return Bond Экземпляр инструмента типа 'Облигация'
     *
     * @throws Exception
     */
    public function bondByTicker(string $ticker, string $class_name = null, bool $refresh = false): Bond
    {
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
                ->wait()
            ;

            if (!$response || !($instrument = $response->getInstrument())) {
                throw new Exception('Instrument is not found');
            }

            $this->cacheToDictionary([$instrument]);

            return $instrument;
        }

        if (!$this->_is_bonds_loaded || $refresh) {
            $instruments = $this->loadAllBonds();

            foreach ($instruments as $instrument) {
                if ($instrument->getTicker() === $ticker) {
                    return $instrument;
                }
            }
        }

        throw new Exception('Instrument is not found');
    }

    /**
     * Метод получения инструмента типа {@link Bond} по FIGI
     *
     * @param string $figi FIGI инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     *
     * @return Bond Экземпляр инструмента типа 'Облигация'
     *
     * @throws Exception
     */
    public function bondByFigi(string $figi, bool $refresh = false): Bond
    {
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

        throw new Exception('Instrument is not found');
    }

    /**
     * Метод получения инструмента типа {@link Currency} по тикеру
     *
     * @param string $ticker Тикер инструмента
     * @param string|null $class_name Режим торгов или <code>null</code>, тогда будет возвращен первый найденный
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     *
     * @return Currency Экземпляр инструмента типа 'Валюта'
     *
     * @throws Exception
     */
    public function currencyByTicker(string $ticker, string $class_name = null, bool $refresh = false): Currency
    {
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
                ->wait()
            ;

            if (!$response || !($instrument = $response->getInstrument())) {
                throw new Exception('Instrument is not found');
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

        throw new Exception('Instrument is not found');
    }

    /**
     * Метод получения инструмента типа {@link Currency} по FIGI
     *
     * @param string $figi FIGI инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     *
     * @return Currency Экземпляр инструмента типа 'Валюта'
     *
     * @throws Exception
     */
    public function currencyByFigi(string $figi, bool $refresh = false): Currency
    {
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

        throw new Exception('Instrument is not found');
    }

    /**
     * Метод получения инструмента типа {@link Etf} по тикеру
     *
     * @param string $ticker Тикер инструмента
     * @param string|null $class_name Режим торгов или <code>null</code>, тогда будет возвращен первый найденный
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     *
     * @return Etf Экземпляр инструмента типа 'Фонд'
     *
     * @throws Exception
     */
    public function etfByTicker(string $ticker, string $class_name = null, bool $refresh = false): Etf
    {
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
                ->wait()
            ;

            if (!$response || !($instrument = $response->getInstrument())) {
                throw new Exception('Instrument is not found');
            }

            $this->cacheToDictionary([$instrument]);

            return $instrument;
        }

        if (!$this->_is_etfs_loaded || $refresh) {
            $instruments = $this->loadAllEtfs();

            foreach ($instruments as $instrument) {
                if ($instrument->getTicker() === $ticker) {
                    return $instrument;
                }
            }
        }

        throw new Exception('Instrument is not found');
    }

    /**
     * Метод получения инструмента типа {@link Etf} по FIGI
     *
     * @param string $figi FIGI инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     *
     * @return Etf Экземпляр инструмента типа 'Фонд'
     *
     * @throws Exception
     */
    public function etfByFigi(string $figi, bool $refresh = false): Etf
    {
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

        throw new Exception('Instrument is not found');
    }

    /**
     * Метод получения инструмента типа {@link Future} по тикеру
     *
     * @param string $ticker Тикер инструмента
     * @param string|null $class_name Режим торгов или <code>null</code>, тогда будет возвращен первый найденный
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     *
     * @return Future Экземпляр инструмента типа 'Фьючерс'
     *
     * @throws Exception
     */
    public function futureByTicker(string $ticker, string $class_name = null, bool $refresh = false): Future
    {
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
                ->wait()
            ;

            if (!$response || !($instrument = $response->getInstrument())) {
                throw new Exception('Instrument is not found');
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

        throw new Exception('Instrument is not found');
    }

    /**
     * Метод получения инструмента типа {@link Future} по FIGI
     *
     * @param string $figi FIGI инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     *
     * @return Future Экземпляр инструмента типа 'Фьючерс'
     *
     * @throws Exception
     */
    public function futureByFigi(string $figi, bool $refresh = false): Future
    {
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

        throw new Exception('Instrument not found');
    }

    /**
     * Метод получения инструмента типа {@link Share} по тикеру
     *
     * @param string $ticker Тикер инструмента
     * @param string|null $class_name Режим торгов или <code>null</code>, тогда будет возвращен первый найденный
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     *
     * @return Share Экземпляр инструмента типа 'Акция'
     *
     * @throws Exception
     */
    public function shareByTicker(string $ticker, string $class_name = null, bool $refresh = false): Share
    {
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
                ->wait()
            ;

            if (!$response || !($instrument = $response->getInstrument())) {
                throw new Exception('Instrument is not found');
            }

            $this->cacheToDictionary([$instrument]);

            return $instrument;
        }

        if (!$this->_is_shares_loaded || $refresh) {
            $instruments = $this->loadAllShares();

            foreach ($instruments as $instrument) {
                if ($instrument->getTicker() === $ticker) {
                    return $instrument;
                }
            }
        }

        throw new Exception('Instrument is not found');
    }

    /**
     * Метод получения инструмента типа {@link Share} по FIGI
     *
     * @param string $figi FIGI инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     *
     * @return Share Экземпляр инструмента типа 'Акция'
     *
     * @throws Exception
     */
    public function shareByFigi(string $figi, bool $refresh = false): Share
    {
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

        throw new Exception('Instrument is not found');
    }

    /**
     * Метод получения инструмента типа {@link Instrument} по тикеру
     *
     * Модель, содержащая основную информацию об инструменте
     *
     * @param string $ticker Тикер инструмента
     * @param string|null $class_name Режим торгов или <code>null</code>, тогда будет возвращен первый найденный
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     *
     * @return Instrument Экземпляр инструмента
     *
     * @throws Exception
     */
    public function instrumentByTicker(string $ticker, string $class_name = null, bool $refresh = false): Instrument
    {
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
                ->wait()
            ;

            if (!$response || !($instrument = $response->getInstrument())) {
                throw new Exception('Instrument is not found');
            }

            $this->cacheToDictionary([$instrument]);

            return $instrument;
        }

        throw new Exception('Instrument not found');
    }

    /**
     * Метод получения инструмента типа {@link Instrument} по тикеру
     *
     * Модель, содержащая основную информацию об инструменте
     *
     * @param string $figi FIGI инструмента
     * @param bool $refresh Признак необходимости получить новые данные из API Tinkoff Invest и обновить кэш. По умолчанию равно <code>false</code>
     *
     * @return Instrument Экземпляр инструмента
     *
     * @throws Exception
     */
    public function instrumentByFigi(string $figi, bool $refresh = false): Instrument
    {
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
            throw new Exception('Instrument is not found');
        }

        $this->cacheToDictionary([$instrument]);

        return $instrument;
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
     * @return Bond[] Массив загруженных инструментов
     *
     * @throws Exception
     */
    protected function loadAllBonds(): array
    {
        $instruments_request = new InstrumentsRequest();
        $instruments_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        /** @var BondsResponse $response */
        list($response, $status) = $this->_clients_factory_model
            ->instrumentsServiceClient
            ->Bonds($instruments_request)
            ->wait()
        ;

        /** @var Bond[] $instruments */
        $instruments = $response->getInstruments();
        $this->cacheToDictionary($instruments);

        $this->_is_bonds_loaded = false;

        return $instruments;
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

        /** @var BondsResponse $response */
        list($response, $status) = $this->_clients_factory_model
            ->instrumentsServiceClient
            ->Currencies($instruments_request)
            ->wait()
        ;

        /** @var Currency[] $instruments */
        $instruments = $response->getInstruments();
        $this->cacheToDictionary($instruments);

        $this->_is_currencies_loaded = true;

        return $instruments;
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

        /** @var EtfsResponse $response */
        list($response, $status) = $this->_clients_factory_model
            ->instrumentsServiceClient
            ->Etfs($instruments_request)
            ->wait()
        ;

        /** @var Etf[] $instruments */
        $instruments = $response->getInstruments();
        $this->cacheToDictionary($instruments);

        $this->_is_etfs_loaded = true;

        return $instruments;
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

        /** @var SharesResponse $response */
        list($response, $status) = $this->_clients_factory_model
            ->instrumentsServiceClient
            ->Shares($instruments_request)
            ->wait()
        ;

        /** @var Share[] $instruments */
        $instruments = $response->getInstruments();
        $this->cacheToDictionary($instruments);

        $this->_is_shares_loaded = true;

        return $instruments;
    }

    /**
     * Метод запрашивает через запрос к API справочник всех фьючерсов и кеширует загруженный список в текущий экземпляр провайдера
     *
     * @return Etf[] Массив загруженных инструментов
     *
     * @throws Exception
     */
    protected function loadAllFutures(): array
    {
        $instruments_request = new InstrumentsRequest();
        $instruments_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        /** @var FuturesResponse $response */
        list($response, $status) = $this->_clients_factory_model
            ->instrumentsServiceClient
            ->Futures($instruments_request)
            ->wait()
        ;

        /** @var Future[] $instruments */
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
}
