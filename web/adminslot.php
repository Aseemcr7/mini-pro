<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #6E797B ;
        }
        td{
            background-color: #FFFFE4;
        }
    </style>
</head>
<body>

<h2>Order History</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Service</th>
        <th>Username</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Booking Date</th>
    </tr>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "pet";

    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to retrieve order history
    $sql = "SELECT * FROM slots_booked ORDER BY booking_date ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["id"]."</td>
                    <td>".$row["service"]."</td>
                    <td>".$row["username"]."</td>
                    <td>".$row["email"]."</td>
                    <td>".$row["mobile"]."</td>
                    <td>".$row["booking_date"]."</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No orders found</td></tr>";
    }

    $conn->close();
    ?>
</table>

</body>
</html>
