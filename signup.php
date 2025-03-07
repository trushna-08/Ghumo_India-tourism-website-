<?php
// Show errors to help us debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session (we'll use this later for login)
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ghumoindia";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
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
            <h1 class="text-3xl font-bold mb-4" style="color: #183b56;">Sign Up Failed</h1>
            <p class="text-gray-700 mb-4">Passwords do not match. Please try again.</p>
            <a href="index.html" class="btn btn-danger">Back to Home</a>
        </div>
    </div>
</body>
</html>';
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check);
    if ($result->num_rows > 0) {
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
            <h1 class="text-3xl font-bold mb-4" style="color: #183b56;">Sign Up Failed</h1>
            <p class="text-gray-700 mb-4">Email already exists. Please use a different email.</p>
            <a href="index.html" class="btn btn-danger">Back to Home</a>
        </div>
    </div>
</body>
</html>';
        exit();
    }

    // Insert new user
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
    if ($conn->query($sql) === TRUE) {
        // Redirect to homepage on success
        header("Location: index.html");
        exit();
    } else {
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
            <h1 class="text-3xl font-bold mb-4" style="color: #183b56;">Sign Up Failed</h1>
            <p class="text-gray-700 mb-4">Error: ' . $conn->error . '</p>
            <a href="index.html" class="btn btn-danger">Back to Home</a>
        </div>
    </div>
</body>
</html>';
    }
}

$conn->close();
?>