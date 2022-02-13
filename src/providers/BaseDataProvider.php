<?php

namespace Metaseller\TinkoffInvestApi2\providers;

use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;

/**
 * Базовая модель провайдера данных сервиса Tinkoff Invest API 2
 *
 * @package Metaseller\TinkoffInvestApi2
 */
abstract class BaseDataProvider
{
    /**
     * @var TinkoffClientsFactory Экземпляр фабрики клиентов доступа к сервису Tinkoff Invest API 2
     */
    protected $_clients_factory_model;

    /**
     * Конструктор класса
     *
     * @param TinkoffClientsFactory|null $model Экземпляр фабрики клиентов доступа к сервису Tinkoff Invest API 2 или <code>null</code>,
     * если инициализация планируется позднее
     */
    public function __construct(TinkoffClientsFactory $model = null)
    {
        if ($model) {
            $this->setClientsFactory($model);
        }
    }

    /**
     * @param TinkoffClientsFactory $model Экземпляр фабрики клиентов доступа к сервису Tinkoff Invest API 2
     *
     * @return $this Текущий экземпляр провайдера
     */
    public function setClientsFactory(TinkoffClientsFactory $model): self
    {
        $this->_clients_factory_model = $model;

        return $this->resetCachedProviderData();
    }

    /**
     * Метод сброса закешированных в провайдере данных
     *
     * @return $this Текущий экземпляр провайдера
     */
    public function resetCachedProviderData(): self
    {
        return $this;
    }
}
