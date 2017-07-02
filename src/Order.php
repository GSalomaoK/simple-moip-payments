<?php

namespace MoipPayment;

class Order{

  /**
   * The id attached to our order request
   * @var string
   */
  public $identifier;

  /**
   * Instance of our current Moip object
   * @var object
   */
  public $moip;

  /**
   * Instance of our current Customer object
   * @var object
   */
  public $customer;

  /**
   * Itens attached to the order
   * @var array
   */
  public $items = [];

  /**
   * Addition value to the final order price
   * @var int
   */
  public $addition;

  /**
   * Discounted value to the final order price
   * @var int
   */
  public $discount;

  public function __construct($moip, $customer){
    $this->moip = $moip;
    $this->customer = $customer;
    $this->identifier = uniqid();
  }

  /**
   * Add a item to our items list
   * @param array $item
   * @return void
   */
  public function addItem(array $item){
    return array_push($this->items, $item);
  }

  /**
   * Batches items into the order object addItem chain
   * @param  object $order
   * @param  array  $items
   * @return void
   */
  private function processItens($order, array $items){
    $current_order = $order;
    array_map(function($item) use (&$current_order){
      return $current_order->addItem($item);
    }, $items);
  }

  /**
   * Creates a new order with the information and then sends the order to the gateway
   * @param  int $addition
   * @param  int $discount
   * @param  int $shipping
   * @return string
   */
  public function createOrder($addition = 0, $discount = 0, $shipping = 0){
    $this->addition = $addition;
    $this->discount = $discount;

    try{
      $order = $this->moip->orders()->setOwnId($this->identifier);
      $this->processItens($order, $this->items);
      $order->setAddition($addition);
      $order->setDiscount($discount);
      $order->setShippingAmount($shippping);
      $order->setCustomer($this->customer)
            ->create();
      printf($order);
    } catch (Exception $e){
      printf($e->__toString());
    }

  }

  /**
   * Check the current status of the order
   * @param  string $identifier
   * @return string
   */
  public static function checkOrderStatus($identifier){

  }

}
