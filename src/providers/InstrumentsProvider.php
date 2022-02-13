<?php

namespace Metaseller\TinkoffInvestApi2\providers;

use Exception;
use Google\Protobuf\Internal\RepeatedField;
use Tinkoff\Invest\V1\Bond;
use Tinkoff\Invest\V1\BondResponse;
use Tinkoff\Invest\V1\BondsResponse;
use Tinkoff\Invest\V1\CurrenciesResponse;
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
                throw new Exception('Instrument not found');
            }

            $this->cacheToDictionary([$instrument]);

            return $instrument;
        }

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

        foreach ($instruments as $instrument) {
            if ($instrument->getTicker() === $ticker) {
                return $instrument;
            }
        }

        throw new Exception('Instrument not found');
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

        foreach ($instruments as $instrument) {
            if ($instrument->getFigi() === $figi) {
                return $instrument;
            }
        }

        throw new Exception('Instrument not found');
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
                throw new Exception('Instrument not found');
            }

            $this->cacheToDictionary([$instrument]);

            return $instrument;
        }

        $instruments_request = new InstrumentsRequest();
        $instruments_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        /** @var CurrenciesResponse $response */
        list($response, $status) = $this->_clients_factory_model
            ->instrumentsServiceClient
            ->Currencies($instruments_request)
            ->wait()
        ;

        /** @var Currency[] $instruments */
        $instruments = $response->getInstruments();
        $this->cacheToDictionary($instruments);

        foreach ($instruments as $instrument) {
            if ($instrument->getTicker() === $ticker) {
                return $instrument;
            }
        }

        throw new Exception('Instrument not found');
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

        foreach ($instruments as $instrument) {
            if ($instrument->getFigi() === $figi) {
                return $instrument;
            }
        }

        throw new Exception('Instrument not found');
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
                throw new Exception('Instrument not found');
            }

            $this->cacheToDictionary([$instrument]);

            return $instrument;
        }

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

        foreach ($instruments as $instrument) {
            if ($instrument->getTicker() === $ticker) {
                return $instrument;
            }
        }

        throw new Exception('Instrument not found');
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

        foreach ($instruments as $instrument) {
            if ($instrument->getFigi() === $figi) {
                return $instrument;
            }
        }

        throw new Exception('Instrument not found');
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
                throw new Exception('Instrument not found');
            }

            $this->cacheToDictionary([$instrument]);

            return $instrument;
        }

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

        foreach ($instruments as $instrument) {
            if ($instrument->getTicker() === $ticker) {
                return $instrument;
            }
        }

        throw new Exception('Instrument not found');
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

        foreach ($instruments as $instrument) {
            if ($instrument->getFigi() === $figi) {
                return $instrument;
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
                throw new Exception('Instrument not found');
            }

            $this->cacheToDictionary([$instrument]);

            return $instrument;
        }

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

        foreach ($instruments as $instrument) {
            if ($instrument->getTicker() === $ticker) {
                return $instrument;
            }
        }

        throw new Exception('Instrument not found');
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

        foreach ($instruments as $instrument) {
            if ($instrument->getFigi() === $figi) {
                return $instrument;
            }
        }

        throw new Exception('Instrument not found');
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
                throw new Exception('Instrument not found');
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
            throw new Exception('Instrument not found');
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

        return $this;
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
