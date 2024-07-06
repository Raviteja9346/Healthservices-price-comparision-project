<?php
session_start(); // Start the PHP session

// Function to generate a random OTP (for demonstration purposes)
function generateOTP() {
    return rand(100000, 999999); // Generate a random 6-digit OTP
}

// Check if form inputs are submitted and not empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone'];
    $otp_entered = $_POST['otp'];

    // Validate OTP (for demonstration, replace with actual validation logic)
    // Here, we assume the OTP is stored in session for demonstration purposes
    if (isset($_SESSION['otp']) && $otp_entered == $_SESSION['otp']) {
        // OTP verification successful
        unset($_SESSION['otp']); // Clear OTP from session after successful verification

        // Redirect to success page or perform further actions
        header("Location: success.php");
        exit();
    } else {
        // OTP verification failed
        $error = "Invalid OTP. Please try again.";
        header("Location: otp-entry.html?error=" . urlencode($error));
        exit();
    }
} else {
    // Redirect to OTP entry page if accessed directly without POST data
    header("Location: otp-entry.html");
    exit();
}
?>
