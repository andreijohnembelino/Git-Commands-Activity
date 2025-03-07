<?php
include('../config/session_start.php');
header('Content-Type: application/json');
include('../config/dbconn.php');
// Check if item_id is provided
if (!isset($_GET['item_id']) ) {
    echo json_encode(['success' => false, 'message' => 'Invalid item ID']);
    exit;
}

$item_id = $_GET['item_id'];

// SQL query to fetch item details, including user names for created_by and modified_by
$sql = "
    SELECT 
        i.item_id, 
        i.item_name, 
        i.category, 
        i.quantity, 
        i.unit_price, 
        i.created_by, 
        i.updated_by, 
        i.created_at, 
        i.updated_at,
        u_created.user_name AS created_by_name,
        u_updated.user_name AS updated_by_name
    FROM 
        inventory i
    LEFT JOIN users u_created ON i.created_by = u_created.user_id
    LEFT JOIN users u_updated ON i.updated_by = u_updated.user_id
    WHERE i.item_id = ?
";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement']);
    exit;
}

$stmt->bind_param("i", $item_id);

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Failed to execute query']);
    exit;
}

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['success' => true, 'item' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => 'Item not found']);
}

$stmt->close();
$conn->close();
?>
