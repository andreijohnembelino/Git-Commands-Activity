<?php 
header('Content-Type: application/json');
include('../config/dbconn.php');

// Function to log an action
function logAction($message) {
    global $conn;

    // Sanitize the message to prevent SQL injection (if necessary)
    $message = mysqli_real_escape_string($conn, $message);
    
    // Insert the log into the database
    $query = "INSERT INTO logs (message) VALUES ('$message')";
    if (mysqli_query($conn, $query)) {
        return true;
    } else {
        return false;
    }
}

?>