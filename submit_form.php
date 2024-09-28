<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
$stmt = $conn->prepare("INSERT INTO billing_info (name, email, address, phone, message) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Set parameters and execute
if (isset($_POST['name'], $_POST['email'], $_POST['address'], $_POST['phone'], $_POST['message'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    $stmt->bind_param("sssss", $name, $email, $address, $phone, $message);

    if ($stmt->execute()) {
        // Redirect to index.html
        header("Location: index.html");
        exit(); // Ensure the script stops executing after the redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Required fields are missing.";
}

$conn->close();
?>
