<?php

require __DIR__ . '/vendor/autoload.php';

use Moip\Moip;
use Moip\Auth\BasicAuth;

use MoipPayment\Payment;
use MoipPayment\Order;
use MoipPayment\Customer;

$token = "YOUR_TOKEN_HERE";
$key = "YOUR_KEY_HERE";

$moip = new Moip(new BasicAuth($token, $key), Moip::ENDPOINT_SANDBOX);

$customer = new Customer($moip, ["Guilherme Salomão", "teste@teste.com", "1999-04-08", "00000000000", [99, 000000000]]);
$customer->attachBillingAddress(["Rua teste", 121, "Bairro Teste", "Cidade Teste", "TT", "65470000", 7]);
$customer->attachShippingAddress(["Rua shipping teste", 121, "Bairro Shipping Teste", "Cidade Shipping Teste", "TS", "65470000", 8]);
$newCustomer = $customer->createCustomer();

$order = new Order($moip, $newCustomer);
$order->addItem(["Item 1", 1, "PARAM", 1000]);
$order->addItem(["Item 2", 1, "PARAM2", 1300]);

$passOrdem = $order->createOrder();

try {
    $payment = $passOrdem->payments()->setCreditCard(12, 21, '4073020000000002', '123', $newCustomer)
        ->execute();

    print_r($payment);
} catch (Exception $e) {
    printf($e->__toString());
}
