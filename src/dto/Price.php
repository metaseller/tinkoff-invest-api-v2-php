<?php

namespace Metaseller\TinkoffInvestApi2\dto;

use Metaseller\TinkoffInvestApi2\helpers\NumbersHelper;
use Tinkoff\Invest\V1\MoneyValue;
use Tinkoff\Invest\V1\Quotation;

/**
 * DTO, позволяющий работать со стоимостью в разных форматах
 *
 * @package Metaseller\TinkoffInvestApi2
 */
class Price extends Quantity
{
    /**
     * @var string|null Строковый ISO-код валюты
     *
     * @see MoneyValue::$currency
     */
    protected $_currency;

    /**
     * Метод установки цены из числа с плавающей запятой
     *
     * @param float $value Цена в формате числа с плавающей запятой
     * @param string|null $currency Строковый ISO-код валюты
     */
    public function setDecimalValue(float $value, string $currency = null): void
    {
        parent::setDecimalValue($value);

        $this->_currency = $currency;
    }

    /**
     * Метод установки цены из числа в формате {@link Quotation}
     *
     * @param Quotation $value Цена в формате {@link Quotation}
     * @param string|null $currency Строковый ISO-код валюты
     */
    public function setQuotationValue(Quotation $value, string $currency = null): void
    {
        parent::setQuotationValue($value);

        $this->_currency = $currency;
    }

    /**
     * Метод установки цены из числа в формате {@link MoneyValue}
     *
     * @param MoneyValue $value Цена в формате {@link MoneyValue}
     */
    public function setMoneyValuePrice(MoneyValue $value): void
    {
        $this->_value_as_quotation = new Quotation();

        $this->_value_as_quotation->setUnits($value->getUnits() ?: 0);
        $this->_value_as_quotation->setNano($value->getNano() ?: 0);

        $this->_value_as_integer = intval(static::BROKER_PRECISION_MULTIPLIER * ($value->getUnits() ?: 0) + ($value->getNano() ?: 0));
        $this->_value_as_decimal = round((float) $this->_value_as_integer / static::BROKER_PRECISION_MULTIPLIER, static::BROKER_PRECISION);

        $this->_currency = $value->getCurrency();
    }

    /**
     * Метод установки целочисленной цены с учетом точности
     *
     * Целочисленная цена с учетом точности - это цена в десятичном формате умноженная на {@link Quantity::BROKER_PRECISION_MULTIPLIER} и
     * приведенная к целому числу
     *
     * @param int $value Целочисленная цена с учетом точности
     */
    public function setIntegerPrice(int $value, string $currency = null): void
    {
        parent::setIntegerValue($value);

        $this->_currency = $currency;
    }

    /**
     * Представление цены в формате {@link MoneyValue}
     *
     * @return MoneyValue Цена в формате {@link MoneyValue}
     */
    public function asMoneyValue(): MoneyValue
    {
        $value_as_money_value = new MoneyValue();

        $value_as_money_value->setCurrency($this->_currency);
        $value_as_money_value->setUnits($this->_value_as_quotation->getUnits() ?: 0);
        $value_as_money_value->setNano($this->_value_as_quotation->getNano() ?: 0);

        return $value_as_money_value;
    }

    /**
     * Представление цены в виде строки с указанием валюты, если она не пустая
     *
     * @param int $display_precision Сколько точек после запятой оставлять
     *
     * @return string Цена в виде строки
     */
    public function asString(int $display_precision = 4): string
    {
        return NumbersHelper::printFloat($this->_value_as_decimal, $display_precision) . (!empty($this->_currency) ? ' ' . $this->_currency : '');
    }

    /**
     * Метод создания объекта класса на базе цены в виде десятичного числа
     *
     * @param float $value Цена в виде десятичного числа
     * @param string|null $currency Строковый ISO-код валюты
     *
     * @return Price Объект текущего класса
     */
    public static function createFromDecimal(float $value, string $currency = null)
    {
        $price = new static();
        $price->setDecimalValue($value, $currency);

        return $price;
    }

    /**
     * Метод создания объекта класса на базе целочисленной цены с учетом точности
     *
     * @param int $value Целочисленная цена с учетом точности
     * @param string|null $currency Строковый ISO-код валюты
     *
     * @return Price Объект текущего класса
     */
    public static function createFromInteger(int $value, string $currency = null)
    {
        $price = new static();
        $price->setIntegerPrice($value, $currency);

        return $price;
    }

    /**
     * Метод создания объекта класса на базе цены в формате {@link Quotation}
     *
     * @param Quotation $value Цена в формате {@link Quotation}
     * @param string|null $currency Строковый ISO-код валюты
     *
     * @return Price Объект текущего класса
     */
    public static function createFromQuotation(Quotation $value, string $currency = null)
    {
        $price = new static();
        $price->setQuotationValue($value, $currency);

        return $price;
    }

    /**
     * Метод создания объекта класса на базе цены в формате {@link MoneyValue}
     *
     * @param MoneyValue $value Цена в формате {@link MoneyValue}
     *
     * @return Price Объект текущего класса
     */
    public static function createFromMoneyValue(MoneyValue $value)
    {
        $price = new static();
        $price->setMoneyValuePrice($value);

        return $price;
    }
}
