<?php
include('../config/session_start.php');
header('Content-Type: application/json');
include('../config/dbconn.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Function to log actions in the system
function logAction($message) {
    global $conn;

    // Get current date and time
    $currentDateTime = date('Y-m-d H:i:s');
    
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (
        isset($data['itemName']) && !empty($data['itemName']) &&
        isset($data['itemCategory']) && !empty($data['itemCategory']) &&
        isset($data['itemQuantity']) && !empty($data['itemQuantity']) &&
        isset($data['itemUnitPrice']) && !empty($data['itemUnitPrice'])
    ) {
        $itemName = trim($data['itemName']);
        $itemCategory = $data['itemCategory'];
        $itemQuantity = intval($data['itemQuantity']);
        $itemUnitPrice = floatval($data['itemUnitPrice']);
        $loggedInUserId = $_SESSION['user_id']; // Get logged-in user ID from session

        // Prepare and execute the query to insert the new inventory item
        $stmt = $conn->prepare("INSERT INTO inventory (item_name, category, quantity, unit_price, created_by) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", $itemName, $itemCategory, $itemQuantity, $itemUnitPrice, $loggedInUserId);

        if ($stmt->execute()) {
            // Log the action
            $logMessage = "User with ID $loggedInUserId added new inventory item: $itemName, Category: $itemCategory, Quantity: $itemQuantity, Unit Price: $itemUnitPrice";
            logAction($logMessage);

            // Respond with success
            echo json_encode(['success' => true]);
            $stmt->close();
            $conn->close();
            exit;
        } else {
            // Handle error while inserting the inventory item
            echo json_encode(['success' => false, 'message' => 'Error saving inventory item: ' . $stmt->error]);
            $stmt->close();
            $conn->close();
            exit;
        }
    } else {
        // Handle missing required data
        echo json_encode(['success' => false, 'message' => 'Missing required data']);
        $conn->close();
        exit;
    }
} else {
    // Handle invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    $conn->close();
    exit;
}
?>
