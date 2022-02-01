<?php

namespace Metaseller\TinkoffInvestApi2;

use Exception;

/**
 * Микро трейт расширенного функционала работы
 *
 * @package Metaseller\TinkoffInvestApi2
 */
trait ModelTrait
{
    /**
     * Переопределение магического метода-геттера
     *
     * @throws Exception
     */
    public function __get($name)
    {
        $method_getter = 'get' . $name;

        if (method_exists($this, $method_getter)) {
            return $this->$method_getter();
        }

        throw new Exception('Undefined property $' . $name);
    }

    /**
     * Переопределение магического метода-ceттера
     *
     * @throws Exception
     */
    public function __set($name, $value)
    {
        $method_setter = 'set' . $name;

        if (method_exists($this, $method_setter)) {
            return $this->$method_setter($value);
        }

        throw new Exception('Undefined property $' . $name);
    }
}
