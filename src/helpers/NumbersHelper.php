<?php

namespace Metaseller\TinkoffInvestApi2\helpers;

/**
 * Класс дополнительных функций для работы с числами
 *
 * @package Metaseller\TinkoffInvestApi2
 */
class NumbersHelper
{
    /**
     * Метод форматирует вывод числового значения
     *
     * @param mixed $value Числовое значение, которое необходимо отформатировать. Если параметр содержит не числовое значение, то он будет приведен к типу string и возвращен как есть
     * @param int|null $precision Точность (количество дробных знаков). Если равно <code>null<code> то точность формируется автоматически. По умолчанию равно <code>null</code>
     * @param bool|null $scientific Необходимость представить число в 'научном' формате. Если равно <code>null<code> то флаг определяется величиной передннного значения. По умолчанию равно <code>null</code>
     * @param bool $add_thousand_separator Флаг необходимости добавить разделитель разрядов. По умолчанию равно <code>false</code>
     *
     * @return string Отформатированное значение
     */
    public static function printFloat($value, int $precision = null, bool $scientific = null, $add_thousand_separator = false): string
    {
        if (!is_numeric($value)) {
            return (string) $value;
        }

        $abs_value = abs($value);

        if ($abs_value == (int) $abs_value && $precision === null) {
            if ($add_thousand_separator && $abs_value >= 1000) {
                return number_format($value, 0, '.', ',');
            } else {
                return (string) $value;
            }
        }

        if ($abs_value >= 1000) {
            $detected_precision = 0;
            $detected_scientific = false;
        } elseif ($abs_value >= 10) {
            $detected_precision = 1;
            $detected_scientific = false;
        } elseif ($abs_value >= 1) {
            $detected_precision = 2;
            $detected_scientific = false;
        } elseif ($abs_value >= 0.1) {
            $detected_precision = 2;
            $detected_scientific = false;
        } elseif ($abs_value >= 0.01) {
            $detected_precision = 3;
            $detected_scientific = false;
        } elseif ($abs_value > 0) {
            $detected_precision = 2;
            $detected_scientific = true;
        } elseif ($abs_value == 0) {
            return '0';
        } else {
            return '-';
        }

        if (!is_null($precision)) {
            $detected_precision = $precision;
        }

        if (!is_null($scientific)) {
            $detected_scientific = $scientific;
        }

        if ($detected_scientific) {
            $value = sprintf('%.' . $detected_precision . 'e', $value);
        } else {
            $value = sprintf('%.' . $detected_precision . 'f', $value);
        }

        if ($add_thousand_separator && $abs_value >= 1000) {
            $value = number_format($value);
        }

        return $value;
    }
}
