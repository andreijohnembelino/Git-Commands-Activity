<?php
session_start();
header('Content-Type: application/json');
include('../../config/dbconn.php');

try {
    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error);
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }

    // Ensure the request is GET and contains patientId
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['patientId'])) {
        $patientId = filter_var($_GET['patientId'], FILTER_VALIDATE_INT);

        if ($patientId === false || $patientId <= 0) {
            error_log("Invalid patient ID: " . $_GET['patientId']);
            echo json_encode(['success' => false, 'message' => 'Invalid patient ID']);
            exit;
        }

        // Fetch the diagnostic result along with the user who published it
        $stmt = $conn->prepare("
            SELECT 
                d.selected_symptoms, 
                d.detailed_explanation, 
                d.sickness_description, 
                d.published_by, 
                u.user_name AS published_by_name
            FROM patients d
            LEFT JOIN users u ON d.published_by = u.user_id
            WHERE d.patient_id = ?
        ");
        $stmt->bind_param("i", $patientId);
        $stmt->execute();
        $result = $stmt->get_result();
        $diagnostic = $result->fetch_assoc();

        if ($diagnostic) {
            // Convert symptoms from a comma-separated string to an array
            $diagnosticData = [
                "selectedSymptoms" => !empty($diagnostic['selected_symptoms']) ? explode(", ", $diagnostic['selected_symptoms']) : [],
                "detailedExplanation" => $diagnostic['detailed_explanation'] ?? "",
                "sicknessDescription" => $diagnostic['sickness_description'] ?? "",
                "published_by" => $diagnostic['published_by'] ?? null,
                "published_by_name" => $diagnostic['published_by_name'] ?? "Unknown"
            ];

            echo json_encode(['success' => true, 'data' => $diagnosticData]);
        } else {
            error_log("No diagnostic data found for patient ID: " . $patientId);
            echo json_encode(['success' => false, 'message' => 'No diagnostic result found']);
        }

        $stmt->close();
        $conn->close();
        exit;
    } else {
        error_log("Invalid request method or missing patient ID");
        echo json_encode(['success' => false, 'message' => 'Invalid request method or missing patient ID']);
        $conn->close();
        exit;
    }
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while processing your request']);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
