<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: operations.proto

namespace Tinkoff\Invest\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *Сделка по операции.
 *
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.OperationTrade</code>
 */
class OperationTrade extends \Google\Protobuf\Internal\Message
{
    /**
     *Идентификатор сделки
     *
     * Generated from protobuf field <code>string trade_id = 1;</code>
     */
    protected $trade_id = '';
    /**
     *Дата и время сделки в часовом поясе UTC
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp date_time = 2;</code>
     */
    protected $date_time = null;
    /**
     *Количество инструментов
     *
     * Generated from protobuf field <code>int64 quantity = 3;</code>
     */
    protected $quantity = 0;
    /**
     *Цена
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue price = 4;</code>
     */
    protected $price = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $trade_id
     *          Идентификатор сделки
     *     @type \Google\Protobuf\Timestamp $date_time
     *          Дата и время сделки в часовом поясе UTC
     *     @type int|string $quantity
     *          Количество инструментов
     *     @type \Tinkoff\Invest\V1\MoneyValue $price
     *          Цена
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Operations::initOnce();
        parent::__construct($data);
    }

    /**
     *Идентификатор сделки
     *
     * Generated from protobuf field <code>string trade_id = 1;</code>
     * @return string
     */
    public function getTradeId()
    {
        return $this->trade_id;
    }

    /**
     *Идентификатор сделки
     *
     * Generated from protobuf field <code>string trade_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setTradeId($var)
    {
        GPBUtil::checkString($var, True);
        $this->trade_id = $var;

        return $this;
    }

    /**
     *Дата и время сделки в часовом поясе UTC
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp date_time = 2;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getDateTime()
    {
        return isset($this->date_time) ? $this->date_time : null;
    }

    public function hasDateTime()
    {
        return isset($this->date_time);
    }

    public function clearDateTime()
    {
        unset($this->date_time);
    }

    /**
     *Дата и время сделки в часовом поясе UTC
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp date_time = 2;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setDateTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->date_time = $var;

        return $this;
    }

    /**
     *Количество инструментов
     *
     * Generated from protobuf field <code>int64 quantity = 3;</code>
     * @return int|string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     *Количество инструментов
     *
     * Generated from protobuf field <code>int64 quantity = 3;</code>
     * @param int|string $var
     * @return $this
     */
    public function setQuantity($var)
    {
        GPBUtil::checkInt64($var);
        $this->quantity = $var;

        return $this;
    }

    /**
     *Цена
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue price = 4;</code>
     * @return \Tinkoff\Invest\V1\MoneyValue|null
     */
    public function getPrice()
    {
        return isset($this->price) ? $this->price : null;
    }

    public function hasPrice()
    {
        return isset($this->price);
    }

    public function clearPrice()
    {
        unset($this->price);
    }

    /**
     *Цена
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue price = 4;</code>
     * @param \Tinkoff\Invest\V1\MoneyValue $var
     * @return $this
     */
    public function setPrice($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\MoneyValue::class);
        $this->price = $var;

        return $this;
    }

}
