<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: instruments.proto

namespace Tinkoff\Invest\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.GetAssetFundamentalsResponse</code>
 */
class GetAssetFundamentalsResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.GetAssetFundamentalsResponse.StatisticResponse fundamentals = 1;</code>
     */
    private $fundamentals;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Tinkoff\Invest\V1\GetAssetFundamentalsResponse\StatisticResponse[]|\Google\Protobuf\Internal\RepeatedField $fundamentals
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Instruments::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.GetAssetFundamentalsResponse.StatisticResponse fundamentals = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getFundamentals()
    {
        return $this->fundamentals;
    }

    /**
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.GetAssetFundamentalsResponse.StatisticResponse fundamentals = 1;</code>
     * @param \Tinkoff\Invest\V1\GetAssetFundamentalsResponse\StatisticResponse[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setFundamentals($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Tinkoff\Invest\V1\GetAssetFundamentalsResponse\StatisticResponse::class);
        $this->fundamentals = $arr;

        return $this;
    }

}

