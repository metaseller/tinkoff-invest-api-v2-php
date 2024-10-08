<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: instruments.proto

namespace Tinkoff\Invest\V1\GetAssetReportsResponse;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *Отчет
 *
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.GetAssetReportsResponse.GetAssetReportsEvent</code>
 */
class GetAssetReportsEvent extends \Google\Protobuf\Internal\Message
{
    /**
     * Идентификатор инструмента.
     *
     * Generated from protobuf field <code>string instrument_id = 1;</code>
     */
    protected $instrument_id = '';
    /**
     * Дата публикации отчёта.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp report_date = 2;</code>
     */
    protected $report_date = null;
    /**
     * Год периода отчета.
     *
     * Generated from protobuf field <code>int32 period_year = 3;</code>
     */
    protected $period_year = 0;
    /**
     * Номер периода.
     *
     * Generated from protobuf field <code>int32 period_num = 4;</code>
     */
    protected $period_num = 0;
    /**
     * Тип отчёта.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetAssetReportsResponse.AssetReportPeriodType period_type = 5;</code>
     */
    protected $period_type = 0;
    /**
     * Дата создания записи.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp created_at = 6;</code>
     */
    protected $created_at = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $instrument_id
     *           Идентификатор инструмента.
     *     @type \Google\Protobuf\Timestamp $report_date
     *           Дата публикации отчёта.
     *     @type int $period_year
     *           Год периода отчета.
     *     @type int $period_num
     *           Номер периода.
     *     @type int $period_type
     *           Тип отчёта.
     *     @type \Google\Protobuf\Timestamp $created_at
     *           Дата создания записи.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Instruments::initOnce();
        parent::__construct($data);
    }

    /**
     * Идентификатор инструмента.
     *
     * Generated from protobuf field <code>string instrument_id = 1;</code>
     * @return string
     */
    public function getInstrumentId()
    {
        return $this->instrument_id;
    }

    /**
     * Идентификатор инструмента.
     *
     * Generated from protobuf field <code>string instrument_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setInstrumentId($var)
    {
        GPBUtil::checkString($var, True);
        $this->instrument_id = $var;

        return $this;
    }

    /**
     * Дата публикации отчёта.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp report_date = 2;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getReportDate()
    {
        return isset($this->report_date) ? $this->report_date : null;
    }

    public function hasReportDate()
    {
        return isset($this->report_date);
    }

    public function clearReportDate()
    {
        unset($this->report_date);
    }

    /**
     * Дата публикации отчёта.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp report_date = 2;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setReportDate($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->report_date = $var;

        return $this;
    }

    /**
     * Год периода отчета.
     *
     * Generated from protobuf field <code>int32 period_year = 3;</code>
     * @return int
     */
    public function getPeriodYear()
    {
        return $this->period_year;
    }

    /**
     * Год периода отчета.
     *
     * Generated from protobuf field <code>int32 period_year = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setPeriodYear($var)
    {
        GPBUtil::checkInt32($var);
        $this->period_year = $var;

        return $this;
    }

    /**
     * Номер периода.
     *
     * Generated from protobuf field <code>int32 period_num = 4;</code>
     * @return int
     */
    public function getPeriodNum()
    {
        return $this->period_num;
    }

    /**
     * Номер периода.
     *
     * Generated from protobuf field <code>int32 period_num = 4;</code>
     * @param int $var
     * @return $this
     */
    public function setPeriodNum($var)
    {
        GPBUtil::checkInt32($var);
        $this->period_num = $var;

        return $this;
    }

    /**
     * Тип отчёта.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetAssetReportsResponse.AssetReportPeriodType period_type = 5;</code>
     * @return int
     */
    public function getPeriodType()
    {
        return $this->period_type;
    }

    /**
     * Тип отчёта.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.GetAssetReportsResponse.AssetReportPeriodType period_type = 5;</code>
     * @param int $var
     * @return $this
     */
    public function setPeriodType($var)
    {
        GPBUtil::checkEnum($var, \Tinkoff\Invest\V1\GetAssetReportsResponse\AssetReportPeriodType::class);
        $this->period_type = $var;

        return $this;
    }

    /**
     * Дата создания записи.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp created_at = 6;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getCreatedAt()
    {
        return isset($this->created_at) ? $this->created_at : null;
    }

    public function hasCreatedAt()
    {
        return isset($this->created_at);
    }

    public function clearCreatedAt()
    {
        unset($this->created_at);
    }

    /**
     * Дата создания записи.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp created_at = 6;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setCreatedAt($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->created_at = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GetAssetReportsEvent::class, \Tinkoff\Invest\V1\GetAssetReportsResponse_GetAssetReportsEvent::class);

