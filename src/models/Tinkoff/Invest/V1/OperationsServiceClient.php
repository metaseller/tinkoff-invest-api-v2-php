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
     * Метод получения списка операций по счёту.При работе с данным методом необходимо учитывать
     * [особенности взаимодействия](/investAPI/operations_problems) с данным методом.
     * @param \Tinkoff\Invest\V1\OperationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetOperations(\Tinkoff\Invest\V1\OperationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OperationsService/GetOperations',
        $argument,
        ['\Tinkoff\Invest\V1\OperationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения портфеля по счёту.
     * @param \Tinkoff\Invest\V1\PortfolioRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPortfolio(\Tinkoff\Invest\V1\PortfolioRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OperationsService/GetPortfolio',
        $argument,
        ['\Tinkoff\Invest\V1\PortfolioResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения списка позиций по счёту.
     * @param \Tinkoff\Invest\V1\PositionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPositions(\Tinkoff\Invest\V1\PositionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OperationsService/GetPositions',
        $argument,
        ['\Tinkoff\Invest\V1\PositionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения доступного остатка для вывода средств.
     * @param \Tinkoff\Invest\V1\WithdrawLimitsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetWithdrawLimits(\Tinkoff\Invest\V1\WithdrawLimitsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OperationsService/GetWithdrawLimits',
        $argument,
        ['\Tinkoff\Invest\V1\WithdrawLimitsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения брокерского отчёта.
     * @param \Tinkoff\Invest\V1\BrokerReportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBrokerReport(\Tinkoff\Invest\V1\BrokerReportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OperationsService/GetBrokerReport',
        $argument,
        ['\Tinkoff\Invest\V1\BrokerReportResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения отчёта "Справка о доходах за пределами РФ".
     * @param \Tinkoff\Invest\V1\GetDividendsForeignIssuerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDividendsForeignIssuer(\Tinkoff\Invest\V1\GetDividendsForeignIssuerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OperationsService/GetDividendsForeignIssuer',
        $argument,
        ['\Tinkoff\Invest\V1\GetDividendsForeignIssuerResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения списка операций по счёту с пагинацией. При работе с данным методом необходимо учитывать
     * [особенности взаимодействия](/investAPI/operations_problems) с данным методом.
     * @param \Tinkoff\Invest\V1\GetOperationsByCursorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetOperationsByCursor(\Tinkoff\Invest\V1\GetOperationsByCursorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.OperationsService/GetOperationsByCursor',
        $argument,
        ['\Tinkoff\Invest\V1\GetOperationsByCursorResponse', 'decode'],
        $metadata, $options);
    }

}
