<?php
include('../../config/session_start.php');
header('Content-Type: application/json');
include('../../config/dbconn.php');

// Get raw JSON input
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Debugging: Check if JSON is received correctly
if ($data === null) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON received', 'raw_data' => $json]);
    exit;
}

// Check if all required fields exist before accessing them
$appointmentPatient = isset($data['appointmentPatient']) ? trim($data['appointmentPatient']) : null;
$appointmentDoctor = isset($data['appointmentDoctor']) ? trim($data['appointmentDoctor']) : null;
$appointmentDate = isset($data['appointmentDate']) ? $data['appointmentDate'] : null;
$appointmentTime = isset($data['appointmentTime']) ? $data['appointmentTime'] : null; // New time slot input
$appointmentStatus = "Scheduled"; // Default status
$appointmentNotes = isset($data['appointmentNotes']) ? trim($data['appointmentNotes']) : '';

if (!$appointmentPatient || !$appointmentDoctor || !$appointmentDate || !$appointmentTime) {
    echo json_encode(['success' => false, 'message' => 'Missing required data', 'received_data' => $data]);
    exit;
}

// Extract start time from "HH:00 to HH:00" format
$timeParts = explode(" to ", $appointmentTime);
if (count($timeParts) !== 2) {
    echo json_encode(['success' => false, 'message' => 'Invalid time slot format']);
    exit;
}

$startTime = $timeParts[0] . ":00"; // Ensure time format is "HH:00:00"

// Validate time selection (should be within working hours and not during lunch break)
$hour = intval(explode(":", $startTime)[0]);
if ($hour < 8 || $hour >= 17 || $hour === 12) {
    echo json_encode(['success' => false, 'message' => 'Invalid appointment time. Select a valid slot.']);
    exit;
}

// Check if the selected slot is already booked
$stmtCheck = $conn->prepare("SELECT COUNT(*) AS count FROM appointments WHERE DATE(appointment_date) = ? AND appointment_time = ?");
$stmtCheck->bind_param("ss", $appointmentDate, $startTime);
$stmtCheck->execute();
$result = $stmtCheck->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    echo json_encode(['success' => false, 'message' => 'Selected time slot is already booked']);
    exit;
}
$stmtCheck->close();

 // Use client ID from session
 $clientId = $_SESSION['client_id'];

// Prepare and execute the insert query
$stmt = $conn->prepare("INSERT INTO appointments (patient_name, doctor_id, appointment_date, appointment_time, status, notes, client_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sissssi", $appointmentPatient, $appointmentDoctor, $appointmentDate, $startTime, $appointmentStatus, $appointmentNotes, $clientId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Appointment added successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error adding appointment: ' . $stmt->error]);
}

// Close connections
$stmt->close();
$conn->close();
exit;
?>
