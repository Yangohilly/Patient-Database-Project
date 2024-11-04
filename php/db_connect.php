<?php
// db_connect.php
    // Database connection setup.
    $servername = "localhost"; // Adjust if necessary
    $username_db = "whitebird";     // Adjust with your DB username
    $password_db = "Crimson24";         // Adjust with your DB password
    $dbname = "users_database"; // Adjust with your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
