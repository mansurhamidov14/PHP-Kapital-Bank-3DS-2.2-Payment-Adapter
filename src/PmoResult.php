<?php

namespace Twelver313\KapitalBank;

class PmoResult
{
  const NONE = 0;
  const APPROVED = 1;
  const APPROVED_PARTIAL = 2;
  const APPROVED_PURCHASE_ONLY = 3;
  const POSTPONED = 4;
  const STRONG_CUSTOMER_AUTHENTICATION_REQUIRED = 6;
  const NEED_CHECKER_S_CONFIRMATION = 7;
  const TELEBANK_CUSTOMER_ALREADY_EXISTS = 8;
  const SHOULD_SELECT_VIRTUAL_CARD_PRODUCT = 9;
  const SHOULD_SELECT_ACCOUNT_NUMBER = 10;
  const SHOULD_CHANGE_PVV = 11;
  const CONFIRM_PAYMENT_PRECHECK = 12;
  const SELECT_BILL = 13;
  const CUSTOMER_CONFIRMATION_REQUESTED = 14;
  const ORIGINAL_TRANSACTION_NOT_FOUND = 15;
  const SLIP_ALREADY_RECEIVED = 16;
  const PERSONAL_INFORMATION_INPUT_ERROR = 17;
  const SMS_EMAIL_DYNAMIC_PASSWORD_REQUESTED = 18;
  const DPA_CAP_DYNAMIC_PASSWORD_REQUESTED = 19;
  const PREPAID_CODE_NOT_FOUND = 20;
  const CORRESPONDING_ACCOUNT_EXHAUSTED = 21;
  const ACQUIRER_LIMIT_EXCEEDED = 22;
  const CUTOVER_IN_PROCESS = 23;
  const DYNAMIC_PVV_EXPIRED = 24;
  const WEAK_PIN = 25;
  const EXTERNAL_AUTHENTICATION_REQUIRED = 26;
  const ADDITIONAL_DATA_REQUIRED = 27;
  const CLOSED_ACCOUNT = 29;
  const BLOCKED = 30;
  const LOST_CARD = 40;
  const STOLEN_CARD = 41;
  const INELIGIBLE_VENDOR_ACCOUNT = 49;
  const UNAUTHORIZED_USAGE = 50;
  const EXPIRED_CARD = 51;
  const INVALID_CARD = 52;
  const INVALID_PIN = 53;
  const SYSTEM_ERROR = 54;
  const INELIGIBLE_TRANSACTION = 55;
  const INELIGIBLE_ACCOUNT = 56;
  const TRANSACTION_NOT_SUPPORTED = 57;
  const RESTRICTED_CARD = 58;
  const INSUFFICIENT_FUNDS = 59;
  const USES_LIMIT_EXCEEDED = 60;
  const WITHDRAWAL_LIMIT_WOULD_BE_EXCEEDED = 61;
  const PIN_TRIES_LIMIT_WAS_REACHED = 62;
  const WITHDRAWAL_LIMIT_ALREADY_REACHED = 63;
  const CREDIT_AMOUNT_LIMIT = 64;
  const NO_STATEMENT_INFORMATION = 65;
  const STATEMENT_NOT_AVAILABLE = 66;
  const INVALID_AMOUNT = 67;
  const EXTERNAL_DECLINE = 68;
  const NO_SHARING = 69;
  const CONTACT_CARD_ISSUER = 71;
  const DESTINATION_NOT_AVAILABLE = 72;
  const ROUTING_ERROR = 73;
  const FORMAT_ERROR = 74;
  const EXTERNAL_DECLINE_SPECIAL_CONDITION = 75;
  const BAD_CVV = 80;
  const BAD_CVV2 = 81;
  const INVALID_TRANSACTION = 82;
  const PIN_TRIES_LIMIT_WAS_EXCEEDED = 83;
  const BAD_CAVV = 84;
  const BAD_ARQC = 85;
  const APPROVE_ADMINISTRATIVE_CARD_OPERATION_INSIDE_WINDOW = 90;
  const APPROVE_ADMINISTRATIVE_CARD_OPERATION_OUTSIDE_OF_WINDOW = 91;
  const APPROVE_ADMINISTRATIVE_CARD_OPERATION = 92;
  const SHOULD_SELECT_CARD = 93;
  const CONFIRM_ISSUER_FEE = 94;
  const INSUFFICIENT_CASH = 95;
  const APPROVED_FRICTIONLESS = 96;
  const INVALID_MERCHANT = 98;

  protected static $title_map = [
    self::NONE => "None",
    self::APPROVED => "Approved",
    self::APPROVED_PARTIAL => "Approved Partial",
    self::APPROVED_PURCHASE_ONLY => "Approved Purchase Only",
    self::POSTPONED => "Postponed",
    self::STRONG_CUSTOMER_AUTHENTICATION_REQUIRED => "Strong customer authentication required",
    self::NEED_CHECKER_S_CONFIRMATION => "Need Checker's confirmation",
    self::TELEBANK_CUSTOMER_ALREADY_EXISTS => "Telebank customer already exists",
    self::SHOULD_SELECT_VIRTUAL_CARD_PRODUCT => "Should select virtual card product",
    self::SHOULD_SELECT_ACCOUNT_NUMBER => "Should select account number",
    self::SHOULD_CHANGE_PVV => "Should change PVV",
    self::CONFIRM_PAYMENT_PRECHECK => "Confirm payment precheck",
    self::SELECT_BILL => "Select bill",
    self::CUSTOMER_CONFIRMATION_REQUESTED => "Customer confirmation requested",
    self::ORIGINAL_TRANSACTION_NOT_FOUND => "Original transaction not found",
    self::SLIP_ALREADY_RECEIVED => "Slip already received",
    self::PERSONAL_INFORMATION_INPUT_ERROR => "Personal information input error",
    self::SMS_EMAIL_DYNAMIC_PASSWORD_REQUESTED => "SMS/EMail dynamic password requested",
    self::DPA_CAP_DYNAMIC_PASSWORD_REQUESTED => "DPA/CAP dynamic password requested",
    self::PREPAID_CODE_NOT_FOUND => "Prepaid code not found",
    self::CORRESPONDING_ACCOUNT_EXHAUSTED => "Corresponding account exhausted",
    self::ACQUIRER_LIMIT_EXCEEDED => "Acquirer limit exceeded",
    self::CUTOVER_IN_PROCESS => "Cutover in process",
    self::DYNAMIC_PVV_EXPIRED => "Dynamic PVV Expired",
    self::WEAK_PIN => "Weak PIN",
    self::EXTERNAL_AUTHENTICATION_REQUIRED => "External authentication required",
    self::ADDITIONAL_DATA_REQUIRED => "Additional data required",
    self::CLOSED_ACCOUNT => "Closed account",
    self::BLOCKED => "Blocked",
    self::LOST_CARD => "Lost card",
    self::STOLEN_CARD => "Stolen card",
    self::INELIGIBLE_VENDOR_ACCOUNT => "Ineligible vendor account",
    self::UNAUTHORIZED_USAGE => "Unauthorized usage",
    self::EXPIRED_CARD => "Expired card",
    self::INVALID_CARD => "Invalid card",
    self::INVALID_PIN => "Invalid PIN",
    self::SYSTEM_ERROR => "System error",
    self::INELIGIBLE_TRANSACTION => "Ineligible transaction",
    self::INELIGIBLE_ACCOUNT => "Ineligible account",
    self::TRANSACTION_NOT_SUPPORTED => "Transaction not supported",
    self::RESTRICTED_CARD => "Restricted card",
    self::INSUFFICIENT_FUNDS => "Insufficient funds",
    self::USES_LIMIT_EXCEEDED => "Uses limit exceeded",
    self::WITHDRAWAL_LIMIT_WOULD_BE_EXCEEDED => "Withdrawal limit would be exceeded",
    self::PIN_TRIES_LIMIT_WAS_REACHED => "PIN tries limit was reached",
    self::WITHDRAWAL_LIMIT_ALREADY_REACHED => "Withdrawal limit already reached",
    self::CREDIT_AMOUNT_LIMIT => "Credit amount limit",
    self::NO_STATEMENT_INFORMATION => "No statement information",
    self::STATEMENT_NOT_AVAILABLE => "Statement not available",
    self::INVALID_AMOUNT => "Invalid amount",
    self::EXTERNAL_DECLINE => "External decline",
    self::NO_SHARING => "No sharing",
    self::CONTACT_CARD_ISSUER => "Contact card issuer",
    self::DESTINATION_NOT_AVAILABLE => "Destination not available",
    self::ROUTING_ERROR => "Routing error",
    self::FORMAT_ERROR => "Format error",
    self::EXTERNAL_DECLINE_SPECIAL_CONDITION => "External decline special condition",
    self::BAD_CVV => "Bad CVV",
    self::BAD_CVV2 => "Bad CVV2",
    self::INVALID_TRANSACTION => "Invalid transaction",
    self::PIN_TRIES_LIMIT_WAS_EXCEEDED => "PIN tries limit was exceeded",
    self::BAD_CAVV => "Bad CAVV",
    self::BAD_ARQC => "Bad ARQC",
    self::APPROVE_ADMINISTRATIVE_CARD_OPERATION_INSIDE_WINDOW => "Approve administrative card operation inside window",
    self::APPROVE_ADMINISTRATIVE_CARD_OPERATION_OUTSIDE_OF_WINDOW => "Approve administrative card operation outside of window",
    self::APPROVE_ADMINISTRATIVE_CARD_OPERATION => "Approve administrative card operation",
    self::SHOULD_SELECT_CARD => "Should select card",
    self::CONFIRM_ISSUER_FEE => "Confirm Issuer Fee",
    self::INSUFFICIENT_CASH => "Insufficient cash",
    self::APPROVED_FRICTIONLESS => "Approved frictionless",
    self::INVALID_MERCHANT => "Invalid merchant",
  ];

  protected static $description_map = [
    self::NONE => "-",
    self::APPROVED => "OK",
    self::APPROVED_PARTIAL => "Transaction is approved for the partial amount",
    self::APPROVED_PURCHASE_ONLY => "Transaction is approved for the Purchase amount; the Cashback amount is not approved",
    self::POSTPONED => "Transaction is postponed, it will be processed later",
    self::STRONG_CUSTOMER_AUTHENTICATION_REQUIRED => "Strong customer authentication is required for the transaction execution.",
    self::NEED_CHECKER_S_CONFIRMATION => "The checker confirmation is required",
    self::TELEBANK_CUSTOMER_ALREADY_EXISTS => "Telebank customer already exists",
    self::SHOULD_SELECT_VIRTUAL_CARD_PRODUCT => "Virtual card product should be selected",
    self::SHOULD_SELECT_ACCOUNT_NUMBER => "Account number should be selected",
    self::SHOULD_CHANGE_PVV => "PIN should be changed",
    self::CONFIRM_PAYMENT_PRECHECK => "The results of payment verification in the payment online acceptance system should be confirmed",
    self::SELECT_BILL => "Select the bill to be paid",
    self::CUSTOMER_CONFIRMATION_REQUESTED => "Customer confirmation is requested",
    self::ORIGINAL_TRANSACTION_NOT_FOUND => "Original transaction is not found (for example, while receiving an electronic slip from POS terminal; or an original transaction for the reversal)",
    self::SLIP_ALREADY_RECEIVED => "Slip has already been received",
    self::PERSONAL_INFORMATION_INPUT_ERROR => "Error by entering payment attributes",
    self::SMS_EMAIL_DYNAMIC_PASSWORD_REQUESTED => "SMS/Email dynamic password is requested",
    self::DPA_CAP_DYNAMIC_PASSWORD_REQUESTED => "DPA/CAP dynamic password is requested",
    self::PREPAID_CODE_NOT_FOUND => "Prepaid code is not found",
    self::CORRESPONDING_ACCOUNT_EXHAUSTED => "Agent bank correspondent account is exhausted",
    self::ACQUIRER_LIMIT_EXCEEDED => "Merchant acquiring limit has already been reached or exceeded",
    self::CUTOVER_IN_PROCESS => "Cutover is being performed",
    self::DYNAMIC_PVV_EXPIRED => "Dynamic PVV expired",
    self::WEAK_PIN => "Weak PIN",
    self::EXTERNAL_AUTHENTICATION_REQUIRED => "External authentication is requested",
    self::ADDITIONAL_DATA_REQUIRED => "Additional data is required",
    self::CLOSED_ACCOUNT => "The account is closed",
    self::BLOCKED => "Blocked",
    self::LOST_CARD => "The card is lost",
    self::STOLEN_CARD => "The card is stolen",
    self::INELIGIBLE_VENDOR_ACCOUNT => "Ineligible vendor account",
    self::UNAUTHORIZED_USAGE => "The card unauthorized usage",
    self::EXPIRED_CARD => "The card is expired",
    self::INVALID_CARD => "The card is invalid",
    self::INVALID_PIN => "Invalid PIN",
    self::SYSTEM_ERROR => "System error",
    self::INELIGIBLE_TRANSACTION => "Ineligible transaction",
    self::INELIGIBLE_ACCOUNT => "Ineligible account",
    self::TRANSACTION_NOT_SUPPORTED => "The transaction is not supported",
    self::RESTRICTED_CARD => "The card is restricted (the operation is prohibited)",
    self::INSUFFICIENT_FUNDS => "There are not enough money on the account",
    self::USES_LIMIT_EXCEEDED => "The card usage limit is exceeded",
    self::WITHDRAWAL_LIMIT_WOULD_BE_EXCEEDED => "Withdrawal limit will be exceeded",
    self::PIN_TRIES_LIMIT_WAS_REACHED => "Invalid PIN tries limit is reached",
    self::WITHDRAWAL_LIMIT_ALREADY_REACHED => "Withdrawal limit is already reached",
    self::CREDIT_AMOUNT_LIMIT => "Deposit limit is reached",
    self::NO_STATEMENT_INFORMATION => "No statement information provided",
    self::STATEMENT_NOT_AVAILABLE => "Statement is not available (prohibited)",
    self::INVALID_AMOUNT => "Invalid amount",
    self::EXTERNAL_DECLINE => "Transaction is declined by the external host",
    self::NO_SHARING => "The card is not serviced at the terminal",
    self::CONTACT_CARD_ISSUER => "Contact the issuer",
    self::DESTINATION_NOT_AVAILABLE => "The authorizer is not available",
    self::ROUTING_ERROR => "Routing error",
    self::FORMAT_ERROR => "Format error",
    self::EXTERNAL_DECLINE_SPECIAL_CONDITION => "The transaction is declined by the external host by special condition (the card owner is suspected of fraud)",
    self::BAD_CVV => "Invalid CVV",
    self::BAD_CVV2 => "Invalid CVV2",
    self::INVALID_TRANSACTION => "The transaction with such attributes is prohibited",
    self::PIN_TRIES_LIMIT_WAS_EXCEEDED => "Bad PIN tries limit is already exceeded",
    self::BAD_CAVV => "Invalid 3D Secure Cardholder Authentication Verification Value",
    self::BAD_ARQC => "Invalid cryptogram of EMC card application",
    self::APPROVE_ADMINISTRATIVE_CARD_OPERATION_INSIDE_WINDOW => "Operation by the administrative card in the window is approved",
    self::APPROVE_ADMINISTRATIVE_CARD_OPERATION_OUTSIDE_OF_WINDOW => "Operation by the administrative card out of the window is approved",
    self::APPROVE_ADMINISTRATIVE_CARD_OPERATION => "Operation by the administrative card is approved",
    self::SHOULD_SELECT_CARD => "Card should be selected",
    self::CONFIRM_ISSUER_FEE => "Issuer fee confirmation is required",
    self::INSUFFICIENT_CASH => "Insufficient funds",
    self::APPROVED_FRICTIONLESS => "Approved as Frictionless",
    self::INVALID_MERCHANT => "Invalid merchant",
  ];

  /**
   * @param string|int $code
   */
  public static function getByCode($code)
  {
    if (isset(self::$title_map[$code])) {
      return [
        'title' => self::$title_map[$code],
        'description' => self::$description_map[$code]
      ];
    }

    return null;
  }
}
