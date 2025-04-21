<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Tinkoff\Invest\V1;

/**
 */
class UsersServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * GetAccounts — счета пользователя
     * Получить список счетов.
     * @param \Tinkoff\Invest\V1\GetAccountsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAccounts(\Tinkoff\Invest\V1\GetAccountsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.UsersService/GetAccounts',
        $argument,
        ['\Tinkoff\Invest\V1\GetAccountsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetMarginAttributes — маржинальные показатели по счeту
     * Метод позволяет получить маржинальные показатели и ликвидность по заданному счeту.
     * @param \Tinkoff\Invest\V1\GetMarginAttributesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMarginAttributes(\Tinkoff\Invest\V1\GetMarginAttributesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.UsersService/GetMarginAttributes',
        $argument,
        ['\Tinkoff\Invest\V1\GetMarginAttributesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetUserTariff — тариф пользователя
     * Получить информацию о текущих лимитах на подклчение, согласно текущему тарифу пользователя.
     * @param \Tinkoff\Invest\V1\GetUserTariffRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetUserTariff(\Tinkoff\Invest\V1\GetUserTariffRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.UsersService/GetUserTariff',
        $argument,
        ['\Tinkoff\Invest\V1\GetUserTariffResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetInfo — информация о пользователе
     * Получить информацию о пользователе: тариф, признак квалификации, пройденные тесты и др.
     * @param \Tinkoff\Invest\V1\GetInfoRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInfo(\Tinkoff\Invest\V1\GetInfoRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.UsersService/GetInfo',
        $argument,
        ['\Tinkoff\Invest\V1\GetInfoResponse', 'decode'],
        $metadata, $options);
    }

}
