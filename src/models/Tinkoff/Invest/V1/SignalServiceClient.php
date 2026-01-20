<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Tinkoff\Invest\V1;

/**
 */
class SignalServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * GetStrategies — стратегии
     * @param \Tinkoff\Invest\V1\GetStrategiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\GetStrategiesResponse>
     */
    public function GetStrategies(\Tinkoff\Invest\V1\GetStrategiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SignalService/GetStrategies',
        $argument,
        ['\Tinkoff\Invest\V1\GetStrategiesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetSignals — сигналы
     * @param \Tinkoff\Invest\V1\GetSignalsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\GetSignalsResponse>
     */
    public function GetSignals(\Tinkoff\Invest\V1\GetSignalsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SignalService/GetSignals',
        $argument,
        ['\Tinkoff\Invest\V1\GetSignalsResponse', 'decode'],
        $metadata, $options);
    }

}
