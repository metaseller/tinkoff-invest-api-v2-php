<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: instruments.proto

namespace Tinkoff\Invest\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.AssetFull</code>
 */
class AssetFull extends \Google\Protobuf\Internal\Message
{
    /**
     *Уникальный идентификатор актива.
     *
     * Generated from protobuf field <code>string uid = 1;</code>
     */
    protected $uid = '';
    /**
     *Тип актива.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.AssetType type = 2;</code>
     */
    protected $type = 0;
    /**
     *Наименование актива.
     *
     * Generated from protobuf field <code>string name = 3;</code>
     */
    protected $name = '';
    /**
     *Короткое наименование актива.
     *
     * Generated from protobuf field <code>string name_brief = 4;</code>
     */
    protected $name_brief = '';
    /**
     *Описание актива.
     *
     * Generated from protobuf field <code>string description = 5;</code>
     */
    protected $description = '';
    /**
     *Дата и время удаления актива.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp deleted_at = 6;</code>
     */
    protected $deleted_at = null;
    /**
     *Тестирование клиентов.
     *
     * Generated from protobuf field <code>repeated string required_tests = 7;</code>
     */
    private $required_tests;
    /**
     *Номер государственной регистрации.
     *
     * Generated from protobuf field <code>string gos_reg_code = 10;</code>
     */
    protected $gos_reg_code = '';
    /**
     *Код CFI.
     *
     * Generated from protobuf field <code>string cfi = 11;</code>
     */
    protected $cfi = '';
    /**
     *Код НРД инструмента.
     *
     * Generated from protobuf field <code>string code_nsd = 12;</code>
     */
    protected $code_nsd = '';
    /**
     *Статус актива.
     *
     * Generated from protobuf field <code>string status = 13;</code>
     */
    protected $status = '';
    /**
     *Бренд.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.Brand brand = 14;</code>
     */
    protected $brand = null;
    /**
     *Дата и время последнего обновления записи.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp updated_at = 15;</code>
     */
    protected $updated_at = null;
    /**
     *Код типа ц.б. по классификации Банка России.
     *
     * Generated from protobuf field <code>string br_code = 16;</code>
     */
    protected $br_code = '';
    /**
     *Наименование кода типа ц.б. по классификации Банка России.
     *
     * Generated from protobuf field <code>string br_code_name = 17;</code>
     */
    protected $br_code_name = '';
    /**
     *Массив идентификаторов инструментов.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.AssetInstrument instruments = 18;</code>
     */
    private $instruments;
    protected $ext;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $uid
     *          Уникальный идентификатор актива.
     *     @type int $type
     *          Тип актива.
     *     @type string $name
     *          Наименование актива.
     *     @type string $name_brief
     *          Короткое наименование актива.
     *     @type string $description
     *          Описание актива.
     *     @type \Google\Protobuf\Timestamp $deleted_at
     *          Дата и время удаления актива.
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $required_tests
     *          Тестирование клиентов.
     *     @type \Tinkoff\Invest\V1\AssetCurrency $currency
     *          Валюта. Обязательно и заполняется только для `type = ASSET_TYPE_CURRENCY`.
     *     @type \Tinkoff\Invest\V1\AssetSecurity $security
     *          Ценная бумага. Обязательно и заполняется только для `type = ASSET_TYPE_SECURITY`.
     *     @type string $gos_reg_code
     *          Номер государственной регистрации.
     *     @type string $cfi
     *          Код CFI.
     *     @type string $code_nsd
     *          Код НРД инструмента.
     *     @type string $status
     *          Статус актива.
     *     @type \Tinkoff\Invest\V1\Brand $brand
     *          Бренд.
     *     @type \Google\Protobuf\Timestamp $updated_at
     *          Дата и время последнего обновления записи.
     *     @type string $br_code
     *          Код типа ц.б. по классификации Банка России.
     *     @type string $br_code_name
     *          Наименование кода типа ц.б. по классификации Банка России.
     *     @type \Tinkoff\Invest\V1\AssetInstrument[]|\Google\Protobuf\Internal\RepeatedField $instruments
     *          Массив идентификаторов инструментов.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Instruments::initOnce();
        parent::__construct($data);
    }

    /**
     *Уникальный идентификатор актива.
     *
     * Generated from protobuf field <code>string uid = 1;</code>
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     *Уникальный идентификатор актива.
     *
     * Generated from protobuf field <code>string uid = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setUid($var)
    {
        GPBUtil::checkString($var, True);
        $this->uid = $var;

        return $this;
    }

    /**
     *Тип актива.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.AssetType type = 2;</code>
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *Тип актива.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.AssetType type = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkEnum($var, \Tinkoff\Invest\V1\AssetType::class);
        $this->type = $var;

        return $this;
    }

    /**
     *Наименование актива.
     *
     * Generated from protobuf field <code>string name = 3;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *Наименование актива.
     *
     * Generated from protobuf field <code>string name = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     *Короткое наименование актива.
     *
     * Generated from protobuf field <code>string name_brief = 4;</code>
     * @return string
     */
    public function getNameBrief()
    {
        return $this->name_brief;
    }

    /**
     *Короткое наименование актива.
     *
     * Generated from protobuf field <code>string name_brief = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setNameBrief($var)
    {
        GPBUtil::checkString($var, True);
        $this->name_brief = $var;

        return $this;
    }

    /**
     *Описание актива.
     *
     * Generated from protobuf field <code>string description = 5;</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *Описание актива.
     *
     * Generated from protobuf field <code>string description = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->description = $var;

        return $this;
    }

    /**
     *Дата и время удаления актива.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp deleted_at = 6;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getDeletedAt()
    {
        return isset($this->deleted_at) ? $this->deleted_at : null;
    }

    public function hasDeletedAt()
    {
        return isset($this->deleted_at);
    }

    public function clearDeletedAt()
    {
        unset($this->deleted_at);
    }

    /**
     *Дата и время удаления актива.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp deleted_at = 6;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setDeletedAt($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->deleted_at = $var;

        return $this;
    }

    /**
     *Тестирование клиентов.
     *
     * Generated from protobuf field <code>repeated string required_tests = 7;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getRequiredTests()
    {
        return $this->required_tests;
    }

    /**
     *Тестирование клиентов.
     *
     * Generated from protobuf field <code>repeated string required_tests = 7;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setRequiredTests($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->required_tests = $arr;

        return $this;
    }

    /**
     *Валюта. Обязательно и заполняется только для `type = ASSET_TYPE_CURRENCY`.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.AssetCurrency currency = 8;</code>
     * @return \Tinkoff\Invest\V1\AssetCurrency|null
     */
    public function getCurrency()
    {
        return $this->readOneof(8);
    }

    public function hasCurrency()
    {
        return $this->hasOneof(8);
    }

    /**
     *Валюта. Обязательно и заполняется только для `type = ASSET_TYPE_CURRENCY`.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.AssetCurrency currency = 8;</code>
     * @param \Tinkoff\Invest\V1\AssetCurrency $var
     * @return $this
     */
    public function setCurrency($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\AssetCurrency::class);
        $this->writeOneof(8, $var);

        return $this;
    }

    /**
     *Ценная бумага. Обязательно и заполняется только для `type = ASSET_TYPE_SECURITY`.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.AssetSecurity security = 9;</code>
     * @return \Tinkoff\Invest\V1\AssetSecurity|null
     */
    public function getSecurity()
    {
        return $this->readOneof(9);
    }

    public function hasSecurity()
    {
        return $this->hasOneof(9);
    }

    /**
     *Ценная бумага. Обязательно и заполняется только для `type = ASSET_TYPE_SECURITY`.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.AssetSecurity security = 9;</code>
     * @param \Tinkoff\Invest\V1\AssetSecurity $var
     * @return $this
     */
    public function setSecurity($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\AssetSecurity::class);
        $this->writeOneof(9, $var);

        return $this;
    }

    /**
     *Номер государственной регистрации.
     *
     * Generated from protobuf field <code>string gos_reg_code = 10;</code>
     * @return string
     */
    public function getGosRegCode()
    {
        return $this->gos_reg_code;
    }

    /**
     *Номер государственной регистрации.
     *
     * Generated from protobuf field <code>string gos_reg_code = 10;</code>
     * @param string $var
     * @return $this
     */
    public function setGosRegCode($var)
    {
        GPBUtil::checkString($var, True);
        $this->gos_reg_code = $var;

        return $this;
    }

    /**
     *Код CFI.
     *
     * Generated from protobuf field <code>string cfi = 11;</code>
     * @return string
     */
    public function getCfi()
    {
        return $this->cfi;
    }

    /**
     *Код CFI.
     *
     * Generated from protobuf field <code>string cfi = 11;</code>
     * @param string $var
     * @return $this
     */
    public function setCfi($var)
    {
        GPBUtil::checkString($var, True);
        $this->cfi = $var;

        return $this;
    }

    /**
     *Код НРД инструмента.
     *
     * Generated from protobuf field <code>string code_nsd = 12;</code>
     * @return string
     */
    public function getCodeNsd()
    {
        return $this->code_nsd;
    }

    /**
     *Код НРД инструмента.
     *
     * Generated from protobuf field <code>string code_nsd = 12;</code>
     * @param string $var
     * @return $this
     */
    public function setCodeNsd($var)
    {
        GPBUtil::checkString($var, True);
        $this->code_nsd = $var;

        return $this;
    }

    /**
     *Статус актива.
     *
     * Generated from protobuf field <code>string status = 13;</code>
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *Статус актива.
     *
     * Generated from protobuf field <code>string status = 13;</code>
     * @param string $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkString($var, True);
        $this->status = $var;

        return $this;
    }

    /**
     *Бренд.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.Brand brand = 14;</code>
     * @return \Tinkoff\Invest\V1\Brand|null
     */
    public function getBrand()
    {
        return isset($this->brand) ? $this->brand : null;
    }

    public function hasBrand()
    {
        return isset($this->brand);
    }

    public function clearBrand()
    {
        unset($this->brand);
    }

    /**
     *Бренд.
     *
     * Generated from protobuf field <code>.tinkoff.public.invest.api.contract.v1.Brand brand = 14;</code>
     * @param \Tinkoff\Invest\V1\Brand $var
     * @return $this
     */
    public function setBrand($var)
    {
        GPBUtil::checkMessage($var, \Tinkoff\Invest\V1\Brand::class);
        $this->brand = $var;

        return $this;
    }

    /**
     *Дата и время последнего обновления записи.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp updated_at = 15;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getUpdatedAt()
    {
        return isset($this->updated_at) ? $this->updated_at : null;
    }

    public function hasUpdatedAt()
    {
        return isset($this->updated_at);
    }

    public function clearUpdatedAt()
    {
        unset($this->updated_at);
    }

    /**
     *Дата и время последнего обновления записи.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp updated_at = 15;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setUpdatedAt($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->updated_at = $var;

        return $this;
    }

    /**
     *Код типа ц.б. по классификации Банка России.
     *
     * Generated from protobuf field <code>string br_code = 16;</code>
     * @return string
     */
    public function getBrCode()
    {
        return $this->br_code;
    }

    /**
     *Код типа ц.б. по классификации Банка России.
     *
     * Generated from protobuf field <code>string br_code = 16;</code>
     * @param string $var
     * @return $this
     */
    public function setBrCode($var)
    {
        GPBUtil::checkString($var, True);
        $this->br_code = $var;

        return $this;
    }

    /**
     *Наименование кода типа ц.б. по классификации Банка России.
     *
     * Generated from protobuf field <code>string br_code_name = 17;</code>
     * @return string
     */
    public function getBrCodeName()
    {
        return $this->br_code_name;
    }

    /**
     *Наименование кода типа ц.б. по классификации Банка России.
     *
     * Generated from protobuf field <code>string br_code_name = 17;</code>
     * @param string $var
     * @return $this
     */
    public function setBrCodeName($var)
    {
        GPBUtil::checkString($var, True);
        $this->br_code_name = $var;

        return $this;
    }

    /**
     *Массив идентификаторов инструментов.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.AssetInstrument instruments = 18;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getInstruments()
    {
        return $this->instruments;
    }

    /**
     *Массив идентификаторов инструментов.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.AssetInstrument instruments = 18;</code>
     * @param \Tinkoff\Invest\V1\AssetInstrument[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setInstruments($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Tinkoff\Invest\V1\AssetInstrument::class);
        $this->instruments = $arr;

        return $this;
    }

    /**
     * @return string
     */
    public function getExt()
    {
        return $this->whichOneof("ext");
    }

}

