<?php

namespace Twelver313\KapitalBank;

/**
 * @property string $approvalCode
 * @property string $pmoResultCode
 * @property object $match
 */
class RefundResponse
{
  public $approvalCode;
  public $match;
  public $pmoResultCode;

  /**
   * @throws \Twelver313\KapitalBank\PaymentGatewayException
   */
  public function __construct($options)
  {
    if (empty($options) || !is_array($options)) {
      throw new \Twelver313\KapitalBank\PaymentGatewayException('Invalid options');
    }

    foreach ($options as $key => $value) {
      if (property_exists($this, $key)) {
        $this->{$key} = $value;
      }
    }
  }
}
