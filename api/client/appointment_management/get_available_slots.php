<?php
include('../../config/session_start.php');
header('Content-Type: application/json');
include('../../config/dbconn.php');

// Check if date is provided
if (!isset($_GET['date']) || empty($_GET['date'])) {
    echo json_encode(["success" => false, "message" => "No date provided"]);
    exit;
}

$selectedDate = $_GET['date']; // Format: YYYY-MM-DD

try {
    // Define working hours excluding lunch break (12:00 PM - 1:00 PM)
    $startHour = 8;
    $endHour = 17; // 5 PM

    // Generate all possible time slots excluding 12 PM - 1 PM
    $allSlots = [];
    for ($hour = $startHour; $hour < $endHour; $hour++) { // Loop until 4 PM (last slot is 4:00 to 5:00)
        if ($hour !== 12) { // Exclude lunch break
            $startTime = sprintf("%02d:00", $hour); // Format HH:00
            $endTime = sprintf("%02d:00", $hour + 1);
            $formattedSlot = "$startTime to $endTime";
            $allSlots[$startTime . ":00"] = $formattedSlot; // Store original time format for comparison
        }
    }

    // Fetch existing appointments for the selected date
    $stmt = $conn->prepare("SELECT appointment_time FROM appointments WHERE DATE(appointment_date) = ?");
    $stmt->bind_param("s", $selectedDate);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $bookedTime = $row['appointment_time'];
        if (isset($allSlots[$bookedTime])) {
            unset($allSlots[$bookedTime]); // Remove booked slots
        }
    }

    $stmt->close();
    $conn->close();

    // Return available slots
    echo json_encode(["success" => true, "availableSlots" => array_values($allSlots)]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
