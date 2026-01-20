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
     * PostOrder — выставить заявку
     * @param \Tinkoff\Invest\V1\PostOrderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\PostOrderResponse>
     */
    public function PostOrder(\Tinkoff\Invest\V1\PostOrderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OrdersService/PostOrder',
        $argument,
        ['\Tinkoff\Invest\V1\PostOrderResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * PostOrderAsync — выставить заявку асинхронным методом
     * Особенности работы приведены в [статье](/invest/services/orders/async).
     * @param \Tinkoff\Invest\V1\PostOrderAsyncRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\PostOrderAsyncResponse>
     */
    public function PostOrderAsync(\Tinkoff\Invest\V1\PostOrderAsyncRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OrdersService/PostOrderAsync',
        $argument,
        ['\Tinkoff\Invest\V1\PostOrderAsyncResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * CancelOrder — отменить заявку
     * @param \Tinkoff\Invest\V1\CancelOrderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\CancelOrderResponse>
     */
    public function CancelOrder(\Tinkoff\Invest\V1\CancelOrderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OrdersService/CancelOrder',
        $argument,
        ['\Tinkoff\Invest\V1\CancelOrderResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetOrderState — получить статус торгового поручения
     * @param \Tinkoff\Invest\V1\GetOrderStateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\OrderState>
     */
    public function GetOrderState(\Tinkoff\Invest\V1\GetOrderStateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OrdersService/GetOrderState',
        $argument,
        ['\Tinkoff\Invest\V1\OrderState', 'decode'],
        $metadata, $options);
    }

    /**
     * GetOrders — получить список активных заявок по счету
     * @param \Tinkoff\Invest\V1\GetOrdersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\GetOrdersResponse>
     */
    public function GetOrders(\Tinkoff\Invest\V1\GetOrdersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OrdersService/GetOrders',
        $argument,
        ['\Tinkoff\Invest\V1\GetOrdersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * ReplaceOrder — изменить выставленную заявку
     * @param \Tinkoff\Invest\V1\ReplaceOrderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\PostOrderResponse>
     */
    public function ReplaceOrder(\Tinkoff\Invest\V1\ReplaceOrderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OrdersService/ReplaceOrder',
        $argument,
        ['\Tinkoff\Invest\V1\PostOrderResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetMaxLots — расчет количества доступных для покупки/продажи лотов
     * @param \Tinkoff\Invest\V1\GetMaxLotsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\GetMaxLotsResponse>
     */
    public function GetMaxLots(\Tinkoff\Invest\V1\GetMaxLotsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OrdersService/GetMaxLots',
        $argument,
        ['\Tinkoff\Invest\V1\GetMaxLotsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetOrderPrice — получить предварительную стоимость для лимитной заявки
     * @param \Tinkoff\Invest\V1\GetOrderPriceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\GetOrderPriceResponse>
     */
    public function GetOrderPrice(\Tinkoff\Invest\V1\GetOrderPriceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OrdersService/GetOrderPrice',
        $argument,
        ['\Tinkoff\Invest\V1\GetOrderPriceResponse', 'decode'],
        $metadata, $options);
    }

}
