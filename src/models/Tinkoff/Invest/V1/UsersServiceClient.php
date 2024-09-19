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
     * Получить счета пользователя.
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
     * Рассчитать маржинальные показатели по счёту.
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
     * Запросить тариф пользователя.
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
     * Получить информацию о пользователе.
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
