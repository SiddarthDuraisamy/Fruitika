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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    $token = $_POST['token'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO contact_form (name, email, phone, subject, message, token) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $phone, $subject, $message, $token);

    // Execute the query
    if ($stmt->execute()) {
        echo "New record created successfully";
        // Redirect to a thank you page or display a success message
        header("Location: contact.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
