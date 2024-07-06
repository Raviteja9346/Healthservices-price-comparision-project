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

    // Check if the selected time slot is already booked
    $stmt = $conn->prepare("SELECT COUNT(*) FROM booked_time_slots WHERE doctor_id = ? AND date = ? AND time = ?");
    $stmt->bind_param("iss", $doctor_id, $appointment_date, $appointment_time);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "The selected time slot is already booked. Please choose a different time slot.";
    } else {
        // Insert the appointment into the database
        $stmt = $conn->prepare("INSERT INTO appointments (name, email, phone, doctor_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $name, $email, $phone, $doctor_id, $appointment_date, $appointment_time);

        if ($stmt->execute()) {
            echo "Appointment booked successfully.";

            // Mark the time slot as booked
            $stmt = $conn->prepare("INSERT INTO booked_time_slots (doctor_id, date, time) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $doctor_id, $appointment_date, $appointment_time);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>
