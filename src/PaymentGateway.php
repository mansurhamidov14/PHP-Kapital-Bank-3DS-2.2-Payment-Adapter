<?php

namespace Twelver313\KapitalBank;

class PaymentGateway
{
  protected static $PROD_HOST = 'https://e-commerce.kapitalbank.az';
  protected static $DEV_HOST = 'https://txpgtst.kapitalbank.az';
  protected static $DEFAULT_CURRENCY = 'AZN';
  protected static $DEFAULT_LANGUAGE = 'az';
  protected $paymentHost;
  protected $requestHeaders;

  /**
   * @param array $options
   * ```php
   * $options = [
   *   'login' => 'Terminal/MerchanLogin',
   *   'password' => 'MerchantPassword'
   * ]
   * ```
   * @throws \Twelver313\KapitalBank\PaymentGatewayException
   */
  public function __construct($options)
  {
    if (empty($options['login'])) {
      throw new PaymentGatewayException('Missing required parameter "login" for constructor');
    }

    if (empty($options['password'])) {
      throw new PaymentGatewayException('Missing required parameter "password" for constructor');
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
   * @throws \Twelver313\KapitalBank\PaymentGatewayException
   * @return Order
   */
  public function createOrder($options, $type)
  {
    if (!isset($options['amount'])) {
      throw new PaymentGatewayException('Missing required parameter "amount" for "createPurchaseOrder" method');
    }

    if (!isset($options['description'])) {
      throw new PaymentGatewayException('Missing required parameter "description" for "createPurchaseOrder" method');
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

    $order = (array)($this->makeRequest('POST', '/api/order', $body)->order);
    return new Order($order);
  }

  /**
   * @param array $options
   * ```php
   * $options = [
   *   'amount' => 100, // Required option
   *   'description' => 'Payment for a laptop', // Required option
   *   'redirectUrl' => 'https://example.com/payment-redirect', // Required option
   *   'currency' => 'AZN', // Optional, default 'AZN'
   *   'language' => 'az', // Optional, default 'az'
   * ]
   * ```
   * @throws \Twelver313\KapitalBank\PaymentGatewayException
   * @return Order
   */
  public function createPurchaseOrder($options)
  {
    return $this->createOrder($options, Order::TYPE_PURCHASE);
  }

  /**
   * @param array $options
   * ```php
   * $options = [
   *   'amount' => 100, // Required
   *   'description' => 'Payment for a laptop', // Required
   *   'redirectUrl' => 'https://example.com/payment-redirect', // Required
   *   'currency' => 'AZN', // Optional, default 'AZN'
   *   'language' => 'az', // Optional, default 'az'
   * ]
   * ```
   * @throws \Twelver313\KapitalBank\PaymentGatewayException
   * @return Order
   */
  public function createPreAuthOrder($options)
  {
    return $this->createOrder($options, Order::TYPE_PRE_AUTH);
  }

  /**
   * @param array $options
   * ```php
   * $options = [
   *   'amount' => 100, // Required
   *   'description' => 'Payment for a laptop', // Required
   *   'redirectUrl' => 'https://example.com/payment-redirect', // Required
   *   'currency' => 'AZN', // Optional, default 'AZN'
   *   'language' => 'az', // Optional, default 'az'
   * ]
   * ```
   * @throws \Twelver313\KapitalBank\PaymentGatewayException
   * @return Order
   */
  public function createRecurringOrder($options)
  {
    return $this->createOrder($options, Order::TYPE_RECURRING);
  }

  /**
   * @return OrderStatus
   * @throws  Twelver313\KapitalBank\PaymentGatewayException
   */
  private function getOrderStatusResponse($options, $is_detailed = false)
  {
    if (empty($options['id'])) {
      throw new PaymentGatewayException('Missing required parameter "id" for "getOrderStatus" method');
    }

    if (empty($options['password'])) {
      throw new PaymentGatewayException('Missing required parameter "password" for "getOrderStatus" method');
    }

    $requestUrl = '/api/order/' . $options['id'] . '?password=' . $options['password'];

    if ($is_detailed) {
      $requestUrl .= '&tranDetailLevel=2&tokenDetailLevel=2&orderDetailLevel=2';
    }

    return $this->makeRequest('GET', $requestUrl)->order;
  }

  /**
   * @param array $options
   * ```php
   * $options = [
   *   'id' => 5555, // Order id
   *   'password' => 'yourpassword123', // Order password
   * ]
   * ```
   * @see https://documenter.getpostman.com/view/14817621/2sA3dxCB1b#3c15f522-6dae-4ee4-a9e2-f43257919b29
   * @throws \Twelver313\KapitalBank\PaymentGatewayException
   * @return OrderStatus
   */
  public function getOrderStatus($options)
  {
    $order = $this->getOrderStatusResponse($options);
    return new OrderStatus($order);
  }

  /**
   * @param array $options
   * ```php
   * $options = [
   *   'id' => 5555, // Order id
   *   'password' => 'zxcvbnn123', // Order password
   * ]
   * ```
   * @see https://documenter.getpostman.com/view/14817621/2sA3dxCB1b#790f2d23-4ac2-4000-94ec-2b0c45a49709
   * @throws \Twelver313\KapitalBank\PaymentGatewayException
   * @return DetailedOrderStatus
   */
  public function getDetailedOrderStatus($options)
  {
    $order = $this->getOrderStatusResponse($options, true);
    return new DetailedOrderStatus($order);
  }

  /**
   * @param array $options
   * ```php
   * $options = [
   *   'id' => 5555, // Order id
   *   'password' => 'zxcxvb123', // Order password
   *   'amount' => 1000, // Refund amount
   *   'phase' => 'Single', // Optional, default 'Single'
   * ]
   * ```
   * @return Order
   * @throws \Twelver313\KapitalBank\PaymentGatewayException
   */
  public function restoreOrder($options) {
    if (empty($options['id'])) {
      throw new PaymentGatewayException('Missing required parameter "id" for "restoreOrder" method');
    }

    if (empty($options['password'])) {
      throw new PaymentGatewayException('Missing required parameter "password" for "restoreOrder" method');
    }

    $options = array_merge($options, [
      'hppUrl' => $this->paymentHost . '/flex'
    ]);
    return new Order($options);
  }

  /**
   * @param array $options
   * ```php
   * $options = [
   *   'id' => 5555, // Order id
   *   'password' => 'zxcxvb123', // Order password
   *   'amount' => 1000, // Refund amount
   *   'phase' => 'Single', // Optional, default 'Single'
   * ]
   * ```
   * @return RefundResponse
   * @throws \Twelver313\KapitalBank\PaymentGatewayException
   */
  public function refund($options)
  {
    if (empty($options['id'])) {
      throw new PaymentGatewayException('Missing required parameter "id" for "refund" method');
    }

    if (empty($options['password'])) {
      throw new PaymentGatewayException('Missing required parameter "password" for "refund" method');
    }

    if (empty($options['amount'])) {
      throw new PaymentGatewayException('Missing required parameter "amount" for "refund" method');
    }

    $requestBody = [
      'tran' => [
        'phase' => empty($options['phase']) ? 'Single' : $options['phase'],
        'type' => 'Refund',
        'amount' => self::formatPrice($options['amount']),
      ]
    ];

    $response = (array)($this->makeRequest(
      'POST',
      '/api/order/' . $options['id'] . '/exec-tran?password=' . $options['password'],
      $requestBody
    )->tran);
    return new RefundResponse($response);
  }

  private static function formatPrice($price)
  {
    return number_format($price, 2, '.', '');
  }

  /**
   * Making an http request to the server
   * 
   * @param string $method
   * @param string $url
   * @param array|null $body
   * 
   * @return \stdClass
   * @throws \Twelver313\KapitalBank\PaymentGatewayException
   */
  public function makeRequest($method, $url, $body = []) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HTTPHEADER, $this->requestHeaders);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, $this->paymentHost . $url);
    curl_setopt_array($curl, $this->getCurlOptsByRequestMethod($method));
    if (!empty($body) && is_array($body)) {
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
    }

    $response = curl_exec($curl);
    $errNo = curl_errno($curl);
    if ($errNo) {
      throw new PaymentGatewayException(curl_error($curl), $errNo);
    }
    $info = curl_getinfo($curl);
    $response = json_decode($response);

    if (PHP_VERSION_ID < 80000) {
      curl_close($curl);
    }

    if ($info['http_code'] == 404) {
      throw new PaymentGatewayException($response->error . ' ' . $response->path, 404);
    }

    if ($info['http_code'] >= 400) {
      throw new PaymentGatewayException($response->errorDescription, $response->errorCode);
    }
    
    return $response;
  }

  /**
   * @param string $method
   * @return array
   */
  private function getCurlOptsByRequestMethod($method)
  {
    $method = strtoupper($method);
    switch ($method) {
      case 'POST':
        return [CURLOPT_POST => true];
      case 'PUT':
      case 'PATCH':
      case 'DELETE':
      case 'OPTIONS':
        return [CURLOPT_CUSTOMREQUEST => $method];
      case 'HEAD':
        return [CURLOPT_NOBODY => true];
      default:
        return [CURLOPT_POST => false];
    }
  }
}