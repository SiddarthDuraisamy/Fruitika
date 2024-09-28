<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_config";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM orders WHERE id = $order_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Bill</title>
        <style>
            /* Add some basic styles */
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            .order-details {
                margin-bottom: 20px;
            }
            .order-details th, .order-details td {
                padding: 10px;
                border-bottom: 1px solid #ddd;
            }
            .payment-screenshot img {
                max-width: 100%;
                height: auto;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Order Bill</h1>
                <p>Order ID: <?php echo $order['id']; ?></p>
            </div>
            <div class="order-details">
                <table>
                    <tr>
                        <th>Name</th>
                        <td><?php echo htmlspecialchars($order['name']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($order['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?php echo htmlspecialchars($order['address']); ?></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><?php echo htmlspecialchars($order['phone']); ?></td>
                    </tr>
                    <tr>
                        <th>Message</th>
                        <td><?php echo htmlspecialchars($order['message']); ?></td>
                    </tr>
                    <tr>
                        <th>Payment Method</th>
                        <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                    </tr>
                    <?php if ($order['payment_method'] == 'gpay' && $order['payment_screenshot']) : ?>
                    <tr>
                        <th>Payment Screenshot</th>
                        <td class="payment-screenshot">
                            <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($order['payment_screenshot']) . '" alt="Payment Screenshot">'; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "Order not found.";
}
$conn->close();
?>
