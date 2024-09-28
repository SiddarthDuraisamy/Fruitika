<?php
// Database configuration
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

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO form_data (name, email, address, phone, bill, payment_method) VALUES (?, ?, ?, ?, ?, ? )");
$stmt->bind_param("sssssss", $name, $email, $address, $phone, $bill, $payment_method);

// Set parameters and execute
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$bill = $_POST['bill'];
$payment_method = $_POST['payment_method'];

// Handle payment proof upload if provided


$stmt->execute();

$stmt->close();
$conn->close();

// Redirect or display success message
header("Location: success.php"); // Redirect to a success page
exit();
?>
