<?php

namespace Twelver313\KapitalBank;

class DetailedOrderStatus extends OrderStatusAbstract
{
  public $hppUrl;
  public $password;
  public $terminal;
  public $srcAmount;
  public $srcAmountFull;
  public $srcCurrency;
  public $cvv2AuthStatus;
  public $authorizedChargeAmount;
  public $clearedChargeAmount;
  public $description;
  public $language;
  public $merchant;
  public $initiationEnvKind;
  public $custAttrs;
  public $reportPubs;
}