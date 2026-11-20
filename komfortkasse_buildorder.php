<?php

// Komfortkasse API v2 example
// builds an example order in the format of the API v2 (schema OrderWrite, see https://apidoc.komfortkasse.eu/)

/**
 * Returns a new example order number.
 */
function newOrderNumber()
{
    return (string) rand(10000, 99999);
}

/**
 * Stores an order number in order_numbers.txt (read by komfortkasse_read.php).
 */
function rememberOrderNumber($orderNumber)
{
    file_put_contents(__DIR__ . '/order_numbers.txt', $orderNumber . "\n", FILE_APPEND);
}

/**
 * Returns the example order. The order number is not part of the body, it is part of the URL.
 */
function getOrder()
{
    return array(
        'date' => date('d-m-Y'), // format dd-MM-yyyy
        'customerEmail' => 'max@example.org', // enter your email address to receive the payment information mail
        'customerNumber' => '12345',
        'type' => 'PREPAYMENT', // PREPAYMENT, INVOICE, COD or OTHER
        'paymentMethod' => 'prepayment', // payment method in your shop, for information only
        'amount' => 123.45, // total amount including taxes and shipping
        'currency' => 'EUR',
        'language' => 'de',
        'items' => array(
            array('number' => 'ABC', 'name' => 'Example item ABC'),
            array('number' => 'XYZ', 'name' => 'Example item XYZ'),
        ),
        'billing' => array(
            'gender' => 'male',
            'firstName' => 'Max',
            'lastName' => 'Mustermann',
            'street' => 'Musterstraße 1',
            'postCode' => '12345',
            'city' => 'Musterstadt',
            'countryCode' => 'DE',
        ),
        'shipping' => array(
            'gender' => 'female',
            'firstName' => 'Anna',
            'lastName' => 'Mustermann',
            'company' => 'Musterfirma',
            'street' => 'Musterweg 2',
            'postCode' => '12345',
            'city' => 'Musterstadt',
            'countryCode' => 'DE',
        ),
    );
}
