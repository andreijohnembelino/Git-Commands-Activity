<?php
include('../../config/session_start.php');
header('Content-Type: application/json');
include('../../config/dbconn.php');

// if (!isset($_SESSION['user_id'])) {
//     echo json_encode(['success' => false, 'message' => 'User not logged in']);
//     exit;
// }

try {
    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT user_id, user_name FROM users WHERE role = 'Doctor'");
    $stmt->execute();
    $result = $stmt->get_result();

    $doctors = [];
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }

    echo json_encode(['success' => true, 'doctors' => $doctors]);
     $stmt->close();

} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
} finally {
    if(isset($conn)) {
        $conn->close(); //Ensures that the connection is properly closed, regardless of any errors.
    }
}
?>