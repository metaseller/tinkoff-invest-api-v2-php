<?php

namespace Metaseller\TinkoffInvestApi2\dto;

use Metaseller\TinkoffInvestApi2\helpers\NumbersHelper;
use Metaseller\TinkoffInvestApi2\helpers\QuotationHelper;
use Tinkoff\Invest\V1\Quotation;

/**
 * DTO, позволяющий работать с количеством в разных форматах
 *
 * @package Metaseller\TinkoffInvestApi2
 */
class Quantity
{
    /**
     * @var int Точность расчетов на стороне брокера. Количество знаков после запятой.
     */
    public const BROKER_PRECISION = 9;

    /**
     * @var int Точность расчетов на стороне брокера. Множитель.
     */
    public const BROKER_PRECISION_MULTIPLIER = 1000000000;

    /**
     * @var float Значение в формате числа с плавающей точкой
     */
    protected $_value_as_decimal;

    /**
     * @var int Целочисленное значение с учетом точности
     */
    protected $_value_as_integer;

    /**
     * @var Quotation Значение в формате {@link Quotation}
     */
    protected $_value_as_quotation;

    /**
     * Метод установки значения из числа с плавающей запятой
     *
     * @param float $value Значение в формате числа с плавающей запятой
     */
    public function setDecimalValue(float $value): void
    {
        $this->_value_as_decimal = round($value, static::BROKER_PRECISION);
        $this->_value_as_integer = intval(static::BROKER_PRECISION_MULTIPLIER * round($value, static::BROKER_PRECISION));
        $this->_value_as_quotation = QuotationHelper::toQuotation($value);
    }

    /**
     * Метод установки значения из числа в формате {@link Quotation}
     *
     * @param Quotation $value Значение в формате {@link Quotation}
     */
    public function setQuotationValue(Quotation $value): void
    {
        $this->_value_as_quotation = $value;

        $this->_value_as_integer = intval(static::BROKER_PRECISION_MULTIPLIER * ($value->getUnits() ?: 0) + ($value->getNano() ?: 0));
        $this->_value_as_decimal = round((float) $this->_value_as_integer / static::BROKER_PRECISION_MULTIPLIER, static::BROKER_PRECISION);
    }

    /**
     * Метод установки целочисленного значения с учетом точности
     *
     * Целочисленное значение с учетом точности - это значение в десятичном формате, умноженное на {@link Price::BROKER_PRECISION_MULTIPLIER} и
     * приведенное к целому числу
     *
     * @param int $value Целочисленное значение с учетом точности
     */
    public function setIntegerValue(int $value): void
    {
        $this->_value_as_integer = $value;
        $this->_value_as_decimal = round((float) $this->_value_as_integer / static::BROKER_PRECISION_MULTIPLIER, static::BROKER_PRECISION);

        $this->_value_as_quotation = QuotationHelper::toQuotation($this->_value_as_decimal);
    }

    /**
     * Представление значения в виде целочисленной значения с учетом точности
     *
     * @return int Целочисленное значение с учетом точности
     */
    public function asInteger(): int
    {
        return $this->_value_as_integer;
    }

    /**
     * Представление значения в виде числа с плавающей точкой
     *
     * @return float Значение в виде числа с плавающей точкой
     */
    public function asDecimal(): float
    {
        return $this->_value_as_decimal;
    }

    /**
     * Представление значения в формате {@link Quotation}
     *
     * @return Quotation Значение в формате {@link Quotation}
     */
    public function asQuotation(): Quotation
    {
        return $this->_value_as_quotation;
    }

    /**
     * Представление значения в виде строки с указанием валюты, если она не пустая
     *
     * @param int $display_precision Сколько точек после запятой оставлять
     *
     * @return string Значение в виде строки
     */
    public function asString(int $display_precision = 4): string
    {
        return NumbersHelper::printFloat($this->_value_as_decimal, $display_precision);
    }

    /**
     * Метод создания объекта класса из переданного значения в виде десятичного числа
     *
     * @param float $value Значение в виде десятичного числа
     *
     * @return Quantity Объект текущего класса
     */
    public static function createFromDecimal(float $value)
    {
        $quantity = new static();
        $quantity->setDecimalValue($value);

        return $quantity;
    }

    /**
     * Метод создания объекта класса на базе целочисленного значения с учетом точности
     *
     * @param int $value Целочисленное значение с учетом точности
     *
     * @return Quantity Объект текущего класса
     */
    public static function createFromInteger(int $value)
    {
        $quantity = new static();
        $quantity->setIntegerValue($value);

        return $quantity;
    }

    /**
     * Метод создания объекта класса из переданного значения в формате {@link Quotation}
     *
     * @param Quotation $value Значение в формате {@link Quotation}
     *
     * @return Quantity Объект текущего класса
     */
    public static function createFromQuotation(Quotation $value)
    {
        $quantity = new static();
        $quantity->setQuotationValue($value);

        return $quantity;
    }
}
