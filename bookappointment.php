<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $doctor_id = $_POST['doctor'];
    $appointment_date = $_POST['date'];
    $appointment_time = $_POST['time'];

    // Insert the appointment into the database
    $stmt = $conn->prepare("INSERT INTO appointments (name, email, phone, doctor_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiss", $name, $email, $phone, $doctor_id, $appointment_date, $appointment_time);

    if ($stmt->execute()) {
        echo "Appointment booked successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>
