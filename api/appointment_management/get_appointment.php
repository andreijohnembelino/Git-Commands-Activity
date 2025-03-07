<?php
session_start();
header('Content-Type: application/json');

include('../config/dbconn.php');

// if (!isset($_SESSION['user_id'])) {
//     echo json_encode(['success' => false, 'message' => 'User not logged in']);
//     exit;
// }

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['appointmentId'])) {
    $appointmentId = intval($_GET['appointmentId']);

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT appointment_id, patient_id, doctor_id, appointment_date, status, notes FROM appointments WHERE appointment_id = ?");
    $stmt->bind_param("i", $appointmentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();

    if ($appointment) {
        echo json_encode(['success' => true, 'appointment' => $appointment]);
        $stmt->close();
        $conn->close();
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Appointment not found']);
        $stmt->close();
        $conn->close();
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method or missing appointment ID']);
    $conn->close();
    exit;
}
?>