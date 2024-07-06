<?php
// Database configuration
$servername = "localhost"; // e.g., "localhost"
$username = "root"; // e.g., "root"
$password = ""; // e.g., "password"
$dbname = "test"; // e.g., "my_database"

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>
