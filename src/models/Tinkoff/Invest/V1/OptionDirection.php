<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: instruments.proto

namespace Tinkoff\Invest\V1;

use UnexpectedValueException;

/**
 *Тип опциона по направлению сделки.
 *
 * Protobuf type <code>tinkoff.public.invest.api.contract.v1.OptionDirection</code>
 */
class OptionDirection
{
    /**
     *Тип не определён.
     *
     * Generated from protobuf enum <code>OPTION_DIRECTION_UNSPECIFIED = 0;</code>
     */
    const OPTION_DIRECTION_UNSPECIFIED = 0;
    /**
     *Опцион на продажу.
     *
     * Generated from protobuf enum <code>OPTION_DIRECTION_PUT = 1;</code>
     */
    const OPTION_DIRECTION_PUT = 1;
    /**
     *Опцион на покупку.
     *
     * Generated from protobuf enum <code>OPTION_DIRECTION_CALL = 2;</code>
     */
    const OPTION_DIRECTION_CALL = 2;

    private static $valueToName = [
        self::OPTION_DIRECTION_UNSPECIFIED => 'OPTION_DIRECTION_UNSPECIFIED',
        self::OPTION_DIRECTION_PUT => 'OPTION_DIRECTION_PUT',
        self::OPTION_DIRECTION_CALL => 'OPTION_DIRECTION_CALL',
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

