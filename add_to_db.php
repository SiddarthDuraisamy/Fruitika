<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_config"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);

// Extract data
$name = $conn->real_escape_string($data['name']);
$email = $conn->real_escape_string($data['email']);
$address = $conn->real_escape_string($data['address']);
$phone = $conn->real_escape_string($data['phone']);
$payment_method = $conn->real_escape_string($data['payment_method']);
$order_details = json_encode($data['order_details']);
$subtotal = $data['subtotal'];
$shipping = $data['shipping'];
$total = $data['finalTotal'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO orders2 (name, email, address, phone, payment_method, order_details, subtotal, shipping, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssddd", $name, $email, $address, $phone, $payment_method, $order_details, $subtotal, $shipping, $total);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to insert data: ' . $stmt->error]);
}

// Close connection
$stmt->close();
$conn->close();
?>
