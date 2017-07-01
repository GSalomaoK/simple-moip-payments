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
  public $itens = [];

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
   * Add a item to our itemlist
   * @param array $item
   */
  public function addItem(array $item){
    return array_push($this->itens, $item);
  }

  /**
   * Creates a new order with the information and then sends the order to the gateway
   * @param  int $addition
   * @param  int $discount
   * @return string
   */
  public function createOrder($addition, $discount){

  }

  /**
   * Check the current status of the order
   * @param  string $identifier
   * @return string
   */
  public static function checkOrderStatus($identifier){

  }

}
