<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require('../vendor/autoload.php');
require("razorpay_config.php");  // adjust path based on location


use Razorpay\Api\Api;



$api = new Api($key_id, $key_secret);


$payment_amount = isset($_POST['price']) ? intval($_POST['price']) : 100;

$orderData = [
    'receipt'         => 'RCP_' . mt_rand(10000, 99999),
    'amount'          => $payment_amount*100,
    'currency'        => 'INR',
    'payment_capture' => 1
];

try {
    $razorpayOrder = $api->order->create($orderData);
    echo json_encode([
        'status' => 'success',
        'order_id' => $razorpayOrder['id'],
        'amount' => $orderData['amount'],
        'currency' => $orderData['currency'],
        'key' => $key_id
    ]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
