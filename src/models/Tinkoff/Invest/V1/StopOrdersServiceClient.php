<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Tinkoff\Invest\V1;

/**
 */
class StopOrdersServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Выставить стоп-заявку.
     * @param \Tinkoff\Invest\V1\PostStopOrderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PostStopOrder(\Tinkoff\Invest\V1\PostStopOrderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.StopOrdersService/PostStopOrder',
        $argument,
        ['\Tinkoff\Invest\V1\PostStopOrderResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Получить список активных стоп-заявок по счёту.
     * @param \Tinkoff\Invest\V1\GetStopOrdersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetStopOrders(\Tinkoff\Invest\V1\GetStopOrdersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.StopOrdersService/GetStopOrders',
        $argument,
        ['\Tinkoff\Invest\V1\GetStopOrdersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Отменить стоп-заявку.
     * @param \Tinkoff\Invest\V1\CancelStopOrderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelStopOrder(\Tinkoff\Invest\V1\CancelStopOrderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.StopOrdersService/CancelStopOrder',
        $argument,
        ['\Tinkoff\Invest\V1\CancelStopOrderResponse', 'decode'],
        $metadata, $options);
    }

}
