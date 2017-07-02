<?php

require __DIR__ . '/vendor/autoload.php';

use MoipPayment\Payment;
use MoipPayment\Order;

$itens = [[0, "A"], [1, "B"], [2, "C"]];

$order = new Order("D", "D");
//$order->addItem(["Item1"]);
//$order->addItem(["Item2"]);
array_map(function($n) use (&$order){ return $order->addItem($n); }, $itens);
$order->createOrder(0, 20);
var_dump($order);
