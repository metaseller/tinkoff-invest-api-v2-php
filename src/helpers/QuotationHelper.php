<?php

namespace Metaseller\TinkoffInvestApi2\helpers;

use Metaseller\TinkoffInvestApi2\exceptions\ValidateException;
use Tinkoff\Invest\V1\Bond;
use Tinkoff\Invest\V1\Currency;
use Tinkoff\Invest\V1\Etf;
use Tinkoff\Invest\V1\Future;
use Tinkoff\Invest\V1\GetFuturesMarginResponse;
use Tinkoff\Invest\V1\Instrument;
use Tinkoff\Invest\V1\MoneyValue;
use Tinkoff\Invest\V1\Quotation;
use Tinkoff\Invest\V1\Share;

/**
 * Хелпер для работы с представлением котировок, количеств, стоимостей в Tinkoff Invest API v2
 *
 * @package Metaseller\TinkoffInvestApi2
 */
class QuotationHelper
{
    /**
     * Метод проверяет корректность значения цены для переданного инструмента
     *
     * @param float|Quotation|MoneyValue $price Цена
     *
     * @param Instrument|Share|Bond|Currency|Etf|Future $instrument Инструмент
     *
     * @return bool Признак, является ли корректным значение цены для переданного инструмента
     *
     * @throws ValidateException
     */
    public static function isPriceValid($price, $instrument): bool
    {
        if (!static::isInstrumentModelValid($instrument)) {
            throw new ValidateException('Instrument model is not valid');
        }

        $min_price_increment = $instrument->getMinPriceIncrement();

        if (!$min_price_increment) {
            throw new ValidateException('Instrument min price increment value is not available');
        }

        $precision = pow(10,9);

        return ($precision * static::toDecimal($price)) % ($precision * static::toDecimal($min_price_increment)) == 0;
    }

    /**
     * Преобразование котировки ценной бумаги в число с плавающей запятой, без учета типа инструмента
     *
     * В логике API, если вы хотите получить стоимость позиции в валюте - вам необходимо использовать метод {@link QuotationHelper::toCurrency}
     *
     * @param float|Quotation|MoneyValue $price Котировка ценной бумаги
     *
     * @return float Котировка в виде числа с плавающей запятой
     *
     * @throws ValidateException
     */
    public static function toDecimal($price): float
    {
        if (($price instanceof Quotation) || ($price instanceof MoneyValue)) {
            return ($price->getUnits() ?: 0) + ($price->getNano() ?: 0) / pow(10, 9);
        }

        if (is_numeric($price)) {
            return (float) $price;
        }

        throw new ValidateException('Price is not valid');
    }

    /**
     * Преобразование котировки ценной бумаги в стоимость в валюте в виде числа с плавающей запятой
     *
     * @param float|Quotation|MoneyValue $price Текущая котировка ценной бумаги
     * @param Instrument|Share|Bond|Currency|Etf|Future $instrument Инструмент ценной бумаги
     * @param GetFuturesMarginResponse|null $futures_data Данные по фьючерсу. По умолчанию равно <code>null</code>. Обязательно для инструмента типа фьючерс, для иных инструментов не используется
     *
     *
     * @return float Стоимость в валюте в виде числа с плавающей запятой
     *
     * @throws ValidateException
     *
     * @see https://tinkoff.github.io/investAPI/faq/#_6
     */
    public static function toCurrency($price, $instrument, GetFuturesMarginResponse $futures_data = null): float
    {
        if (!static::isInstrumentModelValid($instrument)) {
            throw new ValidateException('Instrument model is not valid');
        }

        if ($instrument instanceof Instrument) {
            if ($instrument->getInstrumentType() === 'bond') {
                throw new ValidateException('Impossible to obtain bond nominal value. Please use Bond model instead of Instrument');
            }
        }

        $decimal_price = static::toDecimal($price);

        if ($instrument instanceof Bond) {
            if (!$nominal = $instrument->getNominal()) {
                throw new ValidateException('Bond nominal is not valid');
            }

            return ($decimal_price / 100) * static::toDecimal($nominal);
        }

        if ($instrument instanceof Future || (($instrument instanceof Instrument) && $instrument->getInstrumentType() === 'futures')) {
            if (empty($futures_data)) {
                throw new ValidateException('Futures data required for this instrument');
            }

            if (!$min_price_increment = $futures_data->getMinPriceIncrement()) {
                throw new ValidateException('Futures min price increment is not available');
            }

            if (!$min_price_increment_amount = $futures_data->getMinPriceIncrementAmount()) {
                throw new ValidateException('Futures min price increment amount is not available');
            }


            return ($decimal_price / static::toDecimal($min_price_increment)) * static::toDecimal($min_price_increment_amount);
        }

        return $decimal_price;
    }

    /**
     * Преобразование числа с плавающей запятой, без учета типа инструмента в {@link Quotation}
     *
     * @param float $price Число с плавающей запятой
     *
     * @return Quotation Значение типа {@link Quotation}
     */
    public static function toQuotation(float $price): Quotation
    {
        $quotation = new Quotation();

        $units = (int) floor($price);
        $nano = (int) ($price * pow(10, 9)) - (int) ($units * pow(10, 9));

        $quotation->setUnits($units);
        $quotation->setNano($nano);

        return $quotation;
    }

    /**
     * Проверяет модель данных инструмента
     *
     * @param mixed $instrument Модель
     *
     * @return bool Является ли инструмент валидным торговым инструментом
     */
    protected static function isInstrumentModelValid($instrument): bool
    {
        if ($instrument instanceof Share) {
            return true;
        }

        if ($instrument instanceof Etf) {
            return true;
        }

        if ($instrument instanceof Bond) {
            return true;
        }

        if ($instrument instanceof Currency) {
            return true;
        }

        if ($instrument instanceof Future) {
            return true;
        }

        if ($instrument instanceof Instrument) {
            return true;
        }

        return false;
    }
}
