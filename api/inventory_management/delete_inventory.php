<?php
include('../config/session_start.php');
header('Content-Type: application/json');
include('../config/dbconn.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if(isset($data['itemId']) && !empty($data['itemId'])){
         $itemId = intval($data['itemId']);
          // Prepare and execute the query
            $stmt = $conn->prepare("DELETE FROM inventory WHERE item_id = ?");
             $stmt->bind_param("i", $itemId);

           if ($stmt->execute()) {
              echo json_encode(['success' => true]);
                exit;
            } else {
              echo json_encode(['success' => false, 'message' => 'Error deleting item: ' . $stmt->error]);
             $stmt->close();
             $conn->close();
              exit;
           }
    } else {
         echo json_encode(['success' => false, 'message' => 'Missing itemId']);
         $conn->close();
           exit;
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        $conn->close();
         exit;
     }
?>