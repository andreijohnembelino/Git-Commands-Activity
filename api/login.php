<?php
session_start();
header('Content-Type: application/json');
include('../api/config/dbconn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['email']) && isset($data['password'])) {
        $email = trim($data['email']);
        $password = $data['password'];

        // Check users table first
        $stmt = $conn->prepare("SELECT user_id, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $hashed_password, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['role'] = ucfirst(strtolower($role));

                echo json_encode([
                    'success' => true,
                    'role' => ucfirst(strtolower($role)),
                    'session' => $_SESSION
                ]);
                exit;
            }
        }

        // Check clients table
        $stmt = $conn->prepare("SELECT client_id, password FROM clients WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($client_id, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['client_id'] = $client_id; // ✅ Now storing correct client ID
                $_SESSION['role'] = 'Client';

                echo json_encode([
                    'success' => true,
                    'role' => 'Client',
                    'session' => $_SESSION
                ]);
                exit;
            }
        }
    }

    echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
