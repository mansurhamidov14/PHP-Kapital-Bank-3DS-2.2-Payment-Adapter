<?php

namespace Twelver313\KapitalBank;

use Exception;

class Order
{
  public $password;
  public $secret;
  public $id;
  public $url;

  const TYPE_PURCHASE = 'Order_SMS';
  const TYPE_PRE_AUTH = 'Order_DMS';
  const TYPE_RECURRING = 'Order_REC';

  /**
   * @throws \Twelver313\KapitalBank\PaymentGatewayException
   */
  public function __construct($options)
  {
    if (empty($options) || !is_array($options)) {
      throw new PaymentGatewayException('Invalid options');
    }

    foreach ($options as $key => $value) {
      $this->{$key} = $value;
    }

    $this->url = $options['hppUrl'] . '?' . (http_build_query([
      'id' => $options['id'],
      'password' => $options['password']
    ]));
  }

  public function navigateToPaymentPage()
  {
    header('Location: ' . $this->url, true, 302);
    exit;
  }
}