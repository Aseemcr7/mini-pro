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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pet vibe</title>
    <link href="../web/img/favicon.png" rel="icon">
    <link rel="stylesheet" href="../web/css/styl.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <script src="../web/log.js" defer></script>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <h1>Create Account</h1>
                <span>use your email for registration</span>
                <input type="text" name="name" placeholder="Name" />
                <input type="email" name="email" placeholder="Email" />
                <input type="password" name="password" placeholder="Password" />
                <button type="submit" name="register">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h1>Sign in</h1>
                <span>use your account</span>
                <input type="email" name="email" placeholder="Email" />
                <input type="password" name="password" placeholder="Password" />
                <button type="submit" name="login">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us, please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start your journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
