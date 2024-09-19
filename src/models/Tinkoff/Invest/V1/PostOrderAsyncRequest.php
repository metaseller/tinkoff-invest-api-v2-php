<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: orders.proto

namespace Tinkoff\Invest\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *Запрос выставления асинхронного торгового поручения.
 *
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.PostOrderAsyncRequest</code>
 */
class PostOrderAsyncRequest extends \Google\Protobuf\Internal\Message
{
    /**
     *Идентификатор инструмента, принимает значения Figi или Instrument_uid.
     *
     * Generated from protobuf field <code>string instrument_id = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $instrument_id = '';
    /**
     *Количество лотов.
     *
     * Generated from protobuf field <code>int64 quantity = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $quantity = 0;
    /**
     *Цена за 1 инструмент. Для получения стоимости лота требуется умножить на лотность инструмента. Игнорируется для рыночных поручений.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.Quotation price = 3;</code>
     */
    protected $price = null;
    /**
     *Направление операции.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.OrderDirection direction = 4 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $direction = 0;
    /**
     *Номер счёта.
     *
     * Generated from protobuf field <code>string account_id = 5 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $account_id = '';
    /**
     *Тип заявки.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.OrderType order_type = 6 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $order_type = 0;
    /**
     *Идентификатор запроса выставления поручения для целей идемпотентности в формате UID. Максимальная длина 36 символов.
     *
     * Generated from protobuf field <code>string order_id = 7 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $order_id = '';
    /**
     *Алгоритм исполнения поручения, применяется только к лимитной заявке.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.TimeInForceType time_in_force = 8;</code>
     */
    protected $time_in_force = null;
    /**
     *Тип цены.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.PriceType price_type = 9;</code>
     */
    protected $price_type = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $instrument_id
     *          Идентификатор инструмента, принимает значения Figi или Instrument_uid.
     *     @type int|string $quantity
     *          Количество лотов.
     *     @type \Tinkoff\Invest\V1\Quotation $price
     *          Цена за 1 инструмент. Для получения стоимости лота требуется умножить на лотность инструмента. Игнорируется для рыночных поручений.
     *     @type int $direction
     *          Направление операции.
     *     @type string $account_id
     *          Номер счёта.
     *     @type int $order_type
     *          Тип заявки.
     *     @type string $order_id
     *          Идентификатор запроса выставления поручения для целей идемпотентности в формате UID. Максимальная длина 36 символов.
     *     @type int $time_in_force
     *          Алгоритм исполнения поручения, применяется только к лимитной заявке.
     *     @type int $price_type
     *          Тип цены.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Orders::initOnce();
        parent::__construct($data);
    }

    /**
     *Идентификатор инструмента, принимает значения Figi или Instrument_uid.
     *
     * Generated from protobuf field <code>string instrument_id = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getInstrumentId()
    {
        return $this->instrument_id;
    }

    /**
     *Идентификатор инструмента, принимает значения Figi или Instrument_uid.
     *
     * Generated from protobuf field <code>string instrument_id = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setInstrumentId($var)
    {
        GPBUtil::checkString($var, True);
        $this->instrument_id = $var;

        return $this;
    }

    /**
     *Количество лотов.
     *
     * Generated from protobuf field <code>int64 quantity = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return int|string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     *Количество лотов.
     *
     * Generated from protobuf field <code>int64 quantity = 2 [(.google.api.field_behavior) = REQUIRED];</code>
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
     *Цена за 1 инструмент. Для получения стоимости лота требуется умножить на лотность инструмента. Игнорируется для рыночных поручений.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.Quotation price = 3;</code>
     * @return \Tinkoff\Invest\V1\Quotation|null
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
     *Цена за 1 инструмент. Для получения стоимости лота требуется умножить на лотность инструмента. Игнорируется для рыночных поручений.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.Quotation price = 3;</code>
     * @param \Tinkoff\Invest\V1\Quotation $var
     * @return $this
     */
    public function setPrice($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\Quotation::class);
        $this->price = $var;

        return $this;
    }

    /**
     *Направление операции.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.OrderDirection direction = 4 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return int
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     *Направление операции.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.OrderDirection direction = 4 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param int $var
     * @return $this
     */
    public function setDirection($var)
    {
        GPBUtil::checkEnum($var, \Tinkoff\Invest\V1\OrderDirection::class);
        $this->direction = $var;

        return $this;
    }

    /**
     *Номер счёта.
     *
     * Generated from protobuf field <code>string account_id = 5 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     *Номер счёта.
     *
     * Generated from protobuf field <code>string account_id = 5 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setAccountId($var)
    {
        GPBUtil::checkString($var, True);
        $this->account_id = $var;

        return $this;
    }

    /**
     *Тип заявки.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.OrderType order_type = 6 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return int
     */
    public function getOrderType()
    {
        return $this->order_type;
    }

    /**
     *Тип заявки.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.OrderType order_type = 6 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param int $var
     * @return $this
     */
    public function setOrderType($var)
    {
        GPBUtil::checkEnum($var, \Tinkoff\Invest\V1\OrderType::class);
        $this->order_type = $var;

        return $this;
    }

    /**
     *Идентификатор запроса выставления поручения для целей идемпотентности в формате UID. Максимальная длина 36 символов.
     *
     * Generated from protobuf field <code>string order_id = 7 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     *Идентификатор запроса выставления поручения для целей идемпотентности в формате UID. Максимальная длина 36 символов.
     *
     * Generated from protobuf field <code>string order_id = 7 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setOrderId($var)
    {
        GPBUtil::checkString($var, True);
        $this->order_id = $var;

        return $this;
    }

    /**
     *Алгоритм исполнения поручения, применяется только к лимитной заявке.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.TimeInForceType time_in_force = 8;</code>
     * @return int
     */
    public function getTimeInForce()
    {
        return isset($this->time_in_force) ? $this->time_in_force : 0;
    }

    public function hasTimeInForce()
    {
        return isset($this->time_in_force);
    }

    public function clearTimeInForce()
    {
        unset($this->time_in_force);
    }

    /**
     *Алгоритм исполнения поручения, применяется только к лимитной заявке.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.TimeInForceType time_in_force = 8;</code>
     * @param int $var
     * @return $this
     */
    public function setTimeInForce($var)
    {
        GPBUtil::checkEnum($var, \Tinkoff\Invest\V1\TimeInForceType::class);
        $this->time_in_force = $var;

        return $this;
    }

    /**
     *Тип цены.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.PriceType price_type = 9;</code>
     * @return int
     */
    public function getPriceType()
    {
        return isset($this->price_type) ? $this->price_type : 0;
    }

    public function hasPriceType()
    {
        return isset($this->price_type);
    }

    public function clearPriceType()
    {
        unset($this->price_type);
    }

    /**
     *Тип цены.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.PriceType price_type = 9;</code>
     * @param int $var
     * @return $this
     */
    public function setPriceType($var)
    {
        GPBUtil::checkEnum($var, \Tinkoff\Invest\V1\PriceType::class);
        $this->price_type = $var;

        return $this;
    }

}

