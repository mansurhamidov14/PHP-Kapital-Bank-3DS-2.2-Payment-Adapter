<?php

namespace Twelver313\KapitalBank;

/**
 * @property string $approvalCode
 * @property string $actionId
 * @property string $billingStatus
 * @property string $dateTime
 * @property float $amount
 * @property float $clearAmount
 * @property string $currency
 * @property bool $isReversal
 * @property string $type
 * @property string $description
 * @property PmoResult $result
 */
class Transaction
{
  public $approvalCode;
  public $actionId;
  public $billingStatus;
  public $dateTime;
  public $amount;
  public $currency;
  public $description;
  public $isReversal;
  public $type;
  public $result;

  /**
   * @property object $options
   */
  public function __construct($options)
  {
    $this->approvalCode = $options->approvalCode ?? null;
    $this->actionId = $options->actionId;
    $this->billingStatus = $options->billingStatus;
    $this->isReversal = $options->isReversal;
    $this->amount = floatval($options->amount);
    $this->clearAmount = floatval($options->clearAmount ?? 0);
    $this->currency = $options->currency;
    $this->dateTime = $options->regTime;
    $this->type = $options->type;
    $this->description = $options->description;
    $this->result = PmoResult::fromCode($options->pmoResultCode);
  }
}
