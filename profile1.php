<?php
// Retrieve POST data from form submission
$fullName = $_POST['fullName'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$age = $_POST['age'];
$medicalRecords = $_POST['medicalRecords'];

// Database connection details
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "dbname";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to insert user data into database
$sql = "INSERT INTO user_profiles (fullName, email, dob, phone, address, age, medicalRecords)
        VALUES ('$fullName', '$email', '$dob', '$phone', '$address', '$age', '$medicalRecords')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
