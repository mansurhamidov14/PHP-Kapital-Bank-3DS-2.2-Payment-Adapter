<?php

namespace Twelver313\KapitalBank;

use Exception;

class RefundResponse
{
  public $approvalCode;
  public $match;
  public $pmoResultCode;

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