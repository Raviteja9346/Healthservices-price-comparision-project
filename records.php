<?php
session_start();
require 'config.php'; 
// Get user ID from session

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    $_SESSION['error_message'] = 'You must be logged in to upload records.';
    header('Location: login.php');
    exit();
}

// Get user ID from session
$user_id = $_SESSION['id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate input
    $record_type = htmlspecialchars(trim($_POST['record_type']));

    // File upload handling
    $upload_dir = 'uploads/'; // Directory where uploads will be stored
    $allowed_extensions = ['pdf', 'doc', 'docx', 'txt']; // Allowed file extensions
    $file_extension = pathinfo($_FILES['record_file']['name'], PATHINFO_EXTENSION);

    if (!in_array($file_extension, $allowed_extensions)) {
        $_SESSION['error_message'] = 'Only PDF, DOC, DOCX, or TXT files are allowed.';
        header('Location: upload_records.html');
        exit();
    }

    // Generate unique filename
    $file_name = uniqid('record_') . '.' . $file_extension;
    $target_path = $upload_dir . $file_name;

    // Move uploaded file to directory
    if (move_uploaded_file($_FILES['record_file']['tmp_name'], $target_path)) {
        // Insert record into database
        $insert_query = "INSERT INTO records (id, record_type, file_name, uploaded_at) VALUES (?, ?, ?, NOW())";
        $insert_stmt = $conn->prepare($insert_query);
        if ($insert_stmt === false) {
            $_SESSION['error_message'] = 'Database prepare error: ' . htmlspecialchars($conn->error);
            header('Location: records.php');
            exit();
        }
        $insert_stmt->bind_param('iss', $user_id, $record_type, $file_name);
        
        if ($insert_stmt->execute()) {
            $_SESSION['success_message'] = 'Record uploaded successfully.';
            header('Location: profile.php');
            exit();
        } else {
            $_SESSION['error_message'] = 'Failed to upload record. Please try again.';
            header('Location: records.php');
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Error uploading file. Please try again.';
        header('Location:records.php');
        exit();
    }
}
?>
