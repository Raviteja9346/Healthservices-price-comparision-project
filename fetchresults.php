<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Fetch the BLOB data
    $sql = "SELECT result FROM test WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();

    if ($result) {
        // Set headers to display the PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="result.pdf"');
       
    } else {
        echo "No results found for the given email.";
    }

    $stmt->close();
}

$conn->close();
?>
