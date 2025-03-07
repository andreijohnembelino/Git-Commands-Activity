<?php
session_start();
header('Content-Type: application/json');
include('../../config/dbconn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
      if (
        isset($data['patientId']) && !empty($data['patientId']) &&
        isset($data['patientName']) && !empty($data['patientName']) &&
        isset($data['patientDob']) && !empty($data['patientDob']) &&
        isset($data['patientGender']) && !empty($data['patientGender']) &&
        isset($data['patientContact']) && !empty($data['patientContact']) &&
         isset($data['patientAddress']) && !empty($data['patientAddress'])
    ) {

        $patientId = intval($data['patientId']);
        $patientName = trim($data['patientName']);
        $patientDob = $data['patientDob'];
        $patientGender = $data['patientGender'];
        $patientContact = trim($data['patientContact']);
        $patientAddress = trim($data['patientAddress']);
         $patientMedicalHistory = isset($data['patientMedicalHistory']) ? trim($data['patientMedicalHistory']) : '';
         $patientAllergies = isset($data['patientAllergies']) ? trim($data['patientAllergies']) : '';

          // Prepare and execute the query
           $stmt = $conn->prepare("UPDATE patients SET patient_name = ?, date_of_birth = ?, gender = ?, contact_number = ?, address = ?, medical_history = ?, allergies = ? WHERE patient_id = ?");
       $stmt->bind_param("sssssssi", $patientName, $patientDob, $patientGender, $patientContact, $patientAddress, $patientMedicalHistory, $patientAllergies, $patientId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
             exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating patient: ' . $stmt->error]);
        }
      } else {
          echo json_encode(['success' => false, 'message' => 'Missing required data']);
        }
    } else {
         echo json_encode(['success' => false, 'message' => 'Invalid request method']);
      }
    $conn->close();
?>