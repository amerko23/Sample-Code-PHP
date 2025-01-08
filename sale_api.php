<?php

$valorAppId = '';
$valorAppKey = '';
$amount = 0;
$epiId = 0;

if (isset($_COOKIE['valorAmount'])) {
  $amount = $_COOKIE['valorAmount'];
}
if (isset($_COOKIE['valorEpi'])) {
  $epiId = $_COOKIE['valorEpi'];
}
if (isset($_COOKIE['valorAppId'])) {
  $valorAppId = $_COOKIE['valorAppId'];
}
if (isset($_COOKIE['valorAppKey'])) {
  $valorAppKey = $_COOKIE['valorAppKey'];
}

// Common fields for both CARD and ACH Bank
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$address1 = $_POST['address1'] ?? '';
$address2 = $_POST['address2'] ?? '';
$city = $_POST['city'] ?? '';
$state = $_POST['state'] ?? '';
$zip = $_POST['zip_code'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'];

// Determine payment method
if (!empty($_POST['card_token'])) {
  // CARD payment
  $txn_type = 'sale';
  $token = $_POST['card_token'];
  $postFields = array(
    'appid' => $valorAppId,
    'appkey' => $valorAppKey,
    'txn_type' => $txn_type,
    'amount' => $amount,
    'phone' => $phone,
    'email' => $email,
    'address1' => $address1,
    'address2' => $address2,
    'city' => $city,
    'state' => $state,
    'zip' => $zip,
    'ip' => $ip,
    'token' => $token,
    'epi' => $epiId,
    'shipping_country' => 'USA',
    'invoicenumber' => 'INV1234',
    'orderdescription' => 'My production description',
    'surchargeAmount' => '1.00',
    'surchargeIndicator' => '1',
  );
} elseif (!empty($_POST['account_number']) && !empty($_POST['routing_number'])) {
  // ACH Bank payment
  $txn_type = 'achsale';
  $accountNumber = $_POST['account_number'];
  $routingNumber = $_POST['routing_number'];
  $accountName = $_POST['account_name'];
  $accountType = $_POST['account_type'];
  $entryClass = $_POST['entry_class'];
  $transactionType = $_POST['transaction_type'];
  $postFields = array(
    'appid' => $valorAppId,
    'appkey' => $valorAppKey,
    'txn_type' => $txn_type,
    'amount' => $amount,
    'phone' => $phone,
    'email' => $email,
    'address1' => $address1,
    'address2' => $address2,
    'city' => $city,
    'state' => $state,
    'zip' => $zip,
    'ip' => $ip,
    'account_number' => $accountNumber,
    'routing_number' => $routingNumber,
    'account_name' => $accountName,
    'account_type' => $accountType,
    'entry_class' => $entryClass,
    'transaction_type' => $transactionType,
    'epi' => $epiId,
    'shipping_country' => 'USA',
    'invoicenumber' => 'INV1234',
    'orderdescription' => 'My production description',
  );
} else {
  echo json_encode(['error' => 'Invalid transaction type']);
  exit;
}

// Execute CURL request
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://securelink-staging.valorpaytech.com:4430/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => $postFields,
));

print_r($_POST);
$response = curl_exec($curl);
curl_close($curl);
echo $response;

$response_data = json_decode($response);
session_start();
$_SESSION['response'] = $response;


if (isset($response_data->error_code) && $response_data->error_code == "00") {
  header('Location: success.php');
  exit;
} else {
  header('Location: error.php');
  exit;
}
// die();
// header('Location: Thankyou.php');
