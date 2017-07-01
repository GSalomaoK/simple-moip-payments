<?php

require __DIR__ . '/vendor/autoload.php';

use MoipPayment\Payment;
use MoipPayment\Order;

$order = new Order("D", "D");
$order->addItem(["Item1"]);
$order->addItem(["Item2"]);
$order->createOrder(0, 20);
