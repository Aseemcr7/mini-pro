<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order History</title>
<style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif; 
            margin: 0;
            padding: 0;
            color: #333; 
        }

        h2 {
            text-align: center;
            padding-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: transparent;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50; 
            color: #fff; 
        }

        td {
            background-color: rgba(255, 255, 255, 0.8); /* Transparent white background for table cells */
        }

        tr:nth-child(even) td {
            background-color: rgba(255, 255, 255, 0.9); /* Transparent white background for alternate rows */
        }
    </style></head>
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
    <th>Total price</th>
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

    $totalRevenue = 0;

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
            echo "<td>" . $row["total_price"]. "</td>";
            echo "<td>" . $row["payment_method"]. "</td>";
            echo "<td>" . $row["order_date"]. "</td>";
            echo "<td>";
            echo "<input type='radio' name='status_" . $row["id"] . "' value='Completed' " . ($row["order_status"] == "Completed" ? "checked" : "") . "> Completed";
            echo "<input type='radio' name='status_" . $row["id"] . "' value='In Progress' " . ($row["order_status"] == "In Progress" ? "checked" : "") . "> In Progress";
            echo "</td>";
            echo "</tr>";

            // Calculate total revenue
            $totalRevenue += $row["total_price"];
        }
    } else {
        echo "<tr><td colspan='10'>0 results</td></tr>";
    }

    $conn->close();
  ?>
</table>

<?php
// Calculate estimated profit
$estimatedProfit = $totalRevenue * 0.4;

// Display total revenue and estimated profit
echo "<p>Total Revenue: $totalRevenue</p>";
echo "<p>Estimated Profit: $estimatedProfit</p>";
?>

</body>
</html>
