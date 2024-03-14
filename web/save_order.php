<?php
// Connect to MySQL (change these values based on your MySQL setup)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pet';

$conn = new mysqli($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$username = $_POST['user_name'];
$email = $_POST['user_email'];
$mobile = $_POST['phoneNo'];
$address = $_POST['add'];
$city = $_POST['city'];
$pincode = $_POST['pincode'];
$cart_items = json_encode($_POST['cart_items']); // Assuming cart_items is an array

// Sanitize and validate data (you may need to enhance this based on your requirements)

// Payment method (adjust this based on your form structure)
$payment_method = isset($_POST['payment']) ? $_POST['payment'] : '';

// Insert data into the database
$sql = "INSERT INTO orders (username, email, mobile, address, city, pincode, cart_items, payment_method) VALUES ('$username', '$email', '$mobile', '$address', '$city', '$pincode', '$cart_items', '$payment_method')";

if ($conn->query($sql) === TRUE) {
    echo "Order placed successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
