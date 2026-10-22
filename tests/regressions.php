<?php

use Grpc\BaseStub;
use Metaseller\TinkoffInvestApi2\dto\Price;
use Metaseller\TinkoffInvestApi2\dto\Quantity;
use Metaseller\TinkoffInvestApi2\exceptions\InstrumentNotFoundException;
use Metaseller\TinkoffInvestApi2\exceptions\ValidateException;
use Metaseller\TinkoffInvestApi2\helpers\QuotationHelper;
use Metaseller\TinkoffInvestApi2\helpers\NumbersHelper;
use Metaseller\TinkoffInvestApi2\providers\InstrumentsProvider;
use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Tinkoff\Invest\V1\MoneyValue;
use Tinkoff\Invest\V1\Quotation;
use Tinkoff\Invest\V1\SecurityTradingStatus;
use Tinkoff\Invest\V1\Share;
use Tinkoff\Invest\V1\Future;
use Tinkoff\Invest\V1\GetFuturesMarginResponse;

require __DIR__ . '/bootstrap.php';

function expectException(string $class, callable $callback): void
{
    try {
        $callback();
    } catch (Throwable $error) {
        check($error instanceof $class, 'Expected ' . $class . ', got ' . get_class($error));
        return;
    }

    throw new RuntimeException('Expected ' . $class . ' was not thrown');
}

// Protect all cached services against stale credentials, including OperationsStream.
$serviceGetters = [
    'getInstrumentsServiceClient', 'getMarketDataStreamServiceClient',
    'getMarketDataServiceClient', 'getOperationsServiceClient',
    'getOperationsStreamServiceClient', 'getOrdersServiceClient',
    'getOrdersStreamServiceClient', 'getSandboxServiceClient',
    'getStopOrdersServiceClient', 'getUsersServiceClient',
];
$metadataProperty = new ReflectionProperty(BaseStub::class, 'update_metadata');

foreach ($serviceGetters as $getter) {
    $factory = new TinkoffClientsFactory('regression-token-before');
    $before = $factory->$getter();
    check($factory->$getter() === $before, $getter . ' does not reuse its cached client');

    $factory->setApiToken('regression-token-after');
    $after = $factory->$getter();
    check($before !== $after, $getter . ' retained a client after token rotation');
    $metadata = ($metadataProperty->getValue($after))([]);
    check($metadata['authorization'] === ['Bearer regression-token-after'], $getter . ' retained stale credentials');

    $factory->setApiToken('');
    expectException(Exception::class, static fn() => $factory->$getter());
    $before->close();
    $after->close();
}

// Values around the float exact-integer boundary and the PHP integer limits.
$integers = [0, 1, -1, 100000123456789, -100000123456789,
    9007199254740993, -9007199254740993, PHP_INT_MAX, PHP_INT_MIN];
$precision = ini_get('precision');
$scale = bcscale(6);

try {
    foreach ([14, 3] as $displayPrecision) {
        ini_set('precision', (string) $displayPrecision);
        foreach ($integers as $integer) {
            $units = intdiv($integer, Quantity::BROKER_PRECISION_MULTIPLIER);
            $nano = $integer % Quantity::BROKER_PRECISION_MULTIPLIER;
            $quotation = (new Quotation())->setUnits($units)->setNano($nano);
            $money = (new MoneyValue())->setCurrency('rub')->setUnits($units)->setNano($nano);

            foreach ([Quantity::createFromQuotation($quotation), Quantity::createFromInteger($integer),
                Price::createFromQuotation($quotation, 'rub'), Price::createFromInteger($integer, 'rub'),
                Price::createFromMoneyValue($money)] as $value) {
                check($value->asInteger() === $integer, 'Integer precision lost');
                check((string) $value->asQuotation()->getUnits() === (string) $units, 'Quotation units changed');
                check($value->asQuotation()->getNano() === $nano, 'Quotation nano changed');
                if ($value instanceof Price) {
                    check(QuotationHelper::toInteger($value->asMoneyValue()) === $integer, 'MoneyValue precision lost');
                }
            }
        }
    }
} finally {
    ini_set('precision', $precision);
    bcscale($scale);
}

$instrument = (new Share())->setMinPriceIncrement((new Quotation())->setNano(2));
foreach ([1, -1] as $sign) {
    $odd = (new Quotation())->setUnits($sign * 100000)->setNano($sign * 123456789);
    $even = (new Quotation())->setUnits($sign * 100000)->setNano($sign * 123456788);
    check(!QuotationHelper::isPriceValid($odd, $instrument), 'Invalid price passed the increment check');
    check(QuotationHelper::isPriceValid($even, $instrument), 'Valid price failed the increment check');
}

foreach ([[1.9999999996, 2, 0], [-1.9999999996, -2, 0], [0.000000015, 0, 15]] as [$decimal, $units, $nano]) {
    $quantity = Quantity::createFromDecimal($decimal);
    $quotation = QuotationHelper::toQuotation($decimal);
    check($quotation->getUnits() === $units && $quotation->getNano() === $nano, 'Float rounding was not normalized');
    check(QuotationHelper::toInteger($quantity->asQuotation()) === $quantity->asInteger(), 'Decimal DTO representations disagree');
}
check(QuotationHelper::floatToInteger(100000123456789.0) === 100000123456789, 'Float-to-integer conversion depends on string precision');
check(QuotationHelper::floatToInteger(-12.99) === -12, 'Float-to-integer truncation changed');
check(QuotationHelper::toInteger(100000) === 100000000000000, 'Integer unit conversion failed');

foreach ([INF, -INF, NAN, (float) PHP_INT_MAX] as $invalid) {
    expectException(ValidateException::class, static fn() => QuotationHelper::floatToInteger($invalid));
    expectException(ValidateException::class, static fn() => Quantity::createFromDecimal($invalid));
    expectException(ValidateException::class, static fn() => QuotationHelper::toQuotation($invalid));
}
foreach ([PHP_INT_MAX, PHP_INT_MIN] as $units) {
    $tooLarge = (new Quotation())->setUnits($units);
    expectException(ValidateException::class, static fn() => Quantity::createFromQuotation($tooLarge));
}

// Offline fixtures exercise the real search logic and suppress only API access.
class LookupFixture extends InstrumentsProvider
{
    public array $shares = [];

    public function seed(array $instruments): void
    {
        $this->cacheToDictionary($instruments);
    }

    protected function loadAllShares(): array { return $this->shares; }
    protected function loadAllEtfs(): array { return []; }
    protected function loadAllCurrencies(): array { return []; }
    protected function loadAllBonds(): array { return []; }
    protected function loadAllFutures(): array { return []; }
}

$inactive = (new Share())->setTicker('SBER')->setClassCode('INACTIVE')->setUid('inactive')->setFigi('inactive');
$active = (new Share())->setTicker('SBER')->setClassCode('TQBR')->setUid('active')->setFigi('active')
    ->setTradingStatus(SecurityTradingStatus::SECURITY_TRADING_STATUS_NORMAL_TRADING)
    ->setApiTradeAvailableFlag(true)->setBuyAvailableFlag(true)->setSellAvailableFlag(true);
$lookup = new LookupFixture();
$lookup->seed([$inactive, $active]);
check($lookup->searchByTicker('SBER') === $active, 'Search without a class code did not choose the tradable cached instrument');
check($lookup->searchByTicker('SBER', 'INACTIVE') === $inactive, 'Explicit class code was ignored');
check($lookup->searchByTicker('MISSING', null, false) === null, 'Missing ticker did not respect raise=false');
expectException(InstrumentNotFoundException::class, static fn() => $lookup->searchByTicker('MISSING'));

$coldLookup = new LookupFixture();
$coldLookup->shares = [$active];
check($coldLookup->searchByTicker('SBER') === $active, 'Cold ticker lookup did not reach the dictionary search');

// All services must accept replacement channel options and metadata callbacks.
$customMetadata = static fn(array $metadata): array => ['review-header' => ['custom']];
foreach ($serviceGetters as $getter) {
    $factory = new TinkoffClientsFactory('offline-token', 'custom-app');
    $client = $factory->$getter([
        'grpc.max_receive_message_length' => 20 * 1024 * 1024,
        'credentials' => Grpc\ChannelCredentials::createInsecure(),
        'update_metadata' => $customMetadata,
    ]);
    check(($metadataProperty->getValue($client))([]) === ['review-header' => ['custom']], $getter . ' did not replace the metadata callback');
    $client->close();

    $client = $factory->$getter();
    check(($metadataProperty->getValue($client))([])['x-app-name'] === ['custom-app'], $getter . ' ignored constructor AppName');
    $factory->setAppName('changed-app');
    $changed = $factory->$getter();
    check($changed !== $client, $getter . ' retained a client after AppName change');
    check(($metadataProperty->getValue($changed))([])['x-app-name'] === ['changed-app'], $getter . ' ignored changed AppName');
    $client->close();
    $changed->close();
}
foreach ([null, 'deferred-app'] as $appName) {
    $factory = new TinkoffClientsFactory(null, $appName);
    $factory->setApiToken('offline-token');
    $client = $factory->getUsersServiceClient();
    check(($metadataProperty->getValue($client))([])['x-app-name'] === [$appName ?? TinkoffClientsFactory::DEFAULT_APP_NAME], 'Deferred token initialization lost AppName');
    $client->close();
}

// Zero/negative increments must produce validation errors rather than arithmetic errors.
foreach ([0, -1] as $nano) {
    $step = (new Quotation())->setNano($nano);
    $instrument = (new Share())->setMinPriceIncrement($step);
    foreach ([10, 10.0, '10', (new Quotation())->setUnits(10), (new MoneyValue())->setUnits(10)] as $price) {
        expectException(ValidateException::class, static fn() => QuotationHelper::isPriceValid($price, $instrument));
    }
    $margin = (new GetFuturesMarginResponse())->setMinPriceIncrement($step)
        ->setMinPriceIncrementAmount((new Quotation())->setUnits(1));
    expectException(ValidateException::class, static fn() => QuotationHelper::toCurrency(10, new Future(), $margin));
}
$margin = (new GetFuturesMarginResponse())->setMinPriceIncrement((new Quotation())->setNano(500000000))
    ->setMinPriceIncrementAmount((new Quotation())->setUnits(2));
check(QuotationHelper::toCurrency(10, new Future(), $margin) === 40.0, 'Valid futures price conversion changed');

// Neither input messages nor messages returned by getters may mutate DTO state.
foreach ([Quantity::class, Price::class] as $dtoClass) {
    $input = (new Quotation())->setUnits(10)->setNano(123);
    $dto = $dtoClass::createFromQuotation($input);
    $input->setUnits(20)->setNano(456);
    $dto->asQuotation()->setUnits(30)->setNano(789);
    check($dto->asInteger() === 10000000123, $dtoClass . ' integer changed after external mutation');
    check($dto->asDecimal() === 10.000000123, $dtoClass . ' decimal changed after external mutation');
    check(QuotationHelper::toInteger($dto->asQuotation()) === $dto->asInteger(), $dtoClass . ' quotation changed after external mutation');
    $tooLarge = (new Quotation())->setUnits(PHP_INT_MAX);
    expectException(ValidateException::class, static fn() => $dto->setQuotationValue($tooLarge));
    check(QuotationHelper::toInteger($dto->asQuotation()) === $dto->asInteger(), 'Failed setter corrupted DTO state');
}
$money = (new MoneyValue())->setCurrency('rub')->setUnits(10)->setNano(123);
$price = Price::createFromMoneyValue($money);
$money->setUnits(20);
$price->asQuotation()->setUnits(30);
$price->asMoneyValue()->setUnits(40)->setCurrency('usd');
check(QuotationHelper::toInteger($price->asMoneyValue()) === 10000000123, 'Price MoneyValue changed after external mutation');
check($price->asMoneyValue()->getCurrency() === 'rub', 'Price currency changed after external mutation');

foreach ([[1234.567, 2, false, true, '1,234.57'], [-1234.567, 2, false, true, '-1,234.57'],
    [1234.5, 4, false, true, '1,234.5000'], [1234.567, 0, false, true, '1,235'],
    [1234.567, 2, false, false, '1234.57'], [1234.567, 2, true, true, '1.23e+3'],
    [1234, null, null, true, '1,234'], [12.345, null, null, false, '12.3']] as [$value, $digits, $scientific, $separator, $expected]) {
    check(NumbersHelper::printFloat($value, $digits, $scientific, $separator) === $expected, 'Number formatting lost precision or scientific notation');
}

echo "Credential rotation, monetary precision, ticker lookup, connection options, AppName, price validation, DTO isolation and formatting regressions passed.\n";
