<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Tinkoff\Invest\V1;

/**
 */
class OrdersStreamServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Stream сделок пользователя
     * @param \Tinkoff\Invest\V1\TradesStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function TradesStream(\Tinkoff\Invest\V1\TradesStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/tinkoff.public.invest.api.contract.v1.OrdersStreamService/TradesStream',
        $argument,
        ['\Tinkoff\Invest\V1\TradesStreamResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Stream поручений пользователя
     * @param \Tinkoff\Invest\V1\OrderStateStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function OrderStateStream(\Tinkoff\Invest\V1\OrderStateStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/tinkoff.public.invest.api.contract.v1.OrdersStreamService/OrderStateStream',
        $argument,
        ['\Tinkoff\Invest\V1\OrderStateStreamResponse', 'decode'],
        $metadata, $options);
    }

}
