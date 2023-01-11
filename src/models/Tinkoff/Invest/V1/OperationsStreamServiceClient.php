<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Tinkoff\Invest\V1;

/**
 */
class OperationsStreamServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Server-side stream обновлений портфеля
     * @param \Tinkoff\Invest\V1\PortfolioStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function PortfolioStream(\Tinkoff\Invest\V1\PortfolioStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/tinkoff.public.invest.api.contract.v1.OperationsStreamService/PortfolioStream',
        $argument,
        ['\Tinkoff\Invest\V1\PortfolioStreamResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Server-side stream обновлений информации по изменению позиций портфеля
     * @param \Tinkoff\Invest\V1\PositionsStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function PositionsStream(\Tinkoff\Invest\V1\PositionsStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/tinkoff.public.invest.api.contract.v1.OperationsStreamService/PositionsStream',
        $argument,
        ['\Tinkoff\Invest\V1\PositionsStreamResponse', 'decode'],
        $metadata, $options);
    }

}
