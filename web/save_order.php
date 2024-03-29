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
$username = isset($_POST['user_name']) ? $_POST['user_name'] : '';
$email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
$mobile = isset($_POST['phoneNo']) ? $_POST['phoneNo'] : '';
$address = isset($_POST['add']) ? $_POST['add'] : '';
$city = isset($_POST['city']) ? $_POST['city'] : '';
$pincode = isset($_POST['pincode']) ? $_POST['pincode'] : '';
$cart_items = isset($_POST['cart_items']) ? json_encode($_POST['cart_items']) : ''; // Assuming cart_items is an array

// Payment method (adjust this based on your form structure)
$payment_method = isset($_POST['payment']) ? $_POST['payment'] : '';

// Insert data into the database
$sql = "INSERT INTO orders (username, email, mobile, address, city, pincode, cart_items, payment_method) 
        VALUES ('$username', '$email', '$mobile', '$address', '$city', '$pincode', '$cart_items', '$payment_method')";

if ($conn->query($sql) === FALSE) {
    echo "we regret to inform that an error occured during order processing. please try again later";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../web/css/order.css">
</head>
<body>
    <header>
        <h1>Checkout</h1>
    </header>
    <table>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateForm();">
            <!-- ... (your user details input fields) ... -->
            <tr>
                <td><h3>USER NAME </h3></td>
                <td> <input type="text" id="username" name="user_name" placeholder=" Enter your name"></td>
            </tr>
            <tr>
                <td><h3> USER EMAIL </h3></td>
                <td> <input type="email" id="EMAIL" name="user_email" placeholder=" EXAMPLE@gmail.com"></td>
            </tr>
            <tr>
                <td><h3> MOBILE NUMBER </h3></td>
                <td>
                    <select id="mobileSelect">
                        <option>+91</option>
                        <option>+44</option>
                        <option>+1</option>
                        <option>+62</option>
                        <option>+60</option>
                        <option>+90</option>
                        <option>+84</option>
                    </select>
                    <input type="number" id="mobile" name="phoneNo" placeholder="88888888">
                </td>
            </tr>
            <tr>
                <td><h3> ADDRESS </h3></td>
                <td><input type="text" id="address" name="add" placeholder="Delivery Address"></td>
            </tr>
            <tr>
                <td><h3> CITY</h3></td>
                <td><input type="text" id="city" name="city" placeholder="Enter the city name"></td>
            </tr>

            <tr>
                <td><h3> PINCODE</h3></td>
                <td><input type="number" id="pincode" name="pincode" placeholder="600071"></td>
            </tr>

            <!-- Display cart items on the checkout page -->
            <tr>
                <td><h1>CART ITEMS</h1></td>
            </tr>
            <tr>
                <td>
                    <div id="checkoutCartList"></div>
                    <input type="hidden" name="cart_items" id="cart_items" value="">
                </td>
            </tr>

            <!-- Payment section and confirm button -->
            <tr>
                <td><h1>PAYMENT</h1></td>
            </tr>
            <tr>
                <td>
                    <input type="radio" id="gpay" name="payment" value="GPAY"> GPAY
                    <input type="radio" id="PHONEPAY" name="payment" value="PHONEPAY"> PHONEPAY
                    <input type="radio" id="PAYTM" name="payment" value="PAYTM"> PAYTM
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
    const storedCart = localStorage.getItem('cart');
    const cart = storedCart ? JSON.parse(storedCart) : [];

    // Display cart items on the checkout page
    const checkoutCartListElement = document.getElementById('checkoutCartList');
    const cartItemsInput = document.getElementById('cart_items');

    cart.forEach(item => {
        const newItem = document.createElement('div');
        newItem.classList.add('item');
        newItem.innerHTML = `
            <div class="name">${item.name}</div>
            <div class="totalPrice">$${item.price * item.quantity}</div>
            <div class="quantity">${item.quantity}</div>
        `;
        checkoutCartListElement.appendChild(newItem);
    });

    // Set cart items value to the hidden input field before form submission
    cartItemsInput.value = JSON.stringify(cart);

    function validateForm() {
        const username = document.getElementById('username').value;
        const email = document.getElementById('EMAIL').value;
        const mobile = document.getElementById('mobile').value;
        const address = document.getElementById('address').value;
        const city = document.getElementById('city').value;
        const pincode = document.getElementById('pincode').value;

        if (username === '' || email === '' || mobile === '' || address === '' || city === '' || pincode === '') {
            alert('Please fill in all personal details before submitting the form.');
            return false;
        }else{
            alert('Your order has been successfully placed, and delivery is expected within the next fortnight. ');
            return true;
        }
    }
</script>

</body>
</html>
