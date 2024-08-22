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
  const PAID = 'FullyPaid';
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
}