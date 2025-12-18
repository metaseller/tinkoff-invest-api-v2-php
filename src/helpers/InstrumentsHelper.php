<?php

namespace Metaseller\TinkoffInvestApi2\helpers;

use Tinkoff\Invest\V1\Bond;
use Tinkoff\Invest\V1\Currency;
use Tinkoff\Invest\V1\Etf;
use Tinkoff\Invest\V1\Future;
use Tinkoff\Invest\V1\Instrument;
use Tinkoff\Invest\V1\SecurityTradingStatus;
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

    /**
     * Метод проверяет критерии, возможна ли торговля инструментом через API
     *
     * @param Share|Etf|Bond|Currency|Future|Instrument $instrument Модель инструмента
     * @param bool $check_trading_status Проверять ли getTradingStatus
     * @param bool $check_api_trade Проверять ли getApiTradeAvailableFlag
     * @param bool $check_buy_flag Проверять ли getBuyAvailableFlag
     * @param bool $check_sell_flag Проверять ли getSellAvailableFlag
     *
     * @return bool Флаг выполнения всех выбранных критериев
     */
    public static function isReadyToTrade(
        $instrument,
        bool $check_trading_status = true,
        bool $check_api_trade = true,
        bool $check_buy_flag = true,
        bool $check_sell_flag = true
    ): bool
    {
        if (!static::isInstrumentModelValid($instrument)) {
            return false;
        }

        if ($check_trading_status && !$instrument->getTradingStatus() !== SecurityTradingStatus::SECURITY_TRADING_STATUS_NORMAL_TRADING) {
            return false;
        }

        if ($check_api_trade && !$instrument->getApiTradeAvailableFlag()) {
            return false;
        }

        if ($check_buy_flag && !$instrument->getBuyAvailableFlag()) {
            return false;
        }

        if ($check_sell_flag && !$instrument->getSellAvailableFlag()) {
            return false;
        }

        return true;
    }
}
