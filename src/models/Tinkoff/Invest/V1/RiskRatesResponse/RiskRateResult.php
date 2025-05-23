<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: instruments.proto

namespace Tinkoff\Invest\V1\RiskRatesResponse;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.RiskRatesResponse.RiskRateResult</code>
 */
class RiskRateResult extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string instrument_uid = 1;</code>
     */
    protected $instrument_uid = '';
    /**
     * Ставка риска пользователя  в шорт
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.RiskRatesResponse.RiskRate short_risk_rate = 2;</code>
     */
    protected $short_risk_rate = null;
    /**
     * Ставка риска пользователя в лонг
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.RiskRatesResponse.RiskRate long_risk_rate = 3;</code>
     */
    protected $long_risk_rate = null;
    /**
     *Доступные ставки риска в шорт
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.RiskRatesResponse.RiskRate short_risk_rates = 5;</code>
     */
    private $short_risk_rates;
    /**
     *Доступные ставки риска в лонг
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.RiskRatesResponse.RiskRate long_risk_rates = 6;</code>
     */
    private $long_risk_rates;
    /**
     * Ошибка.
     *
     * Generated from protobuf field <code>string error = 9;</code>
     */
    protected $error = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $instrument_uid
     *     @type \Tinkoff\Invest\V1\RiskRatesResponse\RiskRate $short_risk_rate
     *           Ставка риска пользователя  в шорт
     *     @type \Tinkoff\Invest\V1\RiskRatesResponse\RiskRate $long_risk_rate
     *           Ставка риска пользователя в лонг
     *     @type \Tinkoff\Invest\V1\RiskRatesResponse\RiskRate[]|\Google\Protobuf\Internal\RepeatedField $short_risk_rates
     *          Доступные ставки риска в шорт
     *     @type \Tinkoff\Invest\V1\RiskRatesResponse\RiskRate[]|\Google\Protobuf\Internal\RepeatedField $long_risk_rates
     *          Доступные ставки риска в лонг
     *     @type string $error
     *           Ошибка.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Instruments::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string instrument_uid = 1;</code>
     * @return string
     */
    public function getInstrumentUid()
    {
        return $this->instrument_uid;
    }

    /**
     * Generated from protobuf field <code>string instrument_uid = 1;</code>
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
     * Ставка риска пользователя  в шорт
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.RiskRatesResponse.RiskRate short_risk_rate = 2;</code>
     * @return \Tinkoff\Invest\V1\RiskRatesResponse\RiskRate|null
     */
    public function getShortRiskRate()
    {
        return isset($this->short_risk_rate) ? $this->short_risk_rate : null;
    }

    public function hasShortRiskRate()
    {
        return isset($this->short_risk_rate);
    }

    public function clearShortRiskRate()
    {
        unset($this->short_risk_rate);
    }

    /**
     * Ставка риска пользователя  в шорт
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.RiskRatesResponse.RiskRate short_risk_rate = 2;</code>
     * @param \Tinkoff\Invest\V1\RiskRatesResponse\RiskRate $var
     * @return $this
     */
    public function setShortRiskRate($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\RiskRatesResponse\RiskRate::class);
        $this->short_risk_rate = $var;

        return $this;
    }

    /**
     * Ставка риска пользователя в лонг
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.RiskRatesResponse.RiskRate long_risk_rate = 3;</code>
     * @return \Tinkoff\Invest\V1\RiskRatesResponse\RiskRate|null
     */
    public function getLongRiskRate()
    {
        return isset($this->long_risk_rate) ? $this->long_risk_rate : null;
    }

    public function hasLongRiskRate()
    {
        return isset($this->long_risk_rate);
    }

    public function clearLongRiskRate()
    {
        unset($this->long_risk_rate);
    }

    /**
     * Ставка риска пользователя в лонг
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.RiskRatesResponse.RiskRate long_risk_rate = 3;</code>
     * @param \Tinkoff\Invest\V1\RiskRatesResponse\RiskRate $var
     * @return $this
     */
    public function setLongRiskRate($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\RiskRatesResponse\RiskRate::class);
        $this->long_risk_rate = $var;

        return $this;
    }

    /**
     *Доступные ставки риска в шорт
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.RiskRatesResponse.RiskRate short_risk_rates = 5;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getShortRiskRates()
    {
        return $this->short_risk_rates;
    }

    /**
     *Доступные ставки риска в шорт
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.RiskRatesResponse.RiskRate short_risk_rates = 5;</code>
     * @param \Tinkoff\Invest\V1\RiskRatesResponse\RiskRate[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setShortRiskRates($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Tinkoff\Invest\V1\RiskRatesResponse\RiskRate::class);
        $this->short_risk_rates = $arr;

        return $this;
    }

    /**
     *Доступные ставки риска в лонг
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.RiskRatesResponse.RiskRate long_risk_rates = 6;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getLongRiskRates()
    {
        return $this->long_risk_rates;
    }

    /**
     *Доступные ставки риска в лонг
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.RiskRatesResponse.RiskRate long_risk_rates = 6;</code>
     * @param \Tinkoff\Invest\V1\RiskRatesResponse\RiskRate[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setLongRiskRates($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Tinkoff\Invest\V1\RiskRatesResponse\RiskRate::class);
        $this->long_risk_rates = $arr;

        return $this;
    }

    /**
     * Ошибка.
     *
     * Generated from protobuf field <code>string error = 9;</code>
     * @return string
     */
    public function getError()
    {
        return isset($this->error) ? $this->error : '';
    }

    public function hasError()
    {
        return isset($this->error);
    }

    public function clearError()
    {
        unset($this->error);
    }

    /**
     * Ошибка.
     *
     * Generated from protobuf field <code>string error = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setError($var)
    {
        GPBUtil::checkString($var, True);
        $this->error = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(RiskRateResult::class, \Tinkoff\Invest\V1\RiskRatesResponse_RiskRateResult::class);

