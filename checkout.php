<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Page</title>
</head>
<body>
    <div id="content">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "db_config";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Collect form data
            $name = $_POST['name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $payment_method = $_POST['payment'];
            $order_details = json_encode($_POST['order_details']); // Assuming order details are passed as an array

            // Insert into database
            $sql = "INSERT INTO orders (name, email, address, phone, payment_method, order_details) VALUES ('$name', '$email', '$address', '$phone', '$payment_method', '$order_details')";

            if ($conn->query($sql) === TRUE) {
                $order_id = $conn->insert_id;   

                // Generate receipt
                $receipt = "
                <h1>Order Receipt</h1>
                <p>Order ID: $order_id</p>
                <p>Name: $name</p>
                <p>Email: $email</p>
                <p>Address: $address</p>
                <p>Phone: $phone</p>
                <p>Payment Method: $payment_method</p>
                <h2>Order Details</h2>
                ";

                echo $receipt;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }

        // The JSON string
        $json_string = "{\"Strawberry\": \"$85.00\", \"Berry\": \"$70.00\", \"Lemon\": \"$35.00\"}";

        // Decode the JSON string
        $order_details = json_decode($json_string, true);

        // Start the HTML table
        echo "<table border='1'>
        <tr>
            <th>Item</th>
            <th>Price</th>
        </tr>";

        // Loop through the order details and add rows to the table
        foreach ($order_details as $item => $price) {
            echo "<tr>
                <td>$item</td>
                <td>$price</td>
            </tr>";
        }

        // Close the table
        echo "</table>";
        ?>
    </div>
    <button id="printPage">Print Page</button>

    <script>
        document.getElementById('printPage').addEventListener('click', function() {
            window.print();
        });
    </script>
</body>
</html>
