<?php

namespace MoipPayment;

class Customer{

  /**
   * The id attached to our customer
   * @var string
   */
  public $identifier;

  /**
   * Instance of our current Moip object
   * @var object
   */
  public $moip;

  /**
   * Customer information
   * @var array $customer
   * @format [
   *   string 'Customer Name',
   *   string 'Customer Email',
   *   string 'Customer BirthDate' @format 'YYYY-MM-DD',
   *   string 'Customer Document',
   *   string 'Customer Phone Number'
   * ]
   */
  public $customerInfo = [];

  /**
   * Customer billing address
   * @var array
   * @format [
   *   string 'Street Name',
   *   int 'Street Number',
   *   string 'District',
   *   string 'City Name',
   *   string 'State Abbreviation' #ex: 'SP',
   *   string 'Zip Code',
   *   int 'Complement'
   * ]
   */
  public $billingAddress = [];

  /**
   * Customer shipping address
   * @var array
   * @format [
   *   string 'Street Name',
   *   int 'Street Number',
   *   string 'District',
   *   string 'City Name',
   *   string 'State Abbreviation' #ex: 'SP',
   *   string 'Zip Code',
   *   int 'Complement'
   * ]
   */
  public $shippingAddress = [];

  public function __construct($moip, array $customer){
      $this->moip = $moip;
      $this->customerInfo = $customer;
      $this->identifier = uniqid();
  }

  public function createCustomer(){
    try{
      $customer = $this->moip->customers()->setOwnId($this->identifier);
      $this->processCustomerInformation($customer, $this->customerInfo);
      $this->processBillingAddress($customer, $this->billingAddress);
      $this->processShippingAddress($customer, $this->shippingAddress);
      $customer->create();
      return $customer;
    } catch (Exception $e){
      printf($e->__toString());
    }
  }

  /**
   * Attaches the billing address to our customer object
   * @param  array  $billingAddress
   * @return void
   */
  public function attachBillingAddress(array $billingAddress){
    return $this->billingAddress = $billingAddress;
  }

  /**
   * Attaches the shipping address to our customer object
   * @param  array $shippingAddress
   * @return void
   */
  public function attachShippingAddress(array $shippingAddress){
    return $this->shippingAddress = $shippingAddress;
  }

  private function processCustomerInformation($customer, array $customerInfo){
    $currentCustomer = $customer;

    $currentCustomer->setFullname($customerInfo[0])
                    ->setEmail($customerInfo[1])
                    ->setBirthDate($customerInfo[2])
                    ->setTaxDocument($customerInfo[3])
                    ->setPhone($customerInfo[4][0], $customerInfo[4][1]);
  }

  /**
   * Processes the billing address and passes to Moip customer object
   * @param  object $customer
   * @param  array  $billingAddress
   * @return void
   */
  private function processBillingAddress($customer, array $customerAddress){
    $currentCustomer = $customer;

    return $currentCustomer->addAddress('BILLING',
                            $customerAddress[0],
                            $customerAddress[1],
                            $customerAddress[2],
                            $customerAddress[3],
                            $customerAddress[4],
                            $customerAddress[5],
                            $customerAddress[6]);
  }

  /**
   * Processes the shipping address and passes to Moip customer object
   * @param  object $customer
   * @param  array  $customerAddress
   * @return void
   */
  private function processShippingAddress($customer, array $customerAddress){
    $currentCustomer = $customer;

    return $currentCustomer->addAddress('SHIPPING',
                            $customerAddress[0],
                            $customerAddress[1],
                            $customerAddress[2],
                            $customerAddress[3],
                            $customerAddress[4],
                            $customerAddress[5],
                            $customerAddress[6]);

  }

  /**
   * Shows the identifier of our order to later purposes
   * @return string
   */
  public function getIdentifier(){
    return $this->identifier;
  }

}
