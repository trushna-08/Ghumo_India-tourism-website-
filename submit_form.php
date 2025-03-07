<?php
// Show any errors to help us find the problem
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the form
    $from = $_POST['from'];
    $to = $_POST['to'];
    $date = $_POST['date'];
    $travel_by = $_POST['travel_by'];
    $persons = $_POST['persons'];

    // Connect to the database
    $servername = "localhost"; // Your computer
    $username = "root"; // Default XAMPP username
    $password = ""; // Default XAMPP password (empty)
    $dbname = "ghumoindia"; // The database we’re using

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection worked
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Save the data into the database
    $sql = "INSERT INTO bookings (from_location, to_location, travel_date, travel_by, persons) 
            VALUES ('$from', '$to', '$date', '$travel_by', '$persons')";

    if ($conn->query($sql) === TRUE) {
        // Show a success message
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - GhumoIndia</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4" style="margin-top: 100px;">
        <div class="tourism-review-card text-center">
            <h1 class="text-3xl font-bold mb-4" style="color: #183b56;">Booking Confirmed!</h1>
            <p class="text-gray-700 mb-4">Your trip from <strong>' . htmlspecialchars($from) . '</strong> to <strong>' . htmlspecialchars($to) . '</strong> on <strong>' . htmlspecialchars($date) . '</strong> for <strong>' . htmlspecialchars($persons) . ' person(s)</strong> via <strong>' . htmlspecialchars($travel_by) . '</strong> has been booked.</p>
            <a href="index.html" class="btn btn-success">Back to Home</a>
        </div>
    </div>
</body>
</html>';
    } else {
        // Show an error message if something went wrong
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
            <h1 class="text-3xl font-bold mb-4" style="color: #183b56;">Booking Failed</h1>
            <p class="text-gray-700 mb-4">Error: ' . $conn->error . '</p>
            <a href="index.html" class="btn btn-danger">Back to Home</a>
        </div>
    </div>
</body>
</html>';
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Something went wrong. Please make sure you submitted the form correctly.";
}
?>