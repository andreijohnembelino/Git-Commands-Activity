<?php
include('../../config/session_start.php');
header('Content-Type: application/json');
include('../../config/dbconn.php');

    // if (!isset($_SESSION['user_id'])) {
    //     echo json_encode(['success' => false, 'message' => 'User not logged in']);
    //     exit;
    // }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (
        isset($data['appointmentId']) && !empty($data['appointmentId']) &&
        isset($data['appointmentPatient']) && !empty($data['appointmentPatient']) &&
        isset($data['appointmentDoctor']) && !empty($data['appointmentDoctor']) &&
        isset($data['appointmentDate']) && !empty($data['appointmentDate']) &&
        isset($data['appointmentStatus']) && !empty($data['appointmentStatus'])
    ) {
        $appointmentId = intval($data['appointmentId']);
        $appointmentPatient = trim($data['appointmentPatient']);
        $appointmentDoctor = trim($data['appointmentDoctor']);
        $appointmentDate = $data['appointmentDate'];
        $appointmentStatus = $data['appointmentStatus'];
        $appointmentNotes = isset($data['appointmentNotes']) ? trim($data['appointmentNotes']) : '';

        // Prepare and execute the query
        $stmt = $conn->prepare("UPDATE appointments SET patient_id = ?, doctor_id = ?, appointment_date = ?, status = ?, notes = ? WHERE appointment_id = ?");
        $stmt->bind_param("iisssi", $appointmentPatient, $appointmentDoctor, $appointmentDate, $appointmentStatus, $appointmentNotes, $appointmentId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
            $stmt->close();
            $conn->close();
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating appointment: ' . $stmt->error]);
            $stmt->close();
            $conn->close();
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing required data']);
        $conn->close();
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    $conn->close();
    exit;
}
?>