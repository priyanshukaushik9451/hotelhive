<?php
session_start();
require('../vendor/autoload.php');
require('../admin/db_confg.php');
require('../admin/essential.php');
require("razorpay_config.php");  

// Enable full error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Razorpay\Api\Api;

// Razorpay test credentials


// ✅ Log all incoming POST data
file_put_contents("debug_log.txt", "RAW POST: " . print_r($_POST, true) . "\n", FILE_APPEND);

// Check Razorpay required fields
if (
    isset($_POST['razorpay_payment_id']) &&
    isset($_POST['razorpay_order_id']) &&
    isset($_POST['razorpay_signature'])
) {
    $order_id = $_POST['razorpay_order_id'];
    $payment_id = $_POST['razorpay_payment_id'];
    $signature = $_POST['razorpay_signature'];

    // Generate signature manually
    $generated_signature = hash_hmac('sha256', $order_id . "|" . $payment_id, $key_secret);

    if ($generated_signature === $signature) {
        // ✅ Signature is valid

        if (!isset($_SESSION['uid'])) {
            die("❌ Session expired. Please login again.");
        }

        // Prepare all fields
        $user_id = $_SESSION['uid'];
        $room_id = $_POST['room_id'];
        $name = $_POST['name'];
        $number = $_POST['number'];
        $address = $_POST['address'];
        $checkin = $_POST['checkin'];
        $checkout = $_POST['checkout'];
        $price = $_POST['price'];

        $status = 1;

        $query = "INSERT INTO bookings 
            (user_id, room_id, name, phone, address, checkin, checkout, price, payment_id, order_id, status, booking_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        $result = insert($query, [
            $user_id,
            $room_id,
            $name,
            $number,
            $address,
            $checkin,
            $checkout,
            $price,
            $payment_id,
            $order_id,
            $status
        ], 'iisssssissi');

        if ($result) {
            echo "✅ Payment successful. Booking confirmed.";
            unset($_SESSION['room']);
        } else {
            echo "❌ Payment success, but failed to save booking.";
        }
    } else {
        echo "❌ Razorpay signature mismatch. Payment not recorded.";
    }
} else {
    echo "❌ Required Razorpay fields missing.";
}
