<?php
session_start();
header('Content-Type: application/json');

include('../config/dbconn.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Start building the SQL query
$where_clause = "appointments.doctor_id = ?"; // Filter to get appointments for the logged-in doctor
$params = [$_SESSION['user_id']]; // Use logged-in user's ID for filtering
$types = 'i'; // The user_id is an integer

// Filters (if provided)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!empty($_GET['filterPatient'])) {
        $where_clause .= " AND appointments.patient_name LIKE ?";
        $params[] = "%" . $_GET['filterPatient'] . "%";
        $types .= 's';
    }

    if (!empty($_GET['filterStartDate'])) {
        $where_clause .= " AND appointments.appointment_date >= ?";
        $params[] = $_GET['filterStartDate'];
        $types .= 's';
    }

    if (!empty($_GET['filterEndDate'])) {
        $where_clause .= " AND appointments.appointment_date <= ?";
        $params[] = $_GET['filterEndDate'];
        $types .= 's';
    }

    if (!empty($_GET['filterDoctor'])) {
        $where_clause .= " AND users.user_name LIKE ?";
        $params[] = "%" . $_GET['filterDoctor'] . "%";
        $types .= 's';
    }

    if (!empty($_GET['filterStatus'])) {
        $where_clause .= " AND appointments.status = ?";
        $params[] = $_GET['filterStatus'];
        $types .= 's';
    }
}

// Construct SQL Query with JOINs (Ensuring the where clause is applied)
$sql = "SELECT 
    appointments.appointment_id, 
    appointments.patient_name, 
    users.user_name AS doctor_name,  
    appointments.appointment_date, 
    appointments.appointment_time,
    appointments.status, 
    appointments.notes 
FROM appointments 
JOIN users ON appointments.doctor_id = users.user_id 
WHERE users.role = 'doctor' AND $where_clause";  // ✅ Apply filters here

// Prepare and execute query
$stmt = $conn->prepare($sql);

// Bind parameters if filters exist
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch data
$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

// Output JSON response
echo json_encode($appointments);

// Close connections
$stmt->close();
$conn->close();
?>
