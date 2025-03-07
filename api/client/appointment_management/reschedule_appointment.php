<?php
include('../../config/session_start.php');
header('Content-Type: application/json');
include('../../config/dbconn.php');

// Get raw JSON input
$json = file_get_contents("php://input");
$data = json_decode($json, true);

if (!$data || !isset($data['appointmentId'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$appointmentId = $data['appointmentId'];
$appointmentPatient = trim($data['appointmentPatient']);
$appointmentDoctor = trim($data['appointmentDoctor']);
$appointmentDate = $data['appointmentDate'];
$appointmentTime = $data['appointmentTime'];
$appointmentNotes = trim($data['appointmentNotes']);

// Check if the new slot is already taken
$stmtCheck = $conn->prepare("SELECT COUNT(*) AS count FROM appointments WHERE appointment_date = ? AND appointment_time = ? AND appointment_id != ?");
$stmtCheck->bind_param("ssi", $appointmentDate, $appointmentTime, $appointmentId);
$stmtCheck->execute();
$result = $stmtCheck->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    echo json_encode(['success' => false, 'message' => 'Selected time slot is already booked']);
    exit;
}
$stmtCheck->close();

// Update the appointment
$stmt = $conn->prepare("UPDATE appointments SET patient_name = ?, doctor_id = ?, appointment_date = ?, appointment_time = ?, notes = ? WHERE appointment_id = ?");
$stmt->bind_param("sisssi", $appointmentPatient, $appointmentDoctor, $appointmentDate, $appointmentTime, $appointmentNotes, $appointmentId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Appointment updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating appointment: ' . $stmt->error]);
}

// Close connections
$stmt->close();
$conn->close();
exit;
?>
