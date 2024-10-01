<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: instruments.proto

namespace Tinkoff\Invest\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *Запрос фундаментальных показателей
 *
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.GetAssetFundamentalsRequest</code>
 */
class GetAssetFundamentalsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     *Массив идентификаторов активов, не более 100 шт.
     *
     * Generated from protobuf field <code>repeated string assets = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $assets;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $assets
     *          Массив идентификаторов активов, не более 100 шт.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Instruments::initOnce();
        parent::__construct($data);
    }

    /**
     *Массив идентификаторов активов, не более 100 шт.
     *
     * Generated from protobuf field <code>repeated string assets = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     *Массив идентификаторов активов, не более 100 шт.
     *
     * Generated from protobuf field <code>repeated string assets = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAssets($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->assets = $arr;

        return $this;
    }

}
