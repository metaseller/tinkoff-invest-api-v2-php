<?php

namespace Metaseller\TinkoffInvestApi2\providers;

use Metaseller\TinkoffInvestApi2\dto\Price;
use Metaseller\TinkoffInvestApi2\exceptions\RequestException;
use Metaseller\TinkoffInvestApi2\exceptions\ValidateException;
use Metaseller\TinkoffInvestApi2\helpers\ArrayHelper;
use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Throwable;
use Tinkoff\Invest\V1\MoneyValue;
use Tinkoff\Invest\V1\PortfolioPosition;
use Tinkoff\Invest\V1\PortfolioRequest;
use Tinkoff\Invest\V1\PortfolioResponse;
use Tinkoff\Invest\V1\PositionsRequest;
use Tinkoff\Invest\V1\PositionsResponse;

/**
 * Провайдер рыночных данных сервиса Tinkoff Invest API 2
 *
 * @package Metaseller\TinkoffInvestApi2
 */
class PortfolioProvider extends BaseDataProvider
{
    /**
     * Метод создания нового экземпляра провайдера
     *
     * @param TinkoffClientsFactory|null $model Экземпляр фабрики клиентов доступа к сервису Tinkoff Invest API 2 или <code>null</code>, если инициализация планируется позднее
     *
     * @return static Созданный экземпляр провайдера
     */
    public static function create(?TinkoffClientsFactory $model = null): self
    {
        return new static($model);
    }

    /**
     * Получение списка позиций портфеля
     *
     * @param string $account_id Идентификатор аккаунта
     * @param bool $raise Признак необходимость бросить исключение, если возникла ошибка исполнения. По умолчанию равно <code>true</code>
     *
     * @return PortfolioPosition[]|null Список позиций портфеля
     *
     * @throws RequestException
     * @throws Throwable
     * @throws ValidateException
     */
    public function getPortfolioPositions(string $account_id, bool $raise = true): ?array
    {
        try {
            $request = new PortfolioRequest();
            $request->setAccountId($account_id);

            $clients_factory = $this->getClientsFactory();

            /**
             * @var PortfolioResponse $response - Получаем ответ, содержащий информацию о портфеле
             */
            list($response, $status) = $clients_factory
                ->operationsServiceClient
                ->GetPortfolio($request)
                ->wait()
            ;

            $clients_factory->processRequestStatus($status);

            if (!$response) {
                throw new RequestException('Response is empty');
            }

            return ArrayHelper::repeatedFieldToArray($response->getPositions());
        } catch (Throwable $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }

    /**
     * Метод получения количества денежных средств в портфеле аккаунта
     *
     * @param string $account_id Идентификатор аккаунта
     * @param bool $raise Признак необходимость бросить исключение, если возникла ошибка исполнения. По умолчанию равно <code>true</code>
     *
     * @return array|null Массив с информацией о количестве денежных средств
     *  <pre>
     *      [
     *          'available' => {@link Price},
     *          'blocked' => {@link Price},
     *      ]
     *  </pre>
     *
     * @throws RequestException
     * @throws Throwable
     * @throws ValidateException
     */
    public function getPortfolioMoney(string $account_id, bool $raise = true): ?array
    {
        try {
            $request = new PositionsRequest();
            $request->setAccountId($account_id);

            $clients_factory = $this->getClientsFactory();

            /**
             * @var PositionsResponse $response - Получаем ответ, содержащий информацию о позициях портфеля
             */
            list($response, $status) = $clients_factory
                ->operationsServiceClient
                ->GetPositions($request)
                ->wait()
            ;

            $clients_factory->processRequestStatus($status);

            if (!$response) {
                throw new RequestException('Response is empty');
            }

            $portfolio_currency = [];

            /** @var MoneyValue $money */
            foreach ($response->getMoney() as $money) {
                $portfolio_currency[$money->getCurrency()]['available'] = Price::createFromMoneyValue($money);
            }

            /** @var MoneyValue $blocked */
            foreach ($response->getBlocked() as $blocked) {
                $portfolio_currency[$blocked->getCurrency()]['blocked'] =  Price::createFromMoneyValue($blocked);
            }

            foreach ($portfolio_currency as $currency => $values) {
                $zero_money_mocked = (new MoneyValue())
                    ->setCurrency($currency)
                    ->setNano(0)
                    ->setUnits(0)
                ;

                if (!isset($values['available'])) {
                    $portfolio_currency[$currency]['available'] = Price::createFromMoneyValue($zero_money_mocked);
                }

                if (!isset($values['blocked'])) {
                    $portfolio_currency[$currency]['blocked'] = Price::createFromMoneyValue($zero_money_mocked);
                }
            }

            return $portfolio_currency;
        } catch (Throwable $e) {
            if ($raise) {
                throw  $e;
            }

            return null;
        }
    }
}
