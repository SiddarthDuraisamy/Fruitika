<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database configuration
    require_once "db_config.php";

    // Get form data
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    // Check if username already exists
    $check_query = "SELECT * FROM users WHERE username='$username'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        // Username already exists, redirect back to signup page with error message
        $_SESSION["error"] = "Username already exists";
        header("Location: signup.html");
    } else {
        // Insert user into database
        $insert_query = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
        if ($conn->query($insert_query) === TRUE) {
            // Signup successful, redirect to login page
            $_SESSION["success"] = "Account created successfully. Please login.";
            header("Location: login.html");
        } else {
            // Error in inserting user, redirect back to signup page with error message
            $_SESSION["error"] = "Error: " . $conn->error;
            header("Location: signup.html");
        }
    }
}
?>
