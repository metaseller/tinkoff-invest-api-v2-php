<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: operations.proto

namespace Tinkoff\Invest\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *Список позиций по счёту.
 *
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.PositionsResponse</code>
 */
class PositionsResponse extends \Google\Protobuf\Internal\Message
{
    /**
     *Массив валютных позиций портфеля.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.MoneyValue money = 1;</code>
     */
    private $money;
    /**
     *Массив заблокированных валютных позиций портфеля.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.MoneyValue blocked = 2;</code>
     */
    private $blocked;
    /**
     *Список ценно-бумажных позиций портфеля.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.PositionsSecurities securities = 3;</code>
     */
    private $securities;
    /**
     *Признак идущей выгрузки лимитов в данный момент.
     *
     * Generated from protobuf field <code>bool limits_loading_in_progress = 4;</code>
     */
    protected $limits_loading_in_progress = false;
    /**
     *Список фьючерсов портфеля.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.PositionsFutures futures = 5;</code>
     */
    private $futures;
    /**
     *Список опционов портфеля.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.PositionsOptions options = 6;</code>
     */
    private $options;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Tinkoff\Invest\V1\MoneyValue[]|\Google\Protobuf\Internal\RepeatedField $money
     *          Массив валютных позиций портфеля.
     *     @type \Tinkoff\Invest\V1\MoneyValue[]|\Google\Protobuf\Internal\RepeatedField $blocked
     *          Массив заблокированных валютных позиций портфеля.
     *     @type \Tinkoff\Invest\V1\PositionsSecurities[]|\Google\Protobuf\Internal\RepeatedField $securities
     *          Список ценно-бумажных позиций портфеля.
     *     @type bool $limits_loading_in_progress
     *          Признак идущей выгрузки лимитов в данный момент.
     *     @type \Tinkoff\Invest\V1\PositionsFutures[]|\Google\Protobuf\Internal\RepeatedField $futures
     *          Список фьючерсов портфеля.
     *     @type \Tinkoff\Invest\V1\PositionsOptions[]|\Google\Protobuf\Internal\RepeatedField $options
     *          Список опционов портфеля.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Operations::initOnce();
        parent::__construct($data);
    }

    /**
     *Массив валютных позиций портфеля.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.MoneyValue money = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     *Массив валютных позиций портфеля.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.MoneyValue money = 1;</code>
     * @param \Tinkoff\Invest\V1\MoneyValue[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setMoney($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Tinkoff\Invest\V1\MoneyValue::class);
        $this->money = $arr;

        return $this;
    }

    /**
     *Массив заблокированных валютных позиций портфеля.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.MoneyValue blocked = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getBlocked()
    {
        return $this->blocked;
    }

    /**
     *Массив заблокированных валютных позиций портфеля.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.MoneyValue blocked = 2;</code>
     * @param \Tinkoff\Invest\V1\MoneyValue[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setBlocked($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Tinkoff\Invest\V1\MoneyValue::class);
        $this->blocked = $arr;

        return $this;
    }

    /**
     *Список ценно-бумажных позиций портфеля.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.PositionsSecurities securities = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getSecurities()
    {
        return $this->securities;
    }

    /**
     *Список ценно-бумажных позиций портфеля.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.PositionsSecurities securities = 3;</code>
     * @param \Tinkoff\Invest\V1\PositionsSecurities[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setSecurities($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Tinkoff\Invest\V1\PositionsSecurities::class);
        $this->securities = $arr;

        return $this;
    }

    /**
     *Признак идущей выгрузки лимитов в данный момент.
     *
     * Generated from protobuf field <code>bool limits_loading_in_progress = 4;</code>
     * @return bool
     */
    public function getLimitsLoadingInProgress()
    {
        return $this->limits_loading_in_progress;
    }

    /**
     *Признак идущей выгрузки лимитов в данный момент.
     *
     * Generated from protobuf field <code>bool limits_loading_in_progress = 4;</code>
     * @param bool $var
     * @return $this
     */
    public function setLimitsLoadingInProgress($var)
    {
        GPBUtil::checkBool($var);
        $this->limits_loading_in_progress = $var;

        return $this;
    }

    /**
     *Список фьючерсов портфеля.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.PositionsFutures futures = 5;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getFutures()
    {
        return $this->futures;
    }

    /**
     *Список фьючерсов портфеля.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.PositionsFutures futures = 5;</code>
     * @param \Tinkoff\Invest\V1\PositionsFutures[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setFutures($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Tinkoff\Invest\V1\PositionsFutures::class);
        $this->futures = $arr;

        return $this;
    }

    /**
     *Список опционов портфеля.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.PositionsOptions options = 6;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     *Список опционов портфеля.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.PositionsOptions options = 6;</code>
     * @param \Tinkoff\Invest\V1\PositionsOptions[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setOptions($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Tinkoff\Invest\V1\PositionsOptions::class);
        $this->options = $arr;

        return $this;
    }

}

