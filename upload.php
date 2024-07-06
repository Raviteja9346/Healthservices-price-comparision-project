<?php
// Check if file was uploaded without errors
if ($_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/'; // Directory where files will be uploaded
    $uploadFile = $uploadDir . basename($_FILES['fileToUpload']['name']);
    
    // Move uploaded file to specified directory
    if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadFile)) {
        echo "File is valid, and was successfully uploaded.\n";
    } else {
        echo "Upload failed.\n";
    }
} else {
    echo "File upload error.\n";
}
?>
