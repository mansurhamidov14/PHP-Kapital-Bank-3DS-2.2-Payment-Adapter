<?php

namespace Twelver313\KapitalBank;

use Exception;

class PaymentGateway
{
  private static $PROD_HOST = 'https://e-commerce.kapitalbank.az';
  private static $DEV_HOST = 'https://txpgtst.kapitalbank.az';
  private static $DEFAULT_CURRENCY = 'AZN';
  private static $DEFAULT_LANGUAGE = 'az';
  private $paymentHost;
  private $requestHeaders;

  /**
   * @throws Exception
   */
  public function __construct($options)
  {
    if (empty($options['login'])) {
      throw new Exception('Missing required parameter "login" for constructor');
    }

    if (empty($options['password'])) {
      throw new Exception('Missing required parameter "password" for constructor');
    }

    $this->requestHeaders = [
      'Content-Type: application/json',
      'Authorization: Basic ' . base64_encode("{$options['login']}:{$options['password']}")
    ];

    if (!empty($options['paymentHost'])) {
      $this->paymentHost = $options['paymentHost'];
    } else if (empty($options['isDev'])) {
      $this->paymentHost = self::$PROD_HOST;
    } else {
      $this->paymentHost = self::$DEV_HOST;
    }
  }

  /**
   * @throws Exception
   * @return Order
   */
  public function createOrder($options, $type)
  {
    if (empty($options['amount'])) {
      throw new Exception('Missing required parameter "amount" for "createPurchaseOrder" method');
    }

    if (empty($options['description'])) {
      throw new Exception('Missing required parameter "description" for "createPurchaseOrder" method');
    }

    $body = [
      'order' => [
        'typeRid' => $type,
        'amount' => self::formatPrice($options['amount']),
        'currency' => empty($options['currency']) ? self::$DEFAULT_CURRENCY : $options['currency'],
        'language' => empty($options['language']) ? self::$DEFAULT_LANGUAGE : $options['language'],
        'description' => $options['description']
      ]
    ];

    if (!empty($options['redirectUrl'])) {
      $body['order']['hppRedirectUrl'] = $options['redirectUrl'];
    }

    $requestOptions = [
      CURLOPT_POST => true,
      CURLOPT_URL => $this->paymentHost . '/api/order/',
      CURLOPT_POSTFIELDS => json_encode($body)
    ];

    $order = self::executeRequest($requestOptions)['order'];
    return new Order($order);
  }

  /**
   * @throws Exception
   * @return Order
   */
  public function createPurchaseOrder($options)
  {
    return $this->createOrder($options, Order::TYPE_PURCHASE);
  }

  /**
   * @throws Exception
   * @return Order
   */
  public function createPreAuthOrder($options)
  {
    return $this->createOrder($options, Order::TYPE_PRE_AUTH);
  }

  /**
   * @throws Exception
   * @return Order
   */
  public function createRecurringOrder($options)
  {
    return $this->createOrder($options, Order::TYPE_RECURRING);
  }

  /**
   * @return OrderStatus
   *@throws  Exception
   */
  public function getOrderStatus($options)
  {
    if (empty($options['id'])) {
      throw new Exception('Missing required parameter "id" for "getOrderStatus" method');
    }

    if (empty($options['password'])) {
      throw new Exception('Missing required parameter "password" for "getOrderStatus" method');
    }

    $requestOptions = [
      CURLOPT_URL => $this->paymentHost . '/api/order/' . $options['id'] . '?password=' . $options['password'],
    ];

    $response = $this->executeRequest($requestOptions)['order'];
    return new OrderStatus($response);
  }

  public function restoreOrder($options) {
    return new Order([
      'id' => $options['id'],
      'password' => $options['password'],
      'secret' => $options['secret'],
      'hppUrl' => $this->paymentHost . '/flex'
    ]);
  }

  /**
   * @throws Exception
   */
  public function refund($options)
  {
    if (empty($options['id'])) {
      throw new Exception('Missing required parameter "id" for "refund" method');
    }

    if (empty($options['password'])) {
      throw new Exception('Missing required parameter "password" for "refund" method');
    }

    if (empty($options['amount'])) {
      throw new Exception('Missing required parameter "amount" for "refund" method');
    }

    $requestOptions = [
      CURLOPT_URL => $this->paymentHost . '/api/order/' . $options['id'] . '/exec-trans?password=' . $options['password'],
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => json_encode([
        'tran' => [
          'phase' => empty($options['phase']) ? 'Single' : $options['phase'],
          'type' => 'Refund',
          'amount' => self::formatPrice($options['amount']),
        ]
      ])
    ];

    $response = $this->executeRequest($requestOptions)['tran'];
    return new RefundResponse($response);
  }

  private static function formatPrice($price)
  {
    return number_format($price, 2, '.', '');
  }

  private function executeRequest($options) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HTTPHEADER, $this->requestHeaders);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt_array($curl, $options);
    $execute = curl_exec($curl);
    return json_decode($execute, true);
  }
}