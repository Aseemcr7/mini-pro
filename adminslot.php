<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
     <style>
        body {
            background-color: #f0f0f0; /* Light gray background */
            font-family: Arial, sans-serif; /* Font family */
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333; /* Dark gray text color */
            padding-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f9f9f9; /* Light gray background for the table */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Shadow effect */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #3498db; /* Blue background for table header */
            color: #fff; /* White text color for table header */
        }

        td {
            background-color: #fff; /* White background for table cells */
        }

        tr:nth-child(even) td {
            background-color: #f2f2f2; /* Alternate row color */
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
        <th>Service Date</th> 
    </tr>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "pet";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM slots_booked ORDER BY booking_date ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["id"]."</td>
                    <td>".$row["service"]."</td>
                    <td>".$row["username"]."</td>
                    <td>".$row["email"]."</td>
                    <td>".$row["mobile"]."</td>
                    <td>".$row["booking_date"]."</td>
                    <td>".$row["service_date"]."</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No orders found</td></tr>";
    }

    $conn->close();
    ?>
</table>

</body>
</html>