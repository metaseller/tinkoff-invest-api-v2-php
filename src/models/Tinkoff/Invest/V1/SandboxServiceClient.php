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
     * Зарегистрировать счёт.
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
     * Получить счета.
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
     * Закрыть счёт.
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
     * Выставить торговое поручение.
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
     * Изменить выставленную заявку.
     * @param \Tinkoff\Invest\V1\ReplaceOrderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReplaceSandboxOrder(\Tinkoff\Invest\V1\ReplaceOrderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SandboxService/ReplaceSandboxOrder',
        $argument,
        ['\Tinkoff\Invest\V1\PostOrderResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Получить список активных заявок по счёту.
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
     * Отменить торговое поручение.
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
     * Поулчить статус заявки в песочнице. Заявки хранятся в таблице 7 дней.
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
     * Получить позиции по виртуальному счёту.
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
     * Получить операции по номеру счёта.
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
     * Получить операции по номеру счёта с пагинацией.
     * @param \Tinkoff\Invest\V1\GetOperationsByCursorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSandboxOperationsByCursor(\Tinkoff\Invest\V1\GetOperationsByCursorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SandboxService/GetSandboxOperationsByCursor',
        $argument,
        ['\Tinkoff\Invest\V1\GetOperationsByCursorResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Получить портфель.
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
     * Пополнить счёт.
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

    /**
     * Получить доступный остаток для вывода средств.
     * @param \Tinkoff\Invest\V1\WithdrawLimitsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSandboxWithdrawLimits(\Tinkoff\Invest\V1\WithdrawLimitsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SandboxService/GetSandboxWithdrawLimits',
        $argument,
        ['\Tinkoff\Invest\V1\WithdrawLimitsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Расчёт количества доступных для покупки/продажи лотов в песочнице.
     * @param \Tinkoff\Invest\V1\GetMaxLotsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSandboxMaxLots(\Tinkoff\Invest\V1\GetMaxLotsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/tinkoff.public.invest.api.contract.v1.SandboxService/GetSandboxMaxLots',
        $argument,
        ['\Tinkoff\Invest\V1\GetMaxLotsResponse', 'decode'],
        $metadata, $options);
    }

}
