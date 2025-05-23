<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: instruments.proto

namespace Tinkoff\Invest\V1;

use UnexpectedValueException;

/**
 *Тип купонов.
 *
 * Protobuf type <code>tinkoff.public.invest.api.contract.v1.CouponType</code>
 */
class CouponType
{
    /**
     *Неопределенное значение.
     *
     * Generated from protobuf enum <code>COUPON_TYPE_UNSPECIFIED = 0;</code>
     */
    const COUPON_TYPE_UNSPECIFIED = 0;
    /**
     *Постоянный.
     *
     * Generated from protobuf enum <code>COUPON_TYPE_CONSTANT = 1;</code>
     */
    const COUPON_TYPE_CONSTANT = 1;
    /**
     *Плавающий.
     *
     * Generated from protobuf enum <code>COUPON_TYPE_FLOATING = 2;</code>
     */
    const COUPON_TYPE_FLOATING = 2;
    /**
     *Дисконт.
     *
     * Generated from protobuf enum <code>COUPON_TYPE_DISCOUNT = 3;</code>
     */
    const COUPON_TYPE_DISCOUNT = 3;
    /**
     *Ипотечный.
     *
     * Generated from protobuf enum <code>COUPON_TYPE_MORTGAGE = 4;</code>
     */
    const COUPON_TYPE_MORTGAGE = 4;
    /**
     *Фиксированный.
     *
     * Generated from protobuf enum <code>COUPON_TYPE_FIX = 5;</code>
     */
    const COUPON_TYPE_FIX = 5;
    /**
     *Переменный.
     *
     * Generated from protobuf enum <code>COUPON_TYPE_VARIABLE = 6;</code>
     */
    const COUPON_TYPE_VARIABLE = 6;
    /**
     *Прочее.
     *
     * Generated from protobuf enum <code>COUPON_TYPE_OTHER = 7;</code>
     */
    const COUPON_TYPE_OTHER = 7;

    private static $valueToName = [
        self::COUPON_TYPE_UNSPECIFIED => 'COUPON_TYPE_UNSPECIFIED',
        self::COUPON_TYPE_CONSTANT => 'COUPON_TYPE_CONSTANT',
        self::COUPON_TYPE_FLOATING => 'COUPON_TYPE_FLOATING',
        self::COUPON_TYPE_DISCOUNT => 'COUPON_TYPE_DISCOUNT',
        self::COUPON_TYPE_MORTGAGE => 'COUPON_TYPE_MORTGAGE',
        self::COUPON_TYPE_FIX => 'COUPON_TYPE_FIX',
        self::COUPON_TYPE_VARIABLE => 'COUPON_TYPE_VARIABLE',
        self::COUPON_TYPE_OTHER => 'COUPON_TYPE_OTHER',
    ];

    public static function name($value)
    {
        if (!isset(self::$valueToName[$value])) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no name defined for value %s', __CLASS__, $value));
        }
        return self::$valueToName[$value];
    }


    public static function value($name)
    {
        $const = __CLASS__ . '::' . strtoupper($name);
        if (!defined($const)) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no value defined for name %s', __CLASS__, $name));
        }
        return constant($const);
    }
}

