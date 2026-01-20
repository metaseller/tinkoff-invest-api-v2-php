<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Tinkoff\Invest\V1;

/**
 */
class OperationsServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * GetOperations — список операций по счету
     * При работе с методом учитывайте [особенности взаимодействия](/invest/services/operations/operations_problems).
     * @param \Tinkoff\Invest\V1\OperationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\OperationsResponse>
     */
    public function GetOperations(\Tinkoff\Invest\V1\OperationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OperationsService/GetOperations',
        $argument,
        ['\Tinkoff\Invest\V1\OperationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetPortfolio — портфель по счету
     * @param \Tinkoff\Invest\V1\PortfolioRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\PortfolioResponse>
     */
    public function GetPortfolio(\Tinkoff\Invest\V1\PortfolioRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OperationsService/GetPortfolio',
        $argument,
        ['\Tinkoff\Invest\V1\PortfolioResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetPositions — список позиций по счету
     * @param \Tinkoff\Invest\V1\PositionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\PositionsResponse>
     */
    public function GetPositions(\Tinkoff\Invest\V1\PositionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OperationsService/GetPositions',
        $argument,
        ['\Tinkoff\Invest\V1\PositionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetWithdrawLimits — доступный остаток для вывода средств
     * @param \Tinkoff\Invest\V1\WithdrawLimitsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\WithdrawLimitsResponse>
     */
    public function GetWithdrawLimits(\Tinkoff\Invest\V1\WithdrawLimitsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OperationsService/GetWithdrawLimits',
        $argument,
        ['\Tinkoff\Invest\V1\WithdrawLimitsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetBrokerReport — брокерский отчет.
     * @param \Tinkoff\Invest\V1\BrokerReportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\BrokerReportResponse>
     */
    public function GetBrokerReport(\Tinkoff\Invest\V1\BrokerReportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OperationsService/GetBrokerReport',
        $argument,
        ['\Tinkoff\Invest\V1\BrokerReportResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetDividendsForeignIssuer — отчет «Справка о доходах за пределами РФ»
     * @param \Tinkoff\Invest\V1\GetDividendsForeignIssuerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\GetDividendsForeignIssuerResponse>
     */
    public function GetDividendsForeignIssuer(\Tinkoff\Invest\V1\GetDividendsForeignIssuerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OperationsService/GetDividendsForeignIssuer',
        $argument,
        ['\Tinkoff\Invest\V1\GetDividendsForeignIssuerResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GetOperationsByCursor — список операций по счету с пагинацией
     * При работе с методом учитывайте [особенности взаимодействия](/invest/services/operations/operations_problems).
     * @param \Tinkoff\Invest\V1\GetOperationsByCursorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Tinkoff\Invest\V1\GetOperationsByCursorResponse>
     */
    public function GetOperationsByCursor(\Tinkoff\Invest\V1\GetOperationsByCursorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OperationsService/GetOperationsByCursor',
        $argument,
        ['\Tinkoff\Invest\V1\GetOperationsByCursorResponse', 'decode'],
        $metadata, $options);
    }

}
