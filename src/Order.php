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

  /**
   * Shipping price
   * @var int
   */
  public $shipping;

  public function __construct($moip, $customer){
    $this->moip = $moip;
    $this->customer = $customer;
    $this->identifier = uniqid();
  }

  /**
   * Add a item to our items list
   * @param array $item
   *            @format [
   *              string 'Item Name',
   *              int    'Quantity',
   *              string 'Detailed information',
   *              int    'Price'
   *            ]
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
  private function processItems($order, array $items){
    $currentOrder = $order;
    array_map(function($item) use (&$currentOrder, &$items){
      foreach($items as $it){
          return $currentOrder->addItem($it[0], $it[1], $it[2], $it[3]);
      }
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
      $this->processItems($order, $this->items);
      $order->setAddition($this->addition);
      $order->setDiscount($this->discount);
      $order->setShippingAmount($shipping);
      $order->setCustomer($this->customer)
            ->create();
      return $order;
    } catch (Exception $e){
      printf($e->__toString());
    }

  }
  /**
   * Shows the identifier of our order to later purposes
   * @return string
   */
  public function getIdentifier(){
    return $this->identifier;
  }

  /**
   * Check the current status of the order
   * @param  string $identifier
   * @return string
   */
  public static function checkOrderStatus($identifier){

  }

}
