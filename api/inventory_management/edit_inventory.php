<?php
session_start();
header('Content-Type: application/json');
include('../config/dbconn.php');

// Function to log actions in the system
function logAction($message) {
    global $conn;

    // Get current date and time
    $currentDateTime = date('Y-m-d H:i:s'); // Ensure correct date format
    
    // Prepare the query to insert the log message into the logs table
    $stmt = $conn->prepare("INSERT INTO logs (message, created_at) VALUES (?, ?)");
    $stmt->bind_param("ss", $message, $currentDateTime);

    // Execute the query
    if ($stmt->execute()) {
        // Log successful
    } else {
        // Handle log failure (optional)
    }

    $stmt->close();
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (
        isset($data['itemId']) && !empty($data['itemId']) &&
        isset($data['itemName']) && !empty($data['itemName']) &&
        isset($data['itemCategory']) && !empty($data['itemCategory']) &&
        isset($data['itemQuantity']) && !empty($data['itemQuantity']) &&
        isset($data['itemUnitPrice']) && !empty($data['itemUnitPrice'])
    ) {
        $itemId = intval($data['itemId']);
        $itemName = trim($data['itemName']);
        $itemCategory = $data['itemCategory'];
        $itemQuantity = intval($data['itemQuantity']);
        $itemUnitPrice = floatval($data['itemUnitPrice']);
        $loggedInUserId = $_SESSION['user_id']; // Get logged-in user ID

        // Prepare and execute the query
        $stmt = $conn->prepare("UPDATE inventory SET item_name = ?, category = ?, quantity = ?, unit_price = ?, updated_by = ? WHERE item_id = ?");
        $stmt->bind_param("ssdsii", $itemName, $itemCategory, $itemQuantity, $itemUnitPrice, $loggedInUserId, $itemId); // Added updated_by

        if ($stmt->execute()) {
            // Log the action
            $logMessage = "Inventory Item ID $itemId updated by User ID $loggedInUserId at " . date('Y-m-d H:i:s');
            logAction($logMessage);
            
            echo json_encode(['success' => true]);
            $stmt->close();
            $conn->close();
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating inventory: ' . $stmt->error]);
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
