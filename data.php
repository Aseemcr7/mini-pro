<?php
// data.php

// Connect to MySQL
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pet';

$conn = new mysqli($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data and insert into database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['user_name']) ? $_POST['user_name'] : '';
    $email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
    $mobile = isset($_POST['phoneNo']) ? $_POST['phoneNo'] : '';
    $address = isset($_POST['add']) ? $_POST['add'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $pincode = isset($_POST['pincode']) ? $_POST['pincode'] : '';
    $cart_items_json = isset($_POST['cart_items']) ? $_POST['cart_items'] : '';
    $payment_method = isset($_POST['payment']) ? $_POST['payment'] : '';

    // Decode the JSON string to an array
    $cart_items = json_decode($cart_items_json, true);

    // Calculate total price
    $totalPrice = 0;
    foreach ($cart_items as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }

    $sql = "INSERT INTO orders (username, email, mobile, address, city, pincode, cart_items, payment_method, total_price) 
            VALUES ('$username', '$email', '$mobile', '$address', '$city', '$pincode', '$cart_items_json', '$payment_method', '$totalPrice')";

    if ($conn->query($sql) === FALSE) {
        echo "we regret to inform that an error occurred during order processing. please try again later";
    } else {
        header("Location: thank.html");
        exit(); 
    }
}

$conn->close();
?>
