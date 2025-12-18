<?php

namespace Metaseller\TinkoffInvestApi2\helpers;

use Tinkoff\Invest\V1\Bond;
use Tinkoff\Invest\V1\Currency;
use Tinkoff\Invest\V1\Etf;
use Tinkoff\Invest\V1\Future;
use Tinkoff\Invest\V1\Instrument;
use Tinkoff\Invest\V1\Share;

/**
 * Хелпер для работы с инструментами в Tinkoff Invest API v2
 *
 * @package Metaseller\TinkoffInvestApi2
 */
class InstrumentsHelper
{
    /**
     * Проверяет модель данных инструмента
     *
     * @param mixed $instrument Модель
     *
     * @return bool Является ли инструмент валидным торговым инструментом
     */
    public static function isInstrumentModelValid($instrument): bool
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
