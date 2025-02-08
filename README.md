<p align="center">
  <img src="https://github.com/user-attachments/assets/c51c3a01-8a26-4f47-9046-83404509eb95" height="100px">
</p>

# Kapital Bank E-Commerce API integration library
Seamlessly integrate Kapital Bank E-Commerce API using object-oriented PHP.

## Table of Contents

- [1. Installation](#1-installation)
- [2. Usage](#2-usage)
    - [2.1 Initialize payment gateway adapter](#21-initialize-payment-gateway-adapter)
    - [2.2 Create order](#22-create-order)
    - [2.3 Refunding](#23-refunding)
    - [2.4 Get order status](#24-get-order-status)
    - [2.5 Restore order](#25-restore-order)
    - [2.6 Sending custom requests](#26-sending-custom-requests)

## 1. Installation
```composer require twelver313/kapital-bank```

## 2. Usage
### 2.1 Initialize payment gateway adapter
```php
use Twelver313\KapitalBank\PaymentGateway;

$paymentGateway = new PaymentGateway([
  'login' => '<YOUR_LOGIN>',
  'password' => '<YOUR_PASSWORD>',
  'isDev' => true, // Optional flag for using Kapital-Bank's test environment
  /* You don't need to pass the option below. It was added just in case Kapital Bank changes host address */
  // 'paymentHost' => 'https://txpgtst.kapitalbank.az'
]);
```

### 2.2 Create order
```php
$orderParams = [
  'amount' => 10, // i.e '10.00',
  'currency' => 'AZN', // Optional, 'AZN' by default
  'description' => 'Purchase order example', // Your description
  'redirectUrl' => '/your-redirect-url',
  'language' => 'az', // Optional, 'az' by default
];
/** Creating purchase order */
$order = $paymentGateway->createPurchaseOrder($orderParams);

/** Creating pre-auth order */
$order = $paymentGateway->createPreAuthOrder($orderParams);

/** Creating recurring order */
$order = $paymentGateway->createRecurringOrder($orderParams);

/** Navigate to payment page  */
$order->navigateToPaymentPage(); 

/** Or alternatively use other properties to accomplish your tasks */
$order->url;
$order->id;
$order->secret;
$order->password;
```

### 2.3 Refunding
```php
$response = $paymentGateway->refund([
  'id' => <ORDER_ID>,
  'password' => '<ORDER_PASSWORD>',
  'amount' => 10, // i.e 10.00
  'phase' => 'Single', // Optional, 'Single' by default
]);

// Response properties
$response->approvalCode; // Example: "963348"
$response->pmoResultCode; // Example: "1"
$response->match->{$property}; // Read Kapital-Bank's official documentation see possible properties to refer
```

### 2.4 Get order status
```php
use Twelver313\KapitalBank\OrderStatus

$orderStatus = $paymentGateway->getOrderStatus([
  'id' => <ORDER_ID>,
  'password' => '<ORDER_PASSWORD>' 
]);

// or use
$orderStatus = $paymentGateway->getDetailedOrderStatus([
  'id' => <ORDER_ID>,
  'password' => '<ORDER_PASSWORD>' 
]); // for detailed order status

$status = $orderStatus->status;

// Do any stuff depending on status
if ($status == OrderStatus::CANCELED) { // equivalent: $orderStatus->isCanceled()
  ...
}
if ($status == OrderStatus::DECLINED) { // equivalent: $orderStatus->isDeclined()
  ...
}
if ($status == OrderStatus::FULLY_PAID) { // equivalent: $orderStatus->isFullyPaid()
  ...
}
if ($status == OrderStatus::EXPIRED) { // equivalent: $orderStatus->isExpired()
  ...
}
if ($status == OrderStatus::REFUNDED) { // equivalent: $orderStatus->isRefunded()
  ...
}
if ($orderStatus->isOneOf([OrderStatus::CANCELED, OrderStatus::DECLINED])) {
  ...
}
```

### 2.5 Restore order
<em>You can only restore payments with `Preparing` status so we recommend you to check the order status using `PaymentGateway::getOrderStatus()` method to make sure of it before restoring the order</em>
```php
$orderParams = [
  'id' => <ORDER_ID>,
  'password' => '<ORDER_PASSWORD>' 
];
$orderStatus = $paymentGateway->getOrderStatus($orderParams);

/** Restoring order if it was not finished or expired */
if ($orderStatus->isPreparing()) {
  $order = $paymentGateway->restoreOrder($orderParams);
  $order->navigateToPaymentPage();
}
```

### 2.6 Sending custom requests
<em>Since this library doesn't provide all E-Commerce API features 
you can still perform the operations that are not coming out of the box by sending custom HTTP-requests</em>
```php
$response = $paymentGateway->makeRequest('POST', '/api/order/{id}/set-src-token?password={password}', [
  'order' => [
    'initiationEnvKind' => 'Server'
  ],
  'token' => [
    'extCof'  => [
      'ridByCofp' => '<RID_OF_CARD>',
      'cofProviderRid' => 'TWO_COF'
    ],
    'card' => [
      'entryMode' => 'ECommerce'
    ]
  ]
]);

print_r($response);
```
<em>Response will be an instance of `stdClass`. See official BirBank E-commerce API documentation to find out the response structure depending on your request</em>
