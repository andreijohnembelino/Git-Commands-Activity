<?php
include('../config/session_start.php');
header('Content-Type: application/json');
include('../config/dbconn.php');

error_log("Starting get_inventory.php");

if (isset($_GET['itemId'])) {
    $itemId = intval($_GET['itemId']);

    if ($itemId <= 0) {
        error_log("Invalid item ID: " . $_GET['itemId']);
        echo json_encode(['success' => false, 'message' => 'Invalid item ID']);
        exit;
    }

    error_log("Requested item ID: " . $itemId);

    // Prepare and execute query
    if ($stmt = $conn->prepare("SELECT * FROM inventory WHERE item_id = ?")) {
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $result = $stmt->get_result();

        error_log("Query executed.");

        if ($item = $result->fetch_assoc()) {
            error_log("Item found, id: " . $item['item_id']);
            echo json_encode($item);
        } else {
            error_log("Item not found with id: " . $itemId);
            echo json_encode(['success' => false, 'message' => 'Item not found']);
        }

        $stmt->close();
    } else {
        error_log("Database query failed.");
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
} else {
    error_log("Invalid request method or missing item ID");
    echo json_encode(['success' => false, 'message' => 'Invalid request method or missing item ID']);
}

$conn->close();
exit;
?>
