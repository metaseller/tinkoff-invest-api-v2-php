<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Tinkoff\Invest\V1;

/**
 */
class MarketDataStreamServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Bi-directional стрим предоставления биржевой информации.
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\BidiStreamingCall
     */
    public function MarketDataStream($metadata = [], $options = []) {
        return $this->_bidiRequest('/tinkoff.public.invest.api.contract.v1.MarketDataStreamService/MarketDataStream',
        ['\Tinkoff\Invest\V1\MarketDataResponse','decode'],
        $metadata, $options);
    }

    /**
     * Server-side стрим предоставления биржевой информации.
     * @param \Tinkoff\Invest\V1\MarketDataServerSideStreamRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function MarketDataServerSideStream(\Tinkoff\Invest\V1\MarketDataServerSideStreamRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/tinkoff.public.invest.api.contract.v1.MarketDataStreamService/MarketDataServerSideStream',
        $argument,
        ['\Tinkoff\Invest\V1\MarketDataResponse', 'decode'],
        $metadata, $options);
    }

}
