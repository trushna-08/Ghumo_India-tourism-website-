<?php
// Start session to track the logged-in user
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ghumoindia";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize to prevent SQL injection
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Query to check if the email exists in the users table
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        // Verify the password (compares entered password with hashed password)
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            // Redirect to home page
            header("Location: index.html");
            exit();
        } else {
            // Password is incorrect
            echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - GhumoIndia</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4" style="margin-top: 100px;">
        <div class="tourism-review-card text-center">
            <h1 class="text-3xl font-bold mb-4" style="color: #183b56;">Login Failed</h1>
            <p class="text-gray-700 mb-4">Incorrect password. Please try again.</p>
            <a href="index.html" class="btn btn-danger">Back to Home</a>
        </div>
    </div>
</body>
</html>';
        }
    } else {
        // Email not found
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - GhumoIndia</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4" style="margin-top: 100px;">
        <div class="tourism-review-card text-center">
            <h1 class="text-3xl font-bold mb-4" style="color: #183b56;">Login Failed</h1>
            <p class="text-gray-700 mb-4">Email not found. Please sign up first.</p>
            <a href="index.html" class="btn btn-danger">Back to Home</a>
        </div>
    </div>
</body>
</html>';
    }
} else {
    // If the page is accessed directly without a POST request, redirect to home
    header("Location: index.html");
    exit();
}

// Close the database connection
$conn->close();
?>