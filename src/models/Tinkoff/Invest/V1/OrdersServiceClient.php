<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Tinkoff\Invest\V1;

/**
 */
class OrdersServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Метод выставления заявки.
     * @param \Tinkoff\Invest\V1\PostOrderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PostOrder(\Tinkoff\Invest\V1\PostOrderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OrdersService/PostOrder',
        $argument,
        ['\Tinkoff\Invest\V1\PostOrderResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод отмены биржевой заявки.
     * @param \Tinkoff\Invest\V1\CancelOrderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelOrder(\Tinkoff\Invest\V1\CancelOrderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OrdersService/CancelOrder',
        $argument,
        ['\Tinkoff\Invest\V1\CancelOrderResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения статуса торгового поручения.
     * @param \Tinkoff\Invest\V1\GetOrderStateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetOrderState(\Tinkoff\Invest\V1\GetOrderStateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OrdersService/GetOrderState',
        $argument,
        ['\Tinkoff\Invest\V1\OrderState', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения списка активных заявок по счёту.
     * @param \Tinkoff\Invest\V1\GetOrdersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetOrders(\Tinkoff\Invest\V1\GetOrdersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OrdersService/GetOrders',
        $argument,
        ['\Tinkoff\Invest\V1\GetOrdersResponse', 'decode'],
        $metadata, $options);
    }

}
