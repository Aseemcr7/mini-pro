<?php
// Connect to your MySQL database (replace with your database credentials)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pet';

$conn =  mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get user type from the database based on user ID
function getUserType($userId, $conn) {
    $query = "SELECT user_type FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->bind_result($userType);
    $stmt->fetch();
    $stmt->close();

    return $userType;
}

// Function to authenticate the user
function authenticateUser($email, $password, $conn) {
    $query = "SELECT id FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $stmt->bind_result($userId);
    $stmt->fetch();
    $stmt->close();

    return $userId;
}

// Function to register a new user
function registerUser($name, $email, $password, $conn) {
    $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $name, $email, $password);
    $stmt->execute();
    $stmt->close();
}

// Example usage for registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Register the new user
    registerUser($name, $email, $password, $conn);

    // Optionally, you can redirect the user after successful registration
    header('Location: pet.html');
    exit();
}

// Example usage for login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Authenticate user
    $userId = authenticateUser($email, $password, $conn);

    if ($userId) {
        // Get user type
        $userType = getUserType($userId, $conn);

        // Redirect based on user type
        if ($userType === 'admin') {
            header('Location: admpg.html');
            exit();
        } elseif ($userType === 'user') {
            header('Location: pet.html');
            exit();
        } else {
            // Handle other cases or errors
        }
    } else {
        // Invalid credentials, handle accordingly
        echo "Invalid credentials";
    }
}

// Close the database connection
$conn->close();
?>
