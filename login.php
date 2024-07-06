<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reg";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if the user exists
    $sql = "SELECT * FROM users WHERE user='$username' AND pass='$password'";
    $result = $conn->query($sql);

    // Check if a row is returned
    if ($result->num_rows > 0) {
        echo "Login successful";
        header("Location: home.html"); 
       
    } else {
        echo "Invalid username or password";
    }
}

// Close the database connection
$conn->close();
?>
