<?php

/**
 * Test: Api\Entity\RecurringPayment
 */

use Contributte\GopayInline\Api\Entity\RecurringPayment;
use Contributte\GopayInline\Api\Objects\Item;
use Contributte\GopayInline\Api\Objects\Parameter;
use Contributte\GopayInline\Api\Objects\Payer;
use Contributte\GopayInline\Api\Objects\Target;
use Tester\Assert;

require __DIR__ . '/../../../../bootstrap.php';

// Simple
test(function () {
	$payment = new RecurringPayment();
	$payment->setTarget($target = new Target());
	$payment->setPayer($payer = new Payer());
	$payment->setLang('CZ');

	$array = $payment->toArray();
	Assert::equal(FALSE, isset($array['target']));
	Assert::equal(FALSE, isset($array['payer']));
	Assert::equal(FALSE, isset($array['lang']));
});

// Amount
test(function () {
	$payment = new RecurringPayment();

	$payment->setAmount(100);
	Assert::equal(100, $payment->getAmount());
});

// Items
test(function () {
	$payment = new RecurringPayment();
	$payment->addItem($i = new Item());
	$i->amount = 100;
	$payment->addItem($i = new Item());
	$i->amount = 200;

	$array = $payment->toArray();
	Assert::count(2, $array['items']);
	Assert::equal(floatval(10000), $array['items'][0]['amount']);
	Assert::equal(floatval(20000), $array['items'][1]['amount']);

	$payment->setItems([]);
	Assert::count(0, $payment->getItems());
});

// Parameters
test(function () {
	$payment = new RecurringPayment();
	$payment->addParameter($p = new Parameter());
	$p->name = 'foo';
	$p->value = 'bar';

	$array = $payment->toArray();
	Assert::count(1, $array['additional_params']);
	Assert::equal('foo', $array['additional_params'][0]['name']);
	Assert::equal('bar', $array['additional_params'][0]['value']);

	$payment->setParameters([]);
	Assert::count(0, $payment->getParameters());
});
