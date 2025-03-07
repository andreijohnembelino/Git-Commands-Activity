<?php
include('../../config/session_start.php');
header('Content-Type: application/json');
include('../../config/dbconn.php');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Retrieve the patientId from the GET request
    $patientId = $_GET['patientId'];

    // Prepare the DELETE SQL query using $conn (MySQLi)
    $query = "DELETE FROM patients WHERE patient_id = ?";
    
    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the patientId parameter to the prepared statement
        $stmt->bind_param('i', $patientId); // 'i' is the type for integer

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting patient']);
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare SQL query']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
