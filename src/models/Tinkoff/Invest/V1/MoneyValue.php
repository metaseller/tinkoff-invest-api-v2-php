<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: common.proto

namespace Tinkoff\Invest\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *Денежная сумма в определенной валюте
 *
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.MoneyValue</code>
 */
class MoneyValue extends \Google\Protobuf\Internal\Message
{
    /**
     * строковый ISO-код валюты
     *
     * Generated from protobuf field <code>string currency = 1;</code>
     */
    protected $currency = '';
    /**
     * целая часть суммы, может быть отрицательным числом
     *
     * Generated from protobuf field <code>int64 units = 2;</code>
     */
    protected $units = 0;
    /**
     * дробная часть суммы, может быть отрицательным числом
     *
     * Generated from protobuf field <code>int32 nano = 3;</code>
     */
    protected $nano = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $currency
     *           строковый ISO-код валюты
     *     @type int|string $units
     *           целая часть суммы, может быть отрицательным числом
     *     @type int $nano
     *           дробная часть суммы, может быть отрицательным числом
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Common::initOnce();
        parent::__construct($data);
    }

    /**
     * строковый ISO-код валюты
     *
     * Generated from protobuf field <code>string currency = 1;</code>
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * строковый ISO-код валюты
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
     * целая часть суммы, может быть отрицательным числом
     *
     * Generated from protobuf field <code>int64 units = 2;</code>
     * @return int|string
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * целая часть суммы, может быть отрицательным числом
     *
     * Generated from protobuf field <code>int64 units = 2;</code>
     * @param int|string $var
     * @return $this
     */
    public function setUnits($var)
    {
        GPBUtil::checkInt64($var);
        $this->units = $var;

        return $this;
    }

    /**
     * дробная часть суммы, может быть отрицательным числом
     *
     * Generated from protobuf field <code>int32 nano = 3;</code>
     * @return int
     */
    public function getNano()
    {
        return $this->nano;
    }

    /**
     * дробная часть суммы, может быть отрицательным числом
     *
     * Generated from protobuf field <code>int32 nano = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setNano($var)
    {
        GPBUtil::checkInt32($var);
        $this->nano = $var;

        return $this;
    }

}
