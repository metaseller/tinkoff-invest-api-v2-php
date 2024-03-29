<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: orders.proto

namespace Tinkoff\Invest\V1\GetOrderPriceResponse;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.GetOrderPriceResponse.ExtraBond</code>
 */
class ExtraBond extends \Google\Protobuf\Internal\Message
{
    /**
     *Значение НКД (накопленного купонного дохода) на дату
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue aci_value = 2;</code>
     */
    protected $aci_value = null;
    /**
     *Курс конвертации для замещающих облигаций
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.Quotation nominal_conversion_rate = 3;</code>
     */
    protected $nominal_conversion_rate = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Tinkoff\Invest\V1\MoneyValue $aci_value
     *          Значение НКД (накопленного купонного дохода) на дату
     *     @type \Tinkoff\Invest\V1\Quotation $nominal_conversion_rate
     *          Курс конвертации для замещающих облигаций
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Orders::initOnce();
        parent::__construct($data);
    }

    /**
     *Значение НКД (накопленного купонного дохода) на дату
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue aci_value = 2;</code>
     * @return \Tinkoff\Invest\V1\MoneyValue|null
     */
    public function getAciValue()
    {
        return isset($this->aci_value) ? $this->aci_value : null;
    }

    public function hasAciValue()
    {
        return isset($this->aci_value);
    }

    public function clearAciValue()
    {
        unset($this->aci_value);
    }

    /**
     *Значение НКД (накопленного купонного дохода) на дату
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.MoneyValue aci_value = 2;</code>
     * @param \Tinkoff\Invest\V1\MoneyValue $var
     * @return $this
     */
    public function setAciValue($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\MoneyValue::class);
        $this->aci_value = $var;

        return $this;
    }

    /**
     *Курс конвертации для замещающих облигаций
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.Quotation nominal_conversion_rate = 3;</code>
     * @return \Tinkoff\Invest\V1\Quotation|null
     */
    public function getNominalConversionRate()
    {
        return isset($this->nominal_conversion_rate) ? $this->nominal_conversion_rate : null;
    }

    public function hasNominalConversionRate()
    {
        return isset($this->nominal_conversion_rate);
    }

    public function clearNominalConversionRate()
    {
        unset($this->nominal_conversion_rate);
    }

    /**
     *Курс конвертации для замещающих облигаций
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.Quotation nominal_conversion_rate = 3;</code>
     * @param \Tinkoff\Invest\V1\Quotation $var
     * @return $this
     */
    public function setNominalConversionRate($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\Quotation::class);
        $this->nominal_conversion_rate = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ExtraBond::class, \Tinkoff\Invest\V1\GetOrderPriceResponse_ExtraBond::class);

