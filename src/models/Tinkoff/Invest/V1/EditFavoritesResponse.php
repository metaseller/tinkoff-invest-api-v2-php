<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: instruments.proto

namespace Tinkoff\Invest\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *Результат редактирования списка избранных инструментов.
 *
 * Generated from protobuf message <code>tinkoff.public.invest.api.contract.v1.EditFavoritesResponse</code>
 */
class EditFavoritesResponse extends \Google\Protobuf\Internal\Message
{
    /**
     *Массив инструментов.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.FavoriteInstrument favorite_instruments = 1;</code>
     */
    private $favorite_instruments;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Tinkoff\Invest\V1\FavoriteInstrument[]|\Google\Protobuf\Internal\RepeatedField $favorite_instruments
     *          Массив инструментов.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Instruments::initOnce();
        parent::__construct($data);
    }

    /**
     *Массив инструментов.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.FavoriteInstrument favorite_instruments = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getFavoriteInstruments()
    {
        return $this->favorite_instruments;
    }

    /**
     *Массив инструментов.
     *
     * Generated from protobuf field <code>repeated .tinkoff.public.invest.api.contract.v1.FavoriteInstrument favorite_instruments = 1;</code>
     * @param \Tinkoff\Invest\V1\FavoriteInstrument[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setFavoriteInstruments($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Tinkoff\Invest\V1\FavoriteInstrument::class);
        $this->favorite_instruments = $arr;

        return $this;
    }

}

