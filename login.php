<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database configuration
    require_once "db_config.php";

    // Get username and password from form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // SQL query to fetch user from database
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login successful, redirect to homepage or dashboard
        $_SESSION["username"] = $username;
        header("Location: index.html");
    } else {
        // Login failed, redirect back to login page with error message
        $_SESSION["error"] = "Invalid username or password";
        header("Location: login.html");
    }
}
?>
