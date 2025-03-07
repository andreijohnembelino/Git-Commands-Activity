<?php
include('../config/session_start.php');
header('Content-Type: application/json');
include('../config/dbconn.php');

$where_clause = [];
$params = [];
$types = '';

$inputData = file_get_contents("php://input"); // Read raw JSON data
error_log("Raw Input: " . $inputData); // Log incoming data

$filterData = json_decode($inputData, true);

if (isset($filterData['filterData'])) {
    if (!empty($filterData['filterData']['filterName'])) {
        $where_clause[] = "item_name LIKE ?";
        $params[] = "%" . $filterData['filterData']['filterName'] . "%";
        $types .= 's';
    }

    if (!empty($filterData['filterData']['filterCategory'])) {
        $where_clause[] = "category = ?";
        $params[] = $filterData['filterData']['filterCategory'];
        $types .= 's';
    }
}

// Construct SQL Query
$sql = "SELECT item_id, item_name, category, quantity, unit_price FROM inventory";
if (!empty($where_clause)) {
    $sql .= " WHERE " . implode(" AND ", $where_clause);
}

// Log SQL Query for Debugging
error_log("SQL Query: " . $sql);
error_log("Params: " . json_encode($params));

$stmt = $conn->prepare($sql);

// Bind parameters only if filters exist
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$inventory = [];
while ($row = $result->fetch_assoc()) {
    $inventory[] = $row;
}

echo json_encode($inventory);

// Close connections
$stmt->close();
$conn->close();
?>
