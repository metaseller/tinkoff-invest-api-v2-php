<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: operations.proto

namespace Tinkoff\Invest\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.BrokerReportRequest</code>
 */
class BrokerReportRequest extends \Google\Protobuf\Internal\Message
{
    protected $payload;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Tinkoff\Invest\V1\GenerateBrokerReportRequest $generate_broker_report_request
     *     @type \Tinkoff\Invest\V1\GetBrokerReportRequest $get_broker_report_request
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Operations::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GenerateBrokerReportRequest generate_broker_report_request = 1;</code>
     * @return \Tinkoff\Invest\V1\GenerateBrokerReportRequest|null
     */
    public function getGenerateBrokerReportRequest()
    {
        return $this->readOneof(1);
    }

    public function hasGenerateBrokerReportRequest()
    {
        return $this->hasOneof(1);
    }

    /**
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GenerateBrokerReportRequest generate_broker_report_request = 1;</code>
     * @param \Tinkoff\Invest\V1\GenerateBrokerReportRequest $var
     * @return $this
     */
    public function setGenerateBrokerReportRequest($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\GenerateBrokerReportRequest::class);
        $this->writeOneof(1, $var);

        return $this;
    }

    /**
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetBrokerReportRequest get_broker_report_request = 2;</code>
     * @return \Tinkoff\Invest\V1\GetBrokerReportRequest|null
     */
    public function getGetBrokerReportRequest()
    {
        return $this->readOneof(2);
    }

    public function hasGetBrokerReportRequest()
    {
        return $this->hasOneof(2);
    }

    /**
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetBrokerReportRequest get_broker_report_request = 2;</code>
     * @param \Tinkoff\Invest\V1\GetBrokerReportRequest $var
     * @return $this
     */
    public function setGetBrokerReportRequest($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\GetBrokerReportRequest::class);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->whichOneof("payload");
    }

}

