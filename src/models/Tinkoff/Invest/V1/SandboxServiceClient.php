<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Tinkoff\Invest\V1;

/**
 */
class SandboxServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Метод регистрации счёта в песочнице.
     * @param \Tinkoff\Invest\V1\OpenSandboxAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function OpenSandboxAccount(\Tinkoff\Invest\V1\OpenSandboxAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SandboxService/OpenSandboxAccount',
        $argument,
        ['\Tinkoff\Invest\V1\OpenSandboxAccountResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения счетов в песочнице.
     * @param \Tinkoff\Invest\V1\GetAccountsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSandboxAccounts(\Tinkoff\Invest\V1\GetAccountsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SandboxService/GetSandboxAccounts',
        $argument,
        ['\Tinkoff\Invest\V1\GetAccountsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод закрытия счёта в песочнице.
     * @param \Tinkoff\Invest\V1\CloseSandboxAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CloseSandboxAccount(\Tinkoff\Invest\V1\CloseSandboxAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SandboxService/CloseSandboxAccount',
        $argument,
        ['\Tinkoff\Invest\V1\CloseSandboxAccountResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод выставления торгового поручения в песочнице.
     * @param \Tinkoff\Invest\V1\PostOrderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PostSandboxOrder(\Tinkoff\Invest\V1\PostOrderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SandboxService/PostSandboxOrder',
        $argument,
        ['\Tinkoff\Invest\V1\PostOrderResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения списка активных заявок по счёту в песочнице.
     * @param \Tinkoff\Invest\V1\GetOrdersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSandboxOrders(\Tinkoff\Invest\V1\GetOrdersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SandboxService/GetSandboxOrders',
        $argument,
        ['\Tinkoff\Invest\V1\GetOrdersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод отмены торгового поручения в песочнице.
     * @param \Tinkoff\Invest\V1\CancelOrderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelSandboxOrder(\Tinkoff\Invest\V1\CancelOrderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SandboxService/CancelSandboxOrder',
        $argument,
        ['\Tinkoff\Invest\V1\CancelOrderResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения статуса заявки в песочнице.
     * @param \Tinkoff\Invest\V1\GetOrderStateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSandboxOrderState(\Tinkoff\Invest\V1\GetOrderStateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SandboxService/GetSandboxOrderState',
        $argument,
        ['\Tinkoff\Invest\V1\OrderState', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения позиций по виртуальному счёту песочницы.
     * @param \Tinkoff\Invest\V1\PositionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSandboxPositions(\Tinkoff\Invest\V1\PositionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SandboxService/GetSandboxPositions',
        $argument,
        ['\Tinkoff\Invest\V1\PositionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения операций в песочнице по номеру счёта.
     * @param \Tinkoff\Invest\V1\OperationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSandboxOperations(\Tinkoff\Invest\V1\OperationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SandboxService/GetSandboxOperations',
        $argument,
        ['\Tinkoff\Invest\V1\OperationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод получения портфолио в песочнице.
     * @param \Tinkoff\Invest\V1\PortfolioRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSandboxPortfolio(\Tinkoff\Invest\V1\PortfolioRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SandboxService/GetSandboxPortfolio',
        $argument,
        ['\Tinkoff\Invest\V1\PortfolioResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Метод пополнения счёта в песочнице.
     * @param \Tinkoff\Invest\V1\SandboxPayInRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SandboxPayIn(\Tinkoff\Invest\V1\SandboxPayInRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SandboxService/SandboxPayIn',
        $argument,
        ['\Tinkoff\Invest\V1\SandboxPayInResponse', 'decode'],
        $metadata, $options);
    }

}
