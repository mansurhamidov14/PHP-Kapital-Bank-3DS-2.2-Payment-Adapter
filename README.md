# Kapital Bank Payment Gateway integration library

## Table of Contents

- [1. Installation](#1-installation)
    - [1.1 Add the lines below to your `composer.json`](#11-add-the-lines-below-to-your-composerjson)
    - [1.2 Install the package](#12-install-the-package)
- [2. Usage](#2-usage)
    - [2.1 Initialize payment gateway adapter](#21-initialize-payment-gateway-adapter)
    - [2.2 Create order](#22-create-order)
    - [2.3 Refunding](#23-refunding)
    - [2.4 Get order status](#24-get-order-status)

## 1. Installation
### 1.1 Add the lines below to your `composer.json`:

```json
{
  ...
  "require": {
    ...
    "twelver313/kapital-bank": "dev-master"
  },
  "config": {
    ...
    "github-oauth": {
      "github.com": "<GITHUB_ACCESS_TOKE>"
    }
  },
  "repositories": {
    ...
    {
      "type": "vcs",
      "name": "twelver313/kapital-bank",
      "url": "https://github.com/mansurhamidov14/Kapital-Bank-3DS-2.2-Payment-Adapter-PHP-.git",
      "branch": "master"
    }
  }
}
```

### 1.2 Install the package
```composer update twelver313/kapital-bank```

## 2. Usage
### 2.1 Initialize payment gateway adapter
```php
use Twelver313\KapitalBank\PaymentGatewayAdapter;

$paymentGateway = new PaymentGatewayAdapter([
  'login': '<YOUR_LOGIN>',
  'password' => '<YOUR_PASSWORD>',
  'isDev' => true, // Optional flag for using Kapital-Bank's test environment
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

$paymentResult = $paymentGateway->getOrderStatus([
  'id' => <ORDER_ID>,
  'password' => '<ORDER_PASSWORD>' 
]);
$status = $paymentResult->status;

// Do any stuff depending on status
if ($status === OrderStatus::CANCELED) {
  ...
}
if ($status === OrderStatus::DECLINED) {
  ...
}
if ($status === OrderStatus::FULLY_PAID) {
  ...
}
if ($status === OrderStatus::EXPIRED) {
  ...
}
if ($status === OrderStatus::REFUNDED) {
  ...
}
```

### 2.5 Restore order
```php
$orderParams = [
  'id' => <ORDER_ID>,
  'password' => '<ORDER_PASSWORD>' 
];
$paymentResult = $paymentGateway->getOrderStatus($orderParams);

/** Restoring order if it was not finished or expired */
if ($paymentResult->isPreparing()) {
  $order = $paymentGateway->restoreOrder($orderParams);
  $order->navigateToPaymentPage();
}
```
