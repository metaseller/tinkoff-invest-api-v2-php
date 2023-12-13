<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: orders.proto

namespace Tinkoff\Invest\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *Результат количество доступных для покупки/продажи лотов
 *
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.GetMaxLotsResponse</code>
 */
class GetMaxLotsResponse extends \Google\Protobuf\Internal\Message
{
    /**
     *Валюта инструмента
     *
     * Generated from protobuf field <code>string currency = 1;</code>
     */
    protected $currency = '';
    /**
     *Лимиты для покупок на собственные деньги
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetMaxLotsResponse.BuyLimitsView buy_limits = 2;</code>
     */
    protected $buy_limits = null;
    /**
     *Лимиты для покупок с учетом маржинального кредитования
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetMaxLotsResponse.BuyLimitsView buy_margin_limits = 3;</code>
     */
    protected $buy_margin_limits = null;
    /**
     *Лимиты для продаж по собственной позиции
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetMaxLotsResponse.SellLimitsView sell_limits = 4;</code>
     */
    protected $sell_limits = null;
    /**
     *Лимиты для продаж с учетом маржинального кредитования
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetMaxLotsResponse.SellLimitsView sell_margin_limits = 5;</code>
     */
    protected $sell_margin_limits = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $currency
     *          Валюта инструмента
     *     @type \Tinkoff\Invest\V1\GetMaxLotsResponse\BuyLimitsView $buy_limits
     *          Лимиты для покупок на собственные деньги
     *     @type \Tinkoff\Invest\V1\GetMaxLotsResponse\BuyLimitsView $buy_margin_limits
     *          Лимиты для покупок с учетом маржинального кредитования
     *     @type \Tinkoff\Invest\V1\GetMaxLotsResponse\SellLimitsView $sell_limits
     *          Лимиты для продаж по собственной позиции
     *     @type \Tinkoff\Invest\V1\GetMaxLotsResponse\SellLimitsView $sell_margin_limits
     *          Лимиты для продаж с учетом маржинального кредитования
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Orders::initOnce();
        parent::__construct($data);
    }

    /**
     *Валюта инструмента
     *
     * Generated from protobuf field <code>string currency = 1;</code>
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     *Валюта инструмента
     *
     * Generated from protobuf field <code>string currency = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setCurrency($var)
    {
        GPBUtil::checkString($var, True);
        $this->currency = $var;

        return $this;
    }

    /**
     *Лимиты для покупок на собственные деньги
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetMaxLotsResponse.BuyLimitsView buy_limits = 2;</code>
     * @return \Tinkoff\Invest\V1\GetMaxLotsResponse\BuyLimitsView|null
     */
    public function getBuyLimits()
    {
        return isset($this->buy_limits) ? $this->buy_limits : null;
    }

    public function hasBuyLimits()
    {
        return isset($this->buy_limits);
    }

    public function clearBuyLimits()
    {
        unset($this->buy_limits);
    }

    /**
     *Лимиты для покупок на собственные деньги
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetMaxLotsResponse.BuyLimitsView buy_limits = 2;</code>
     * @param \Tinkoff\Invest\V1\GetMaxLotsResponse\BuyLimitsView $var
     * @return $this
     */
    public function setBuyLimits($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\GetMaxLotsResponse\BuyLimitsView::class);
        $this->buy_limits = $var;

        return $this;
    }

    /**
     *Лимиты для покупок с учетом маржинального кредитования
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetMaxLotsResponse.BuyLimitsView buy_margin_limits = 3;</code>
     * @return \Tinkoff\Invest\V1\GetMaxLotsResponse\BuyLimitsView|null
     */
    public function getBuyMarginLimits()
    {
        return isset($this->buy_margin_limits) ? $this->buy_margin_limits : null;
    }

    public function hasBuyMarginLimits()
    {
        return isset($this->buy_margin_limits);
    }

    public function clearBuyMarginLimits()
    {
        unset($this->buy_margin_limits);
    }

    /**
     *Лимиты для покупок с учетом маржинального кредитования
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetMaxLotsResponse.BuyLimitsView buy_margin_limits = 3;</code>
     * @param \Tinkoff\Invest\V1\GetMaxLotsResponse\BuyLimitsView $var
     * @return $this
     */
    public function setBuyMarginLimits($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\GetMaxLotsResponse\BuyLimitsView::class);
        $this->buy_margin_limits = $var;

        return $this;
    }

    /**
     *Лимиты для продаж по собственной позиции
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetMaxLotsResponse.SellLimitsView sell_limits = 4;</code>
     * @return \Tinkoff\Invest\V1\GetMaxLotsResponse\SellLimitsView|null
     */
    public function getSellLimits()
    {
        return isset($this->sell_limits) ? $this->sell_limits : null;
    }

    public function hasSellLimits()
    {
        return isset($this->sell_limits);
    }

    public function clearSellLimits()
    {
        unset($this->sell_limits);
    }

    /**
     *Лимиты для продаж по собственной позиции
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetMaxLotsResponse.SellLimitsView sell_limits = 4;</code>
     * @param \Tinkoff\Invest\V1\GetMaxLotsResponse\SellLimitsView $var
     * @return $this
     */
    public function setSellLimits($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\GetMaxLotsResponse\SellLimitsView::class);
        $this->sell_limits = $var;

        return $this;
    }

    /**
     *Лимиты для продаж с учетом маржинального кредитования
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetMaxLotsResponse.SellLimitsView sell_margin_limits = 5;</code>
     * @return \Tinkoff\Invest\V1\GetMaxLotsResponse\SellLimitsView|null
     */
    public function getSellMarginLimits()
    {
        return isset($this->sell_margin_limits) ? $this->sell_margin_limits : null;
    }

    public function hasSellMarginLimits()
    {
        return isset($this->sell_margin_limits);
    }

    public function clearSellMarginLimits()
    {
        unset($this->sell_margin_limits);
    }

    /**
     *Лимиты для продаж с учетом маржинального кредитования
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetMaxLotsResponse.SellLimitsView sell_margin_limits = 5;</code>
     * @param \Tinkoff\Invest\V1\GetMaxLotsResponse\SellLimitsView $var
     * @return $this
     */
    public function setSellMarginLimits($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\GetMaxLotsResponse\SellLimitsView::class);
        $this->sell_margin_limits = $var;

        return $this;
    }

}

