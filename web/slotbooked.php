<?php
// Connect to MySQL (change these values based on your MySQL setup)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pet';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $service = isset($_POST['service']) ? $_POST['service'] : '';
    $username = isset($_POST['user_name']) ? $_POST['user_name'] : '';
    $email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
    $mobileCode = isset($_POST['mobile_code']) ? $_POST['mobile_code'] : '';
    $mobile = isset($_POST['phoneNo']) ? $_POST['phoneNo'] : '';

    // Sanitize and validate data (you may need to enhance this based on your requirements)

    // Insert data into the database
    $sql = "INSERT INTO slots_booked (service, username, email, mobile) VALUES ('$service', '$username', '$email', '$mobileCode$mobile')";

    if ($conn->query($sql) === false) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Your Slot</title>
    <link rel="stylesheet" href="../web/css/slot.css">
</head>
<body>
    <header>
        <h1>Confirm Your Slot</h1>
    </header>
    <table>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateForm();">
            <tr>
                <td class="tit"><h3>Service</h3></td>
                <td>
                    <select id="services" name="service">
                        <option value="">Select Service</option>
                        <option value="Dog Grooming">Dog Grooming</option>
                        <option value="Dog Boarding">Dog Boarding</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tit"><h3> USER NAME</h3></td>
                <td> <input type="text" id="username" name="user_name" placeholder=" Enter your name"></td>
            </tr>
            <tr>
                <td class="tit"><h3> USER EMAIL</h3></td>
                <td> <input type="email" id="EMAIL" name="user_email" placeholder=" EXAMPLE@gmail.com"></td>
            </tr>
            <tr>
                <td class="tit"><h3> MOBILE NUMBER</h3></td>
                <td>
                    <select id="mobileSelect" name="mobile_code">
                        <option value="">Select Code</option>
                        <option value="+91">+91</option>
                        <option value="+44">+44</option>
                        <option value="+1">+1</option>
                        <option value="+62">+62</option>
                        <option value="+60">+60</option>
                        <option value="+90">+90</option>
                        <option value="+84">+84</option>
                    </select>
                    <input type="number" id="mobile" name="phoneNo" placeholder="88888888">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="confirm" id="submit" value="Confirm">
                </td>
            </tr>
        </form>
    </table>

    <script>
        function validateForm() {
            const service = document.getElementById('services').value;
            const username = document.getElementById('username').value;
            const email = document.getElementById('EMAIL').value;
            const mobileCode = document.getElementById('mobileSelect').value;
            const mobile = document.getElementById('mobile').value;

            if (service === '' || username === '' || email === '' || mobileCode === '' || mobile === '') {
                alert('Please fill in all fields before submitting the form.');
                return false;
            } else {
                alert('Booked a slot successfully');
                return true;    
            }
        }
    </script>
</body>
</html>
