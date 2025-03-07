<?php
include('../../config/session_start.php');
header('Content-Type: application/json');
include('../../config/dbconn.php');

try {
    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error);
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['patientId'])) {
        $patientId = filter_var($_GET['patientId'], FILTER_VALIDATE_INT);
        $clientId = $_SESSION['client_id'] ?? null;

        if ($patientId === false || $patientId <= 0 || !$clientId) {
            error_log("Invalid patient ID or missing client session");
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM patients WHERE patient_id = ? AND client_id = ?");
        $stmt->bind_param("ii", $patientId, $clientId);
        $stmt->execute();
        $result = $stmt->get_result();
        $patient = $result->fetch_assoc();

        if ($patient) {
            // Fetch publisher name from users table
            $publishedBy = $patient['published_by'] ?? null;
            if ($publishedBy) {
                $userStmt = $conn->prepare("SELECT user_name FROM users WHERE user_id = ?");
                $userStmt->bind_param("i", $publishedBy);
                $userStmt->execute();
                $userResult = $userStmt->get_result();
                $user = $userResult->fetch_assoc();
                $patient['published_by_name'] = $user ? $user['user_name'] : 'Unknown';
                $userStmt->close();
            } else {
                $patient['published_by_name'] = 'N/A';
            }

            echo json_encode(['success' => true, 'data' => $patient]);
        } else {
            error_log("Patient not found or unauthorized access for id: " . $patientId);
            echo json_encode(['success' => false, 'message' => 'Patient not found']);
        }

        $stmt->close();
    } else {
        error_log("Invalid request method or missing patient ID");
        echo json_encode(['success' => false, 'message' => 'Invalid request method or missing patient ID']);
    }

} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred while processing your request']);
} finally {
    if(isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
