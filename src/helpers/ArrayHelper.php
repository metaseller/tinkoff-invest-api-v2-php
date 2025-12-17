<?php

namespace Metaseller\TinkoffInvestApi2\helpers;

use Google\Protobuf\Internal\RepeatedField;

/**
 * Класс дополнительных функций для работы с массивами данных и объектами {@link RepeatedField}
 *
 * @package Metaseller\TinkoffInvestApi2
 */
class ArrayHelper
{
    /**
     * Метод клонирует массив
     *
     * @param array $source Массив для клонирования
     *
     * @return array Клон массива
     */
    public static function cloneArray(array $source): array
    {
        return array_merge([], $source);
    }

    /**
     * Метод конвертирует поле типа {@link RepeatedField} в обычный массив
     *
     * @param RepeatedField $field Поле для конвертации
     *
     * @return array Результат конвертации
     */
    public static function repeatedFieldToArray(RepeatedField $field): array
    {
        if (function_exists('iterator_to_array')) {
            return iterator_to_array($field);
        }

        $data = [];

        foreach ($field as $value) {
            $data[] = $value;
        }

        return $data;
    }
}
