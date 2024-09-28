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
    $comment = htmlspecialchars($_POST['comment']);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO comments (name, email, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $comment);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to single-news.html after successful submission
        header("Location: single-news.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
