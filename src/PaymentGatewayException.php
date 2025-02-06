<?php

namespace Twelver313\KapitalBank;

use \Exception;

class PaymentGatewayException extends Exception
{
  protected $message;
  protected $code;

  /**
   * @param string $message
   * @param string|int $code
   * @param string $type
   */
  public function __construct($message, $code = 'InternalError')
  {
    $this->message = $message;
    $this->code = $code;
  }
}
