<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: common.proto

namespace Tinkoff\Invest\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *Проверка активности стрима.
 *
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.Ping</code>
 */
class Ping extends \Google\Protobuf\Internal\Message
{
    /**
     *Время проверки.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp time = 1;</code>
     */
    protected $time = null;
    /**
     *Идентификатор соединения.
     *
     * Generated from protobuf field <code>string stream_id = 2;</code>
     */
    protected $stream_id = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Protobuf\Timestamp $time
     *          Время проверки.
     *     @type string $stream_id
     *          Идентификатор соединения.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Common::initOnce();
        parent::__construct($data);
    }

    /**
     *Время проверки.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp time = 1;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getTime()
    {
        return isset($this->time) ? $this->time : null;
    }

    public function hasTime()
    {
        return isset($this->time);
    }

    public function clearTime()
    {
        unset($this->time);
    }

    /**
     *Время проверки.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp time = 1;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->time = $var;

        return $this;
    }

    /**
     *Идентификатор соединения.
     *
     * Generated from protobuf field <code>string stream_id = 2;</code>
     * @return string
     */
    public function getStreamId()
    {
        return $this->stream_id;
    }

    /**
     *Идентификатор соединения.
     *
     * Generated from protobuf field <code>string stream_id = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setStreamId($var)
    {
        GPBUtil::checkString($var, True);
        $this->stream_id = $var;

        return $this;
    }

}

