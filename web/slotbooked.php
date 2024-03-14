<?php
// Connect to MySQL (change these values based on your MySQL setup)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pet';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$service = $_POST['service'];
$username = $_POST['user_name'];
$email = $_POST['user_email'];
$mobile = $_POST['phoneNo'];

// Sanitize and validate data (you may need to enhance this based on your requirements)

// Insert data into the database
$sql = "INSERT INTO slots_booked (service, username, email, mobile) VALUES ('$service', '$username', '$email', '$mobile')";

if ($conn->query($sql) === false) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
