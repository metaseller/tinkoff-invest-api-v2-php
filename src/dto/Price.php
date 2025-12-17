<?php

namespace Metaseller\TinkoffInvestApi2\dto;

use Metaseller\TinkoffInvestApi2\helpers\NumbersHelper;
use Metaseller\TinkoffInvestApi2\helpers\QuotationHelper;
use Tinkoff\Invest\V1\MoneyValue;
use Tinkoff\Invest\V1\Quotation;

/**
 * DTO, позволяющий работать со стоимостью в разных форматах
 *
 * @package Metaseller\TinkoffInvestApi2
 */
class Price
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
     * @var float Цена в формате числа с плавающей точкой
     */
    protected $_price_as_decimal;

    /**
     * @var int Целочисленная цена с учетом точности
     */
    protected $_price_as_integer;

    /**
     * @var Quotation Цена в формате {@link Quotation}
     */
    protected $_price_as_quotation;

    /**
     * @var string|null Строковый ISO-код валюты
     *
     * @see MoneyValue::$currency
     */
    protected $_currency;

    /**
     * Метод установки цены из числа с плавающей запятой
     *
     * @param float $price Цена в формате числа с плавающей запятой
     * @param string|null $currency Строковый ISO-код валюты
     */
    public function setDecimalPrice(float $price, string $currency = null): void
    {
        $this->_price_as_decimal = round($price, static::BROKER_PRECISION);
        $this->_price_as_integer = intval(static::BROKER_PRECISION_MULTIPLIER * round($price, static::BROKER_PRECISION));
        $this->_price_as_quotation = QuotationHelper::toQuotation($price);

        $this->_currency = $currency;
    }

    /**
     * Метод установки цены из числа в формате {@link Quotation}
     *
     * @param Quotation $price Цена в формате {@link Quotation}
     * @param string|null $currency Строковый ISO-код валюты
     */
    public function setQuotationPrice(Quotation $price, string $currency = null): void
    {
        $this->_price_as_quotation = $price;

        $this->_price_as_integer = intval(static::BROKER_PRECISION_MULTIPLIER * ($price->getUnits() ?: 0) + ($price->getNano() ?: 0));
        $this->_price_as_decimal = round((float) $this->_price_as_integer / static::BROKER_PRECISION_MULTIPLIER, static::BROKER_PRECISION);

        $this->_currency = $currency;
    }

    /**
     * Метод установки цены из числа в формате {@link MoneyValue}
     *
     * @param MoneyValue $price Цена в формате {@link MoneyValue}
     */
    public function setMoneyValuePrice(MoneyValue $price): void
    {
        $this->_price_as_quotation = new Quotation();
        $this->_price_as_quotation->setUnits($price->getUnits() ?: 0);
        $this->_price_as_quotation->setNano($price->getNano() ?: 0);

        $this->_price_as_integer = intval(static::BROKER_PRECISION_MULTIPLIER * ($price->getUnits() ?: 0) + ($price->getNano() ?: 0));
        $this->_price_as_decimal = round((float) $this->_price_as_integer / static::BROKER_PRECISION_MULTIPLIER, static::BROKER_PRECISION);

        $this->_currency = $price->getCurrency();
    }

    /**
     * Метод установки целочисленной цены с учетом точности
     *
     * Целочисленная цена с учетом точности - это цена в десятичном формате умноженная на {@link Price::BROKER_PRECISION_MULTIPLIER} и
     * приведенная к целому числу
     *
     * @param int $price Целочисленная цена с учетом точности
     */
    public function setIntegerPrice(int $price, string $currency = null): void
    {
        $this->_price_as_integer = $price;
        $this->_price_as_decimal = round((float) $this->_price_as_integer / static::BROKER_PRECISION_MULTIPLIER, static::BROKER_PRECISION);

        $this->_price_as_quotation = QuotationHelper::toQuotation($this->_price_as_decimal);

        $this->_currency = $currency;
    }

    /**
     * Представление цены в виде целочисленной цены с учетом точности
     *
     * @return int Целочисленная цена с учетом точности
     */
    public function asInteger(): int
    {
        return $this->_price_as_integer;
    }

    /**
     * Представление цены в виде числа с плавающей точкой
     *
     * @return float Цена в виде числа с плавающей точкой
     */
    public function asDecimal(): float
    {
        return $this->_price_as_decimal;
    }

    /**
     * Представление цены в формате {@link Quotation}
     *
     * @return Quotation Цена в формате {@link Quotation}
     */
    public function asQuotation(): Quotation
    {
        return $this->_price_as_quotation;
    }

    /**
     * Представление цены в формате {@link MoneyValue}
     *
     * @return MoneyValue Цена в формате {@link MoneyValue}
     */
    public function asMoneyValue(): MoneyValue
    {
        $price_as_money_value = new MoneyValue();

        $price_as_money_value->setCurrency($this->_currency);
        $price_as_money_value->setUnits($this->_price_as_quotation->getUnits() ?: 0);
        $price_as_money_value->setNano($this->_price_as_quotation->getNano() ?: 0);

        return $price_as_money_value;
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
        return NumbersHelper::printFloat($this->_price_as_decimal, $display_precision) . (!empty($this->_currency) ? ' ' . $this->_currency : '');
    }

    /**
     * Метод создания объекта класса на базе цены в виде десятичного числа
     *
     * @param float $source_price Цена в виде десятичного числа
     * @param string|null $currency Строковый ISO-код валюты
     *
     * @return static Объект текущего класса
     */
    public static function createFromDecimal(float $source_price, string $currency = null): self
    {
        $price = new static();
        $price->setDecimalPrice($source_price, $currency);

        return $price;
    }

    /**
     * Метод создания объекта класса на базе целочисленной цены с учетом точности
     *
     * @param int $source_price Целочисленная цена с учетом точности
     * @param string|null $currency Строковый ISO-код валюты
     *
     * @return static Объект текущего класса
     */
    public static function createFromInteger(int $source_price, string $currency = null): self
    {
        $price = new static();
        $price->setIntegerPrice($source_price, $currency);

        return $price;
    }

    /**
     * Метод создания объекта класса на базе цены в формате {@link Quotation}
     *
     * @param Quotation $source_price Цена в формате {@link Quotation}
     * @param string|null $currency Строковый ISO-код валюты
     *
     * @return static Объект текущего класса
     */
    public static function createFromQuotation(Quotation $source_price, string $currency = null): self
    {
        $price = new static();
        $price->setQuotationPrice($source_price, $currency);

        return $price;
    }

    /**
     * Метод создания объекта класса на базе цены в формате {@link MoneyValue}
     *
     * @param MoneyValue $source_price Цена в формате {@link MoneyValue}
     *
     * @return static Объект текущего класса
     */
    public static function createFromMoneyValue(MoneyValue $source_price): self
    {
        $price = new static();
        $price->setMoneyValuePrice($source_price);

        return $price;
    }
}
