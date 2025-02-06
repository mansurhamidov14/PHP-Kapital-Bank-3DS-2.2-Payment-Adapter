<?php

namespace Twelver313\KapitalBank;

use Exception;

/**
 * @method bool isAuthorized() Order has been authorized (Authorization transaction is executed).
 * @method bool isPreparing() Order is being prepared, no transactions have been executed on it yet.
 * @method bool isRejected() Order has been rejected by the PSP (before payment). (Order is rejected by the PSP)
 * @method bool isCanceled() Order has been cancelled by the consumer (before payment). (Order is cancelled by the merchant)
 * @method bool isCancelled() Order has been cancelled by the consumer (before payment). (Order is cancelled by the merchant)
 * @method bool isRefused() Consumer has refused to pay for the order (before payment or after unsuccessful payment attempt). (Order is refused by the consumer)
 * @method bool isExpired() Order has expired (before payment). (Timeout occurs when executing the order scenario)
 * @method bool isPartiallyPaid() Order has been partially paid (Clearing transaction is executed for the part of the order amount).
 * @method bool isFullyPaid() Order has been fully paid (Clearing transaction is executed for the full order amount (or several clearing transactions)).
 * @method bool isFunded() Order has been funded (debit transaction has been executed). The status can be assigned only to the order of the DualStep Transfer Order class.
 * @method bool isRefunded() Accounted payment amount and the accounted refund amount under the order are equal.
 * @method bool isDeclined()
 * a) AReq and RReq (3DS 2) could not be executed due to rejection by the issuer / error during authentication
 * b) Operation was declined by PMO
 * @method bool isClosed() Order has been closed (after payment).
 * @method bool isVoided() Authorized payment amount under the order is zero.
 */
class OrderStatusAbstract
{
  /** @var int id of order */
  public $id;

  /** @var string Order status */
  public $status;

  /** @var string|null Previous status of order */
  public $prevStatus;

  public $lastStatusLogin;

  /** @var double|int Order amount */
  public $amount;

  /** @var string Currency of order */
  public $currency;

  /** @var string Order creation time. Format: YYYY-MM-DD HH:mm:ss. Timezone: Asia/Baku */
  public $createTime;

  /** @var string|null Order finish time. Format: YYYY-MM-DD HH:mm:ss. Timezone: Asia/Baku */
  public $finishTime;
  public $title;

  /** @var object Object representation of order type */
  public $type;

  /** @var string Order has been cancelled by the consumer (before payment). (Order is cancelled by the merchant) */
  const CANCELED = 'Cancelled';

  /** @var string Order has been rejected by the PSP (before payment). (Order is rejected by the PSP) */
  const REJECTED = 'Rejected';

  /** @var string Consumer has refused to pay for the order (before payment or after unsuccessful payment attempt). (Order is refused by the consumer) */
  const REFUSED = 'Refused';

  /** @var string Order has expired (before payment). (Timeout occurs when executing the order scenario) */
  const EXPIRED = 'Expired';

  /** @var string Order has been authorized (Authorization transaction is executed). */
  const AUTHORIZED = 'Authorized';

  /** @var string Order has been partially paid (Clearing transaction is executed for the part of the order amount). */
  const PARTIALLY_PAID = 'PartiallyPaid';

  /** @var string Order has been fully paid (Clearing transaction is executed for the full order amount (or several clearing transactions)). */
  const FULLY_PAID = 'FullyPaid';

  /** @var string Order has been funded (debit transaction has been executed). The status can be assigned only to the order of the DualStep Transfer Order class. */
  const FUNDED = 'Funded';

  /** @var string 
   * * AReq and RReq (3DS 2) could not be executed due to rejection by the issuer / error during authentication.
   * * Operation was declined by PMO
   */
  const DECLINED = 'Declined';

  /** @var string Authorized payment amount under the order is zero. */
  const VOIDED = 'Voided';

  /** @var string Accounted payment amount and the accounted refund amount under the order are equal. */
  const REFUNDED = 'Refunded';

  /** @var string Order has been closed (after payment). */
  const CLOSED = 'Closed';

  /** @var string Order is being prepared, no transactions have been executed on it yet. */
  const PREPARING = 'Preparing';

  /**
   * @throws \Twelver313\KapitalBank\PaymentGatewayException
   */
  public function __construct($options)
  {
    if (empty($options) || !is_object($options)) {
      throw new PaymentGatewayException('Invalid options');
    }

    foreach ($options as $key => $value) {
      $this->{$key} = $value;
    }
  }

  public function __call($name, $args)
  {
    if (substr($name, 0, 2) != 'is') {
      throw new Exception('Calling to unknown method: ' . $name);
    }

    $checkStatus = substr($name, 2);
    if ($checkStatus == 'Canceled') {
      $checkStatus = self::CANCELED;
    }
    return $this->status === $checkStatus;
  }

  /**
   * @param array $statuses
   * @throws \Twelver313\KapitalBank\PaymentGatewayException
   */
  public function isOneOf($statuses) {
    if (!is_array($statuses)) {
      throw new PaymentGatewayException('"$statuses" should be an array');
    }

    return in_array($this->status, $statuses);
  }
}