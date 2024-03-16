<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order History</title>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
</head>
<body>

<h2>Order History</h2>

<table>
  <tr>
    <th>Order ID</th>
    <th>Username</th>
    <th>Email</th>
    <th>Mobile</th>
    <th>Address</th>
    <th>City</th>
    <th>Pincode</th>
    <th>Cart Items</th>
    <th>Payment Method</th>
    <th>Order Date</th>
    <th>Oeder Status</th>
  </tr>
  <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pet";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to retrieve order history
    $sql = "SELECT * FROM orders ORDER BY order_date DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"]. "</td>";
            echo "<td>" . $row["username"]. "</td>";
            echo "<td>" . $row["email"]. "</td>";
            echo "<td>" . $row["mobile"]. "</td>";
            echo "<td>" . $row["address"]. "</td>";
            echo "<td>" . $row["city"]. "</td>";
            echo "<td>" . $row["pincode"]. "</td>";
            echo "<td>" . $row["cart_items"]. "</td>";
            echo "<td>" . $row["payment_method"]. "</td>";
            echo "<td>" . $row["order_date"]. "</td>";
            echo "<td>";
            echo "<input type='radio' name='status_" . $row["id"] . "' value='Completed' " . ($row["order_status"] == "Completed" ? "checked" : "") . "> Completed";
            echo "<input type='radio' name='status_" . $row["id"] . "' value='In Progress' " . ($row["order_status"] == "In Progress" ? "checked" : "") . "> In Progress";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='10'>0 results</td></tr>";
    }

    $conn->close();
  ?>
</table>

</body>
</html>
