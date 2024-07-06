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

    // Check if the file was uploaded without errors
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        // Check if the file is a PDF
        $fileType = mime_content_type($_FILES["file"]["tmp_name"]);
        if ($fileType != 'application/pdf') {
            die("Only PDF files are allowed.");
        }

        // Read the file content
        $fileContent = file_get_contents($_FILES["file"]["tmp_name"]);
        $fileContent = $conn->real_escape_string($fileContent);

        // Update data in the database
        $sql = "UPDATE test SET result='$fileContent' WHERE email='$email'";

        if ($conn->query($sql) === TRUE) {
            if ($conn->affected_rows > 0) {
                echo "Record updated successfully.";
            } else {
                echo "No record found with the given email.";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading file.";
    }

    $conn->close();
}
?>
