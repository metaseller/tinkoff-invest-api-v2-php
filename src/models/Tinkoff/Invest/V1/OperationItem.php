<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: operations.proto

namespace Tinkoff\Invest\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *Данные об операции.
 *
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.OperationItem</code>
 */
class OperationItem extends \Google\Protobuf\Internal\Message
{
    /**
     *Курсор.
     *
     * Generated from protobuf field <code>string cursor = 1;</code>
     */
    protected $cursor = '';
    /**
     *Номер счёта клиента.
     *
     * Generated from protobuf field <code>string broker_account_id = 6;</code>
     */
    protected $broker_account_id = '';
    /**
     *Идентификатор операции, может меняться с течением времени.
     *
     * Generated from protobuf field <code>string id = 16;</code>
     */
    protected $id = '';
    /**
     *Идентификатор родительской операции. Может измениться, если изменился ID родительской операции.
     *
     * Generated from protobuf field <code>string parent_operation_id = 17;</code>
     */
    protected $parent_operation_id = '';
    /**
     *Название операции.
     *
     * Generated from protobuf field <code>string name = 18;</code>
     */
    protected $name = '';
    /**
     *Дата поручения.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp date = 21;</code>
     */
    protected $date = null;
    /**
     *Тип операции.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.OperationType type = 22;</code>
     */
    protected $type = 0;
    /**
     *Описание операции.
     *
     * Generated from protobuf field <code>string description = 23;</code>
     */
    protected $description = '';
    /**
     *Статус поручения.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.OperationState state = 24;</code>
     */
    protected $state = 0;
    /**
     *Уникальный идентификатор инструмента.
     *
     * Generated from protobuf field <code>string instrument_uid = 31;</code>
     */
    protected $instrument_uid = '';
    /**
     *FIGI.
     *
     * Generated from protobuf field <code>string figi = 32;</code>
     */
    protected $figi = '';
    /**
     *Тип инструмента.
     *
     * Generated from protobuf field <code>string instrument_type = 33;</code>
     */
    protected $instrument_type = '';
    /**
     *Тип инструмента.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.InstrumentType instrument_kind = 34;</code>
     */
    protected $instrument_kind = 0;
    /**
     *Уникальный идентификатор позиции.
     *
     * Generated from protobuf field <code>string position_uid = 35;</code>
     */
    protected $position_uid = '';
    /**
     *Сумма операции.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue payment = 41;</code>
     */
    protected $payment = null;
    /**
     *Цена операции за 1 инструмент.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue price = 42;</code>
     */
    protected $price = null;
    /**
     *Комиссия.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue commission = 43;</code>
     */
    protected $commission = null;
    /**
     *Доходность.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue yield = 44;</code>
     */
    protected $yield = null;
    /**
     *Относительная доходность.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.Quotation yield_relative = 45;</code>
     */
    protected $yield_relative = null;
    /**
     *Накопленный купонный доход.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue accrued_int = 46;</code>
     */
    protected $accrued_int = null;
    /**
     *Количество единиц инструмента.
     *
     * Generated from protobuf field <code>int64 quantity = 51;</code>
     */
    protected $quantity = 0;
    /**
     *Неисполненный остаток по сделке.
     *
     * Generated from protobuf field <code>int64 quantity_rest = 52;</code>
     */
    protected $quantity_rest = 0;
    /**
     *Исполненный остаток.
     *
     * Generated from protobuf field <code>int64 quantity_done = 53;</code>
     */
    protected $quantity_done = 0;
    /**
     *Дата и время снятия заявки.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp cancel_date_time = 56;</code>
     */
    protected $cancel_date_time = null;
    /**
     *Причина отмены операции.
     *
     * Generated from protobuf field <code>string cancel_reason = 57;</code>
     */
    protected $cancel_reason = '';
    /**
     *Массив сделок.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.OperationItemTrades trades_info = 61;</code>
     */
    protected $trades_info = null;
    /**
     *Идентификатор актива.
     *
     * Generated from protobuf field <code>string asset_uid = 64;</code>
     */
    protected $asset_uid = '';
    /**
     *Массив дочерних операций.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.ChildOperationItem child_operations = 65;</code>
     */
    private $child_operations;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $cursor
     *          Курсор.
     *     @type string $broker_account_id
     *          Номер счёта клиента.
     *     @type string $id
     *          Идентификатор операции, может меняться с течением времени.
     *     @type string $parent_operation_id
     *          Идентификатор родительской операции. Может измениться, если изменился ID родительской операции.
     *     @type string $name
     *          Название операции.
     *     @type \Google\Protobuf\Timestamp $date
     *          Дата поручения.
     *     @type int $type
     *          Тип операции.
     *     @type string $description
     *          Описание операции.
     *     @type int $state
     *          Статус поручения.
     *     @type string $instrument_uid
     *          Уникальный идентификатор инструмента.
     *     @type string $figi
     *          FIGI.
     *     @type string $instrument_type
     *          Тип инструмента.
     *     @type int $instrument_kind
     *          Тип инструмента.
     *     @type string $position_uid
     *          Уникальный идентификатор позиции.
     *     @type \Tinkoff\Invest\V1\MoneyValue $payment
     *          Сумма операции.
     *     @type \Tinkoff\Invest\V1\MoneyValue $price
     *          Цена операции за 1 инструмент.
     *     @type \Tinkoff\Invest\V1\MoneyValue $commission
     *          Комиссия.
     *     @type \Tinkoff\Invest\V1\MoneyValue $yield
     *          Доходность.
     *     @type \Tinkoff\Invest\V1\Quotation $yield_relative
     *          Относительная доходность.
     *     @type \Tinkoff\Invest\V1\MoneyValue $accrued_int
     *          Накопленный купонный доход.
     *     @type int|string $quantity
     *          Количество единиц инструмента.
     *     @type int|string $quantity_rest
     *          Неисполненный остаток по сделке.
     *     @type int|string $quantity_done
     *          Исполненный остаток.
     *     @type \Google\Protobuf\Timestamp $cancel_date_time
     *          Дата и время снятия заявки.
     *     @type string $cancel_reason
     *          Причина отмены операции.
     *     @type \Tinkoff\Invest\V1\OperationItemTrades $trades_info
     *          Массив сделок.
     *     @type string $asset_uid
     *          Идентификатор актива.
     *     @type \Tinkoff\Invest\V1\ChildOperationItem[]|\Google\Protobuf\Internal\RepeatedField $child_operations
     *          Массив дочерних операций.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Operations::initOnce();
        parent::__construct($data);
    }

    /**
     *Курсор.
     *
     * Generated from protobuf field <code>string cursor = 1;</code>
     * @return string
     */
    public function getCursor()
    {
        return $this->cursor;
    }

    /**
     *Курсор.
     *
     * Generated from protobuf field <code>string cursor = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setCursor($var)
    {
        GPBUtil::checkString($var, True);
        $this->cursor = $var;

        return $this;
    }

    /**
     *Номер счёта клиента.
     *
     * Generated from protobuf field <code>string broker_account_id = 6;</code>
     * @return string
     */
    public function getBrokerAccountId()
    {
        return $this->broker_account_id;
    }

    /**
     *Номер счёта клиента.
     *
     * Generated from protobuf field <code>string broker_account_id = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setBrokerAccountId($var)
    {
        GPBUtil::checkString($var, True);
        $this->broker_account_id = $var;

        return $this;
    }

    /**
     *Идентификатор операции, может меняться с течением времени.
     *
     * Generated from protobuf field <code>string id = 16;</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *Идентификатор операции, может меняться с течением времени.
     *
     * Generated from protobuf field <code>string id = 16;</code>
     * @param string $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkString($var, True);
        $this->id = $var;

        return $this;
    }

    /**
     *Идентификатор родительской операции. Может измениться, если изменился ID родительской операции.
     *
     * Generated from protobuf field <code>string parent_operation_id = 17;</code>
     * @return string
     */
    public function getParentOperationId()
    {
        return $this->parent_operation_id;
    }

    /**
     *Идентификатор родительской операции. Может измениться, если изменился ID родительской операции.
     *
     * Generated from protobuf field <code>string parent_operation_id = 17;</code>
     * @param string $var
     * @return $this
     */
    public function setParentOperationId($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent_operation_id = $var;

        return $this;
    }

    /**
     *Название операции.
     *
     * Generated from protobuf field <code>string name = 18;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *Название операции.
     *
     * Generated from protobuf field <code>string name = 18;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     *Дата поручения.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp date = 21;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getDate()
    {
        return isset($this->date) ? $this->date : null;
    }

    public function hasDate()
    {
        return isset($this->date);
    }

    public function clearDate()
    {
        unset($this->date);
    }

    /**
     *Дата поручения.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp date = 21;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setDate($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->date = $var;

        return $this;
    }

    /**
     *Тип операции.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.OperationType type = 22;</code>
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *Тип операции.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.OperationType type = 22;</code>
     * @param int $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkEnum($var, \Tinkoff\Invest\V1\OperationType::class);
        $this->type = $var;

        return $this;
    }

    /**
     *Описание операции.
     *
     * Generated from protobuf field <code>string description = 23;</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *Описание операции.
     *
     * Generated from protobuf field <code>string description = 23;</code>
     * @param string $var
     * @return $this
     */
    public function setDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->description = $var;

        return $this;
    }

    /**
     *Статус поручения.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.OperationState state = 24;</code>
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     *Статус поручения.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.OperationState state = 24;</code>
     * @param int $var
     * @return $this
     */
    public function setState($var)
    {
        GPBUtil::checkEnum($var, \Tinkoff\Invest\V1\OperationState::class);
        $this->state = $var;

        return $this;
    }

    /**
     *Уникальный идентификатор инструмента.
     *
     * Generated from protobuf field <code>string instrument_uid = 31;</code>
     * @return string
     */
    public function getInstrumentUid()
    {
        return $this->instrument_uid;
    }

    /**
     *Уникальный идентификатор инструмента.
     *
     * Generated from protobuf field <code>string instrument_uid = 31;</code>
     * @param string $var
     * @return $this
     */
    public function setInstrumentUid($var)
    {
        GPBUtil::checkString($var, True);
        $this->instrument_uid = $var;

        return $this;
    }

    /**
     *FIGI.
     *
     * Generated from protobuf field <code>string figi = 32;</code>
     * @return string
     */
    public function getFigi()
    {
        return $this->figi;
    }

    /**
     *FIGI.
     *
     * Generated from protobuf field <code>string figi = 32;</code>
     * @param string $var
     * @return $this
     */
    public function setFigi($var)
    {
        GPBUtil::checkString($var, True);
        $this->figi = $var;

        return $this;
    }

    /**
     *Тип инструмента.
     *
     * Generated from protobuf field <code>string instrument_type = 33;</code>
     * @return string
     */
    public function getInstrumentType()
    {
        return $this->instrument_type;
    }

    /**
     *Тип инструмента.
     *
     * Generated from protobuf field <code>string instrument_type = 33;</code>
     * @param string $var
     * @return $this
     */
    public function setInstrumentType($var)
    {
        GPBUtil::checkString($var, True);
        $this->instrument_type = $var;

        return $this;
    }

    /**
     *Тип инструмента.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.InstrumentType instrument_kind = 34;</code>
     * @return int
     */
    public function getInstrumentKind()
    {
        return $this->instrument_kind;
    }

    /**
     *Тип инструмента.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.InstrumentType instrument_kind = 34;</code>
     * @param int $var
     * @return $this
     */
    public function setInstrumentKind($var)
    {
        GPBUtil::checkEnum($var, \Tinkoff\Invest\V1\InstrumentType::class);
        $this->instrument_kind = $var;

        return $this;
    }

    /**
     *Уникальный идентификатор позиции.
     *
     * Generated from protobuf field <code>string position_uid = 35;</code>
     * @return string
     */
    public function getPositionUid()
    {
        return $this->position_uid;
    }

    /**
     *Уникальный идентификатор позиции.
     *
     * Generated from protobuf field <code>string position_uid = 35;</code>
     * @param string $var
     * @return $this
     */
    public function setPositionUid($var)
    {
        GPBUtil::checkString($var, True);
        $this->position_uid = $var;

        return $this;
    }

    /**
     *Сумма операции.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue payment = 41;</code>
     * @return \Tinkoff\Invest\V1\MoneyValue|null
     */
    public function getPayment()
    {
        return isset($this->payment) ? $this->payment : null;
    }

    public function hasPayment()
    {
        return isset($this->payment);
    }

    public function clearPayment()
    {
        unset($this->payment);
    }

    /**
     *Сумма операции.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue payment = 41;</code>
     * @param \Tinkoff\Invest\V1\MoneyValue $var
     * @return $this
     */
    public function setPayment($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\MoneyValue::class);
        $this->payment = $var;

        return $this;
    }

    /**
     *Цена операции за 1 инструмент.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue price = 42;</code>
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
     *Цена операции за 1 инструмент.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue price = 42;</code>
     * @param \Tinkoff\Invest\V1\MoneyValue $var
     * @return $this
     */
    public function setPrice($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\MoneyValue::class);
        $this->price = $var;

        return $this;
    }

    /**
     *Комиссия.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue commission = 43;</code>
     * @return \Tinkoff\Invest\V1\MoneyValue|null
     */
    public function getCommission()
    {
        return isset($this->commission) ? $this->commission : null;
    }

    public function hasCommission()
    {
        return isset($this->commission);
    }

    public function clearCommission()
    {
        unset($this->commission);
    }

    /**
     *Комиссия.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue commission = 43;</code>
     * @param \Tinkoff\Invest\V1\MoneyValue $var
     * @return $this
     */
    public function setCommission($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\MoneyValue::class);
        $this->commission = $var;

        return $this;
    }

    /**
     *Доходность.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue yield = 44;</code>
     * @return \Tinkoff\Invest\V1\MoneyValue|null
     */
    public function getYield()
    {
        return isset($this->yield) ? $this->yield : null;
    }

    public function hasYield()
    {
        return isset($this->yield);
    }

    public function clearYield()
    {
        unset($this->yield);
    }

    /**
     *Доходность.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue yield = 44;</code>
     * @param \Tinkoff\Invest\V1\MoneyValue $var
     * @return $this
     */
    public function setYield($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\MoneyValue::class);
        $this->yield = $var;

        return $this;
    }

    /**
     *Относительная доходность.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.Quotation yield_relative = 45;</code>
     * @return \Tinkoff\Invest\V1\Quotation|null
     */
    public function getYieldRelative()
    {
        return isset($this->yield_relative) ? $this->yield_relative : null;
    }

    public function hasYieldRelative()
    {
        return isset($this->yield_relative);
    }

    public function clearYieldRelative()
    {
        unset($this->yield_relative);
    }

    /**
     *Относительная доходность.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.Quotation yield_relative = 45;</code>
     * @param \Tinkoff\Invest\V1\Quotation $var
     * @return $this
     */
    public function setYieldRelative($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\Quotation::class);
        $this->yield_relative = $var;

        return $this;
    }

    /**
     *Накопленный купонный доход.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue accrued_int = 46;</code>
     * @return \Tinkoff\Invest\V1\MoneyValue|null
     */
    public function getAccruedInt()
    {
        return isset($this->accrued_int) ? $this->accrued_int : null;
    }

    public function hasAccruedInt()
    {
        return isset($this->accrued_int);
    }

    public function clearAccruedInt()
    {
        unset($this->accrued_int);
    }

    /**
     *Накопленный купонный доход.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue accrued_int = 46;</code>
     * @param \Tinkoff\Invest\V1\MoneyValue $var
     * @return $this
     */
    public function setAccruedInt($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\MoneyValue::class);
        $this->accrued_int = $var;

        return $this;
    }

    /**
     *Количество единиц инструмента.
     *
     * Generated from protobuf field <code>int64 quantity = 51;</code>
     * @return int|string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     *Количество единиц инструмента.
     *
     * Generated from protobuf field <code>int64 quantity = 51;</code>
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
     *Неисполненный остаток по сделке.
     *
     * Generated from protobuf field <code>int64 quantity_rest = 52;</code>
     * @return int|string
     */
    public function getQuantityRest()
    {
        return $this->quantity_rest;
    }

    /**
     *Неисполненный остаток по сделке.
     *
     * Generated from protobuf field <code>int64 quantity_rest = 52;</code>
     * @param int|string $var
     * @return $this
     */
    public function setQuantityRest($var)
    {
        GPBUtil::checkInt64($var);
        $this->quantity_rest = $var;

        return $this;
    }

    /**
     *Исполненный остаток.
     *
     * Generated from protobuf field <code>int64 quantity_done = 53;</code>
     * @return int|string
     */
    public function getQuantityDone()
    {
        return $this->quantity_done;
    }

    /**
     *Исполненный остаток.
     *
     * Generated from protobuf field <code>int64 quantity_done = 53;</code>
     * @param int|string $var
     * @return $this
     */
    public function setQuantityDone($var)
    {
        GPBUtil::checkInt64($var);
        $this->quantity_done = $var;

        return $this;
    }

    /**
     *Дата и время снятия заявки.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp cancel_date_time = 56;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getCancelDateTime()
    {
        return isset($this->cancel_date_time) ? $this->cancel_date_time : null;
    }

    public function hasCancelDateTime()
    {
        return isset($this->cancel_date_time);
    }

    public function clearCancelDateTime()
    {
        unset($this->cancel_date_time);
    }

    /**
     *Дата и время снятия заявки.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp cancel_date_time = 56;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setCancelDateTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->cancel_date_time = $var;

        return $this;
    }

    /**
     *Причина отмены операции.
     *
     * Generated from protobuf field <code>string cancel_reason = 57;</code>
     * @return string
     */
    public function getCancelReason()
    {
        return $this->cancel_reason;
    }

    /**
     *Причина отмены операции.
     *
     * Generated from protobuf field <code>string cancel_reason = 57;</code>
     * @param string $var
     * @return $this
     */
    public function setCancelReason($var)
    {
        GPBUtil::checkString($var, True);
        $this->cancel_reason = $var;

        return $this;
    }

    /**
     *Массив сделок.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.OperationItemTrades trades_info = 61;</code>
     * @return \Tinkoff\Invest\V1\OperationItemTrades|null
     */
    public function getTradesInfo()
    {
        return isset($this->trades_info) ? $this->trades_info : null;
    }

    public function hasTradesInfo()
    {
        return isset($this->trades_info);
    }

    public function clearTradesInfo()
    {
        unset($this->trades_info);
    }

    /**
     *Массив сделок.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.OperationItemTrades trades_info = 61;</code>
     * @param \Tinkoff\Invest\V1\OperationItemTrades $var
     * @return $this
     */
    public function setTradesInfo($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\OperationItemTrades::class);
        $this->trades_info = $var;

        return $this;
    }

    /**
     *Идентификатор актива.
     *
     * Generated from protobuf field <code>string asset_uid = 64;</code>
     * @return string
     */
    public function getAssetUid()
    {
        return $this->asset_uid;
    }

    /**
     *Идентификатор актива.
     *
     * Generated from protobuf field <code>string asset_uid = 64;</code>
     * @param string $var
     * @return $this
     */
    public function setAssetUid($var)
    {
        GPBUtil::checkString($var, True);
        $this->asset_uid = $var;

        return $this;
    }

    /**
     *Массив дочерних операций.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.ChildOperationItem child_operations = 65;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getChildOperations()
    {
        return $this->child_operations;
    }

    /**
     *Массив дочерних операций.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.ChildOperationItem child_operations = 65;</code>
     * @param \Tinkoff\Invest\V1\ChildOperationItem[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setChildOperations($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Tinkoff\Invest\V1\ChildOperationItem::class);
        $this->child_operations = $arr;

        return $this;
    }

}

