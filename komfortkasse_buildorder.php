<?php

// Komfortkasse Generic Example
// just building a "Example Order" here

function getorder($order_number) {

	if (!$order_number) {
		$order_number = rand(10000, 99999);
		file_put_contents('order_numbers.txt', $order_number . "\n", FILE_APPEND);
	}

	$order = array ();
	$order ['number'] = $order_number;
	$order ['date'] = date('d.m.Y');
	$order ['email'] = 'max@example.org'; // enter your E-Mail address here in order to receive the payment information mail
	$order ['customer_number'] = '12345';
	$order ['payment_method'] = 'prepayment';
	$order ['type'] = 'PREPAYMENT';
	$order ['amount'] = 123.45;
	$order ['currency_code'] = 'EUR';
	$order ['language_code'] = "de";
	$order ['delivery_firstname'] = 'Anna';
	$order ['delivery_lastname'] = 'Mustermann';
	$order ['delivery_company'] = 'Musterfirma';
	$order ['billing_firstname'] = 'Max';
	$order ['billing_lastname'] = 'Mustermann';
	$order ['billing_company'] = '';
	$order ['billing_country'] = 'DE';
	$order ['products'] [] = 'ABC';
	$order ['products'] [] = 'XYZ';

	return $order;
}


?>