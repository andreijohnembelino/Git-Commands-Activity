<?php
include('../../config/session_start.php');
header('Content-Type: application/json');
include('../../config/dbconn.php');

// Get the logged-in client_id from session
$client_id = $_SESSION['client_id'];
if(!isset($_SESSION['client_id'])) {
    die(json_encode(["success" => false, "message" => "No client_id found in session"]));
} else {
    error_log("Client ID from session: " . $_SESSION['client_id']);
}


$sql = "SELECT * FROM patients WHERE client_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

$patients = [];
while ($row = $result->fetch_assoc()) {
    $patients[] = $row;
}

echo json_encode(["success" => true, "patients" => $patients]);

$stmt->close();
$conn->close();
