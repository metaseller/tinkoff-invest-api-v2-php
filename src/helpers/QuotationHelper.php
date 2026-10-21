<?php

namespace Metaseller\TinkoffInvestApi2\helpers;

use Metaseller\TinkoffInvestApi2\dto\Price;
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
     * @param int|float|Quotation|MoneyValue $price Цена
     *
     * @param Instrument|Share|Bond|Currency|Etf|Future $instrument Инструмент
     *
     * @return bool Признак, является ли корректным значение цены для переданного инструмента
     *
     * @throws ValidateException
     */
    public static function isPriceValid($price, $instrument): bool
    {
        if (!InstrumentsHelper::isInstrumentModelValid($instrument)) {
            throw new ValidateException('Instrument model is not valid');
        }

        $min_price_increment = $instrument->getMinPriceIncrement();

        if (!$min_price_increment) {
            throw new ValidateException('Instrument min price increment value is not available');
        }

        if ($price instanceof Quotation || $price instanceof MoneyValue) {
            $instrument_price = static::toInteger($price);
            $instrument_min_price_increment = static::toInteger($min_price_increment);

            return ($instrument_price % $instrument_min_price_increment) == 0;
        } elseif (is_numeric($price)) {
            $instrument_price = static::toInteger(is_int($price) ? $price : (float) $price);
            $instrument_min_price_increment = static::toInteger($min_price_increment);

            return ($instrument_price % $instrument_min_price_increment) == 0;
        }

        return false;
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
            return round(($price->getUnits() ?: 0) + ($price->getNano() ?: 0) / pow(10, 9), Price::BROKER_PRECISION);
        }

        if (is_numeric($price)) {
            return round((float) $price, Price::BROKER_PRECISION);
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
    public static function toCurrency($price, $instrument, ?GetFuturesMarginResponse $futures_data = null): float
    {
        if (!InstrumentsHelper::isInstrumentModelValid($instrument)) {
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

            return round(($decimal_price / 100) * static::toDecimal($nominal), Price::BROKER_PRECISION);
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


            return round(($decimal_price / static::toDecimal($min_price_increment)) * static::toDecimal($min_price_increment_amount), Price::BROKER_PRECISION);
        }

        return $decimal_price;
    }

    /**
     * Преобразование числа с плавающей запятой, без учета типа инструмента в {@link Quotation}
     *
     * @param float $price Число с плавающей запятой
     *
     * @return Quotation Значение типа {@link Quotation}
     *
     * @throws ValidateException Если значение не помещается в целое число нанодолей
     */
    public static function toQuotation(float $price): Quotation
    {
        return static::integerToQuotation(static::toInteger($price));
    }

    /**
     * Значение в нанодолях. Quotation, MoneyValue и целые числа
     * преобразуются без промежуточного float; float округляется до 9 знаков.
     *
     * @throws ValidateException Если результат не помещается в PHP int
     */
    public static function toInteger(Quotation|MoneyValue|int|float $price): int
    {
        if (is_float($price)) {
            return static::floatToInteger(round(round($price, Price::BROKER_PRECISION) * Price::BROKER_PRECISION_MULTIPLIER));
        }

        $units = is_int($price) ? $price : $price->getUnits();
        $nano = is_int($price) ? 0 : $price->getNano();
        $value = bcadd(bcmul((string) $units, (string) Price::BROKER_PRECISION_MULTIPLIER, 0), (string) $nano, 0);

        if (bccomp($value, (string) PHP_INT_MIN, 0) < 0 || bccomp($value, (string) PHP_INT_MAX, 0) > 0) {
            throw new ValidateException('Value in nanounits is outside the PHP integer range');
        }

        return (int) $value;
    }

    /**
     * Преобразование целого числа нанодолей без потери точности.
     */
    public static function integerToQuotation(int $value): Quotation
    {
        return (new Quotation())
            ->setUnits(intdiv($value, Price::BROKER_PRECISION_MULTIPLIER))
            ->setNano($value % Price::BROKER_PRECISION_MULTIPLIER);
    }

    /**
     * Перевод float в int
     *
     * @param float $price Число в формате float
     *
     * @return int Число в формате int
     *
     * @throws ValidateException Если число бесконечное, NaN или вне диапазона PHP int
     */
    public static function floatToInteger(float $price): int
    {
        // PHP_INT_MAX rounds up when converted to float on a 64-bit platform.
        if (!is_finite($price) || $price < PHP_INT_MIN || $price >= -(float) PHP_INT_MIN) {
            throw new ValidateException('Float value is outside the PHP integer range');
        }

        return (int) $price;
    }
}
