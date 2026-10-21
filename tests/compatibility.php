<?php

use Google\Protobuf\Internal\Message;
use Grpc\ChannelCredentials;
use Metaseller\TinkoffInvestApi2\dto\Price;
use Metaseller\TinkoffInvestApi2\dto\Quantity;
use Metaseller\TinkoffInvestApi2\helpers\ArrayHelper;
use Metaseller\TinkoffInvestApi2\helpers\NumbersHelper;
use Tinkoff\Invest\V1\MoneyValue;
use Tinkoff\Invest\V1\Quotation;
use Tinkoff\Invest\V1\SharesResponse;
use Tinkoff\Invest\V1\Share;
use Tinkoff\Invest\V1\StructuredNote;
use Tinkoff\Invest\V1\StructuredNote\PBYield;

require __DIR__ . '/bootstrap.php';

check(PHP_VERSION_ID >= 80512, 'PHP 8.5.12 or newer is required.');
check(extension_loaded('grpc'), 'The gRPC extension is required.');
check(version_compare(phpversion('grpc'), '1.83.1', '>='), 'gRPC 1.83.1 or newer is required.');
check(extension_loaded('bcmath'), 'The BCMath extension is required.');

// Load every SDK class, including all descriptors, and round-trip every
// generated message through the new Protobuf runtime. No API calls are made.
$messages = 0;
$clients = 0;
$source = dirname(__DIR__) . '/src/';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source));

foreach ($files as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $relative = substr($file->getPathname(), strlen($source));
    $class = str_replace('/', '\\', substr($relative, 0, -4));
    $class = str_starts_with($class, 'models\\')
        ? substr($class, strlen('models\\'))
        : 'Metaseller\\TinkoffInvestApi2\\' . $class;

    check(class_exists($class) || trait_exists($class), 'Cannot autoload ' . $class);

    if (is_subclass_of($class, Message::class)) {
        $message = new $class();
        $decoded = new $class();
        $decoded->mergeFromString($message->serializeToString());
        $decoded->mergeFromJsonString($message->serializeToJsonString());
        check($decoded->serializeToString() === $message->serializeToString(), $class . ' round-trip failed');
        ++$messages;
    } elseif (is_subclass_of($class, Grpc\BaseStub::class)) {
        $client = new $class('localhost:1', ['credentials' => ChannelCredentials::createInsecure()]);
        $client->close();
        ++$clients;
    }
}

$quotation = (new Quotation())->setUnits(-12)->setNano(-345000000);
$decoded = new Quotation();
$decoded->mergeFromString($quotation->serializeToString());
check($decoded->getUnits() === -12 && $decoded->getNano() === -345000000, 'Quotation binary round-trip failed');

foreach ([-12.345, 0.0, 12.345] as $value) {
    $quantity = Quantity::createFromDecimal($value);
    check(abs($quantity->asDecimal() - $value) < 1e-9, 'Quantity decimal conversion failed');
    check(Quantity::createFromQuotation($quantity->asQuotation())->asInteger() === $quantity->asInteger(), 'Quantity quotation conversion failed');
    check(Quantity::createFromInteger($quantity->asInteger())->asDecimal() === $quantity->asDecimal(), 'Quantity integer conversion failed');
}

foreach ([null, 'rub'] as $currency) {
    foreach ([Price::createFromDecimal(12.345, $currency), Price::createFromInteger(12345000000, $currency), Price::createFromQuotation($quotation, $currency)] as $price) {
        check($price->asMoneyValue()->getCurrency() === ($currency ?? ''), 'Nullable currency conversion failed');
        check(Price::createFromMoneyValue($price->asMoneyValue())->asInteger() === $price->asInteger(), 'MoneyValue conversion failed');
    }
}

$money = (new MoneyValue())->setCurrency('rub')->setUnits(12)->setNano(345000000);
$decodedMoney = new MoneyValue();
$decodedMoney->mergeFromJsonString($money->serializeToJsonString());
check($decodedMoney->getCurrency() === 'rub' && $decodedMoney->getNano() === 345000000, 'MoneyValue JSON round-trip failed');
check(NumbersHelper::printFloat(12.345, null, null) === '12.3', 'Nullable formatting options failed');

$shares = (new SharesResponse())->setInstruments([(new Share())->setTicker('SBER')]);
$decodedShares = new SharesResponse();
$decodedShares->mergeFromString($shares->serializeToString());
$instruments = ArrayHelper::repeatedFieldToArray($decodedShares->getInstruments());
check(count($instruments) === 1 && $instruments[0]->getTicker() === 'SBER', 'RepeatedField conversion failed');

$note = (new StructuredNote())->setYield([(new PBYield())->setValue($quotation)]);
$decodedNote = new StructuredNote();
$decodedNote->mergeFromJsonString($note->serializeToJsonString());
check($decodedNote->getYield()[0]->getValue()->getNano() === -345000000, 'StructuredNote yield round-trip failed');
check(is_a('Tinkoff\\Invest\\V1\\StructuredNote\\Yield', PBYield::class, true), 'Legacy Yield alias failed');
check(is_a('Tinkoff\\Invest\\V1\\StructuredNote_Yield', PBYield::class, true), 'Legacy StructuredNote_Yield alias failed');

printf("PHP %s: %d Protobuf messages, %d gRPC clients and DTO/helper checks passed.\n", PHP_VERSION, $messages, $clients);
