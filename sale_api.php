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

$token = $_POST['card_token'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip_code'];
$ip =  $_SERVER['REMOTE_ADDR'];

#$card_num = $_POST['cardnumber'];
#$card_exp = $_POST['ccexp'];
#$card_cvv = $_POST['cccvv'];

#$card_num = str_replace(' ', '', $card_num);
#$card_exp = str_replace(' / ', '', $card_exp);

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://securelink-staging.valorpaytech.com:4430//',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array(
    'appid' => $valorAppId,
    'appkey' => $valorAppKey,
    'txn_type' => 'sale',
    'amount' =>  $amount,
    'phone' => $phone,
    'email' => $email,
    'address1' => $address1,
    'address2' => $address2,
    'city' => $city,
    'state' => $state,
    'zip' => $zip,
    'ip' => $ip,
    #'cardnumber' => $card_num,
    #'cvv' => $card_cvv,
    #'expirydate' => $card_exp,
    #'cardholdername' => 'ABUBACKER N',
    'token' => $token,
    'epi' => $epiId,
    'shipping_country' => 'USA',
    'invoicenumber' => 'INV1234',
    'orderdescription' => 'My produciton description ',
    'surchargeAmount' => '1.00',
    'surchargeIndicator' => '1'
  ),

));
print_r($_POST);
$response = curl_exec($curl);
curl_close($curl);
echo $response;
$response_data = json_decode($response);
session_start();
$_SESSION['response'] = $response;


if ($response_data->error_code == "00") {
  header('Location: success.php');
  exit;
} else {
  header('Location: error.php');
  exit;
}
// die();
// header('Location: Thankyou.php');
