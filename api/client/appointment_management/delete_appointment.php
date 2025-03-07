<?php
include('../../config/session_start.php');
header('Content-Type: application/json');
include('../../config/dbconn.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['appointmentId']) && !empty($data['appointmentId'])) {
        $appointmentId = intval($data['appointmentId']);

        // Prepare and execute the query
        $stmt = $conn->prepare("DELETE FROM appointments WHERE appointment_id = ?");
        $stmt->bind_param("i", $appointmentId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
            $stmt->close();
            $conn->close();
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting appointment: ' . $stmt->error]);
            $stmt->close();
            $conn->close();
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing appointmentId']);
        $conn->close();
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    $conn->close();
    exit;
}
?>