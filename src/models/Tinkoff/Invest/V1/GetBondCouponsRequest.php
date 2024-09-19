<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: instruments.proto

namespace Tinkoff\Invest\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *Запрос купонов по облигации.
 *
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.GetBondCouponsRequest</code>
 */
class GetBondCouponsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     *FIGI-идентификатор инструмента.
     *
     * Generated from protobuf field <code>string figi = 1 [deprecated = true];</code>
     * @deprecated
     */
    protected $figi = '';
    /**
     *Начало запрашиваемого периода по UTC. Фильтрация по `coupon_date` — дата выплаты купона.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp from = 2;</code>
     */
    protected $from = null;
    /**
     *Окончание запрашиваемого периода по UTC. Фильтрация по `coupon_date` — дата выплаты купона.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp to = 3;</code>
     */
    protected $to = null;
    /**
     *Идентификатор инструмента — `figi` или `instrument_uid`.
     *
     * Generated from protobuf field <code>string instrument_id = 4 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $instrument_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $figi
     *          FIGI-идентификатор инструмента.
     *     @type \Google\Protobuf\Timestamp $from
     *          Начало запрашиваемого периода по UTC. Фильтрация по `coupon_date` — дата выплаты купона.
     *     @type \Google\Protobuf\Timestamp $to
     *          Окончание запрашиваемого периода по UTC. Фильтрация по `coupon_date` — дата выплаты купона.
     *     @type string $instrument_id
     *          Идентификатор инструмента — `figi` или `instrument_uid`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Instruments::initOnce();
        parent::__construct($data);
    }

    /**
     *FIGI-идентификатор инструмента.
     *
     * Generated from protobuf field <code>string figi = 1 [deprecated = true];</code>
     * @return string
     * @deprecated
     */
    public function getFigi()
    {
        @trigger_error('figi is deprecated.', E_USER_DEPRECATED);
        return $this->figi;
    }

    /**
     *FIGI-идентификатор инструмента.
     *
     * Generated from protobuf field <code>string figi = 1 [deprecated = true];</code>
     * @param string $var
     * @return $this
     * @deprecated
     */
    public function setFigi($var)
    {
        @trigger_error('figi is deprecated.', E_USER_DEPRECATED);
        GPBUtil::checkString($var, True);
        $this->figi = $var;

        return $this;
    }

    /**
     *Начало запрашиваемого периода по UTC. Фильтрация по `coupon_date` — дата выплаты купона.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp from = 2;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getFrom()
    {
        return isset($this->from) ? $this->from : null;
    }

    public function hasFrom()
    {
        return isset($this->from);
    }

    public function clearFrom()
    {
        unset($this->from);
    }

    /**
     *Начало запрашиваемого периода по UTC. Фильтрация по `coupon_date` — дата выплаты купона.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp from = 2;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setFrom($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->from = $var;

        return $this;
    }

    /**
     *Окончание запрашиваемого периода по UTC. Фильтрация по `coupon_date` — дата выплаты купона.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp to = 3;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getTo()
    {
        return isset($this->to) ? $this->to : null;
    }

    public function hasTo()
    {
        return isset($this->to);
    }

    public function clearTo()
    {
        unset($this->to);
    }

    /**
     *Окончание запрашиваемого периода по UTC. Фильтрация по `coupon_date` — дата выплаты купона.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp to = 3;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setTo($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->to = $var;

        return $this;
    }

    /**
     *Идентификатор инструмента — `figi` или `instrument_uid`.
     *
     * Generated from protobuf field <code>string instrument_id = 4 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getInstrumentId()
    {
        return $this->instrument_id;
    }

    /**
     *Идентификатор инструмента — `figi` или `instrument_uid`.
     *
     * Generated from protobuf field <code>string instrument_id = 4 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setInstrumentId($var)
    {
        GPBUtil::checkString($var, True);
        $this->instrument_id = $var;

        return $this;
    }

}

