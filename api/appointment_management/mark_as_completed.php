<?php
session_start();
header('Content-Type: application/json');
include('../config/dbconn.php');

// Function to log actions in the system
function logAction($message) {
    global $conn;

    // Get current date and time
    $currentDateTime = date('Y-m-d H:i:s'); // Ensure correct date format
    
    // Prepare the query to insert the log message into the logs table
    $stmt = $conn->prepare("INSERT INTO logs (message, created_at) VALUES (?, ?)");
    $stmt->bind_param("ss", $message, $currentDateTime);

    // Execute the query
    if ($stmt->execute()) {
        // Log successful
    } else {
        // Handle log failure (optional)
    }

    $stmt->close();
}

// Check if POST request has been made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the incoming data
    $data = json_decode(file_get_contents('php://input'), true);

    // Ensure all necessary data is present
    if (isset($data['appointmentId']) && isset($data['completedAt'])) {
        // Sanitize the input data
        $appointmentId = mysqli_real_escape_string($conn, $data['appointmentId']);
        $completedAt = mysqli_real_escape_string($conn, $data['completedAt']);
        
        // Get the logged-in user ID (assumes session holds user_id)
        $userId = $_SESSION['user_id']; 
        
        // Update the appointment status to 'completed'
        $query = "UPDATE appointments SET status = 'completed' WHERE appointment_id = '$appointmentId'";

        if (mysqli_query($conn, $query)) {
            // Log the action with the logged-in user's ID
            $logMessage = "Appointment ID $appointmentId marked as completed by User ID $userId";
            logAction($logMessage);
            
            // Respond with success
            echo json_encode(["success" => true]);
        } else {
            // Handle error while updating the appointment status
            echo json_encode(["success" => false, "message" => "Failed to mark appointment as completed"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid data"]);
    }
}
?>
