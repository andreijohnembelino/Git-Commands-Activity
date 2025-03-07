<?php
session_start();
header('Content-Type: application/json');
include('../config/dbconn.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Verify that the data is well set and that nothing is null or empty
    if (
        isset($data['symptoms']) && is_array($data['symptoms']) &&
        isset($data['explanation']) && !empty($data['explanation']) &&
        isset($data['sicknessDescription']) && !empty($data['sicknessDescription']) &&
        isset($data['patientId']) && !empty($data['patientId'])
    ) {
        // Sanitize all data, especially for the database
        $symptoms = $conn->real_escape_string(implode(", ", $data['symptoms']));
        $explanation = $conn->real_escape_string(trim($data['explanation']));
        $sicknessDescription = $conn->real_escape_string(trim($data['sicknessDescription']));
        $patientId = intval($data['patientId']);  // Verify the patient ID value

        $publishedBy = $_SESSION['user_id'];

        // Construct the SQL query and execute it to prevent SQL injection
        $query = "UPDATE patients SET 
        selected_symptoms = ?,
        detailed_explanation = ?,
        sickness_description = ?,
        published_by = ? WHERE patient_id = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssii", $symptoms, $explanation, $sicknessDescription, $publishedBy, $patientId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Information updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating information: ' . $stmt->error]);
        }

        // Close Connections
        $stmt->close();
        $conn->close();
         exit;
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