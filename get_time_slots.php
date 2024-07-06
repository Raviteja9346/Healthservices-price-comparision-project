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

$doctor_id = $_GET['doctor_id'];
$date = $_GET['date'];

$availableTimeSlots = [
    1 => ['2024-06-21' => ['09:00', '10:00', '11:00'], '2024-06-22' => ['14:00', '15:00', '16:00']],
    2 => ['2024-06-21' => ['09:00', '10:00', '11:00'], '2024-06-22' => ['14:00', '15:00']],
    3 => ['2024-06-21' => ['10:00', '11:00'], '2024-06-22' => ['14:00', '15:00', '16:00']],
];

$bookedTimeSlots = [];
$sql = "SELECT time FROM booked_time_slots WHERE doctor_id = ? AND date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $doctor_id, $date);
$stmt->execute();
$stmt->bind_result($time);

while ($stmt->fetch()) {
    $bookedTimeSlots[] = $time;
}

$stmt->close();

$doctorSlots = $availableTimeSlots[$doctor_id][$date] ?? [];
$availableSlots = array_diff($doctorSlots, $bookedTimeSlots);

echo json_encode($availableSlots);

// Close the database connection
$conn->close();
?>
