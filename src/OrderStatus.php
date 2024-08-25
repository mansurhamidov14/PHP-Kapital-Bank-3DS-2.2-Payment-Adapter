<?php

namespace Twelver313\KapitalBank;

use Exception;

class OrderStatus
{
  public $id;
  public $status;
  public $typeRid;
  public $prevStatus;
  public $lastStatusLogin;
  public $amount;
  public $currency;
  public $createTime;
  public $finishTime;
  public $title;
  public $type;

  const DECLINED = 'Declined';
  const PREPARING = 'Preparing';
  const FULLY_PAID = 'FullyPaid';
  const CANCELED = 'Cancelled';
  const EXPIRED = 'Expired';
  const REFUNDED = 'Refunded';

  /**
   * @throws Exception
   */
  public function __construct($options)
  {
    if (empty($options) || !is_array($options)) {
      throw new Exception('Invalid options');
    }

    foreach ($options as $key => $value) {
      $this->{$key} = is_array($value) ? (object)$value : $value;
    }
  }

  public function isPreparing()
  {
    return $this->status == self::PREPARING;
  }

  public function isFullyPaid()
  {
    return $this->status == self::FULLY_PAID;
  }

  public function isCanceled()
  {
    return $this->status == self::CANCELED;
  }

  public function isExpired()
  {
    return $this->status == self::EXPIRED;
  }

  public function isRefunded()
  {
    return $this->status == self::REFUNDED;
  }

  public function isDeclined()
  {
    return $this->status == self::DECLINED;
  }

  /**
   * @throws Exception
   */
  public function isOneOf($statuses) {
    if (!is_array($statuses)) {
      throw new Exception('"$statuses" should be an array');
    }

    return in_array($this->status, $statuses);
  }
}