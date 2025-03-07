<?php
include('../api/config/session_start.php');
include('../api/config/dbconn.php');
include('../client/assets/inc/header.php');
include('../client/assets/inc/sidebar.php');
include('../client/assets/inc/navbar.php');

// Assuming the user is logged in and we have their ID in the session
$user_id = $_SESSION['client_id']; // Modify to fit your session variable for user ID

// Fetch all appointments for the patient
$appointment_query = "SELECT * FROM appointments WHERE client_id = ? ORDER BY appointment_date ASC";
$stmt = $conn->prepare($appointment_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$appointments_result = $stmt->get_result();

// Create an array to hold appointments by date
$appointments_by_day = [];
while ($appointment = $appointments_result->fetch_assoc()) {
    $appointment_date = strtotime($appointment['appointment_date']);
    $day = date('j', $appointment_date); // Get the day of the month (e.g., 15)
    $appointments_by_day[$day][] = [
        'patient_name' => $appointment['patient_name'],
        'appointment_time' => $appointment['appointment_time'],
        'status' => $appointment['status']
    ];
}



// Fetch recent activities like tests, doctor visits, etc.
$activities_query = "SELECT * FROM logs WHERE id = ? ORDER BY created_at DESC LIMIT 5";
$stmt = $conn->prepare($activities_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$activities_result = $stmt->get_result();
?>

<body>
    <div class="container mt-4">
        <h1 class="h3 mb-4">Patient Dashboard</h1>

        <div class="row g-4">
            <!-- Upcoming Appointments -->
            <!-- Upcoming Appointments Calendar -->
<div class="col-sm-12 col-lg-8">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Upcoming Appointments</h5>
            <div class="calendar-container">
                <!-- Calendar Header -->
                <div class="calendar-header">
                    <button id="prev-month" class="btn btn-outline-primary">&#9664;</button>
                    <span id="month-name"></span>
                    <button id="next-month" class="btn btn-outline-primary">&#9654;</button>
                </div>

                <!-- Calendar Days -->
                <div class="calendar-days">
                    <div class="calendar-day" id="day-1"></div>
                    <div class="calendar-day" id="day-2"></div>
                    <div class="calendar-day" id="day-3"></div>
                    <div class="calendar-day" id="day-4"></div>
                    <div class="calendar-day" id="day-5"></div>
                    <div class="calendar-day" id="day-6"></div>
                    <div class="calendar-day" id="day-7"></div>
                    <div class="calendar-day" id="day-8"></div>
                    <div class="calendar-day" id="day-9"></div>
                    <div class="calendar-day" id="day-10"></div>
                    <div class="calendar-day" id="day-11"></div>
                    <div class="calendar-day" id="day-12"></div>
                    <div class="calendar-day" id="day-13"></div>
                    <div class="calendar-day" id="day-14"></div>
                    <div class="calendar-day" id="day-15"></div>
                    <div class="calendar-day" id="day-16"></div>
                    <div class="calendar-day" id="day-17"></div>
                    <div class="calendar-day" id="day-18"></div>
                    <div class="calendar-day" id="day-19"></div>
                    <div class="calendar-day" id="day-20"></div>
                    <div class="calendar-day" id="day-21"></div>
                    <div class="calendar-day" id="day-22"></div>
                    <div class="calendar-day" id="day-23"></div>
                    <div class="calendar-day" id="day-24"></div>
                    <div class="calendar-day" id="day-25"></div>
                    <div class="calendar-day" id="day-26"></div>
                    <div class="calendar-day" id="day-27"></div>
                    <div class="calendar-day" id="day-28"></div>
                    <div class="calendar-day" id="day-29"></div>
                    <div class="calendar-day" id="day-30"></div>
                    <div class="calendar-day" id="day-31"></div>
                </div>
            </div>
        </div>
    </div>
</div>



        <!-- Recent Activities -->
        <div class="row g-4 mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Recent Activities</h5>
                        <ul class="list-unstyled">
                            <?php while ($activity = $activities_result->fetch_assoc()) { ?>
                                <li>
                                    <strong>Activity:</strong> <?= $activity['message'] ?><br>
                                    <strong>Date:</strong> <?= date("F j, Y", strtotime($activity['created_at'])) ?>
                                </li>
                                <hr>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>document.addEventListener("DOMContentLoaded", function() {
    const appointmentsByDay = <?php echo json_encode($appointments_by_day); ?>;
    
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const today = new Date();
    let currentMonth = today.getMonth(); // 0-based (0 for January, 11 for December)
    let currentYear = today.getFullYear();

    // Function to render the calendar for the current month
    function renderCalendar() {
        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const monthName = monthNames[currentMonth];
        const totalDays = lastDay.getDate();

        // Set the month name in the header
        document.getElementById("month-name").innerText = `${monthName} ${currentYear}`;

        // Clear any existing calendar days
        const calendarDays = document.querySelector(".calendar-days");
        calendarDays.innerHTML = "";

        // Loop through each day in the month and add to the calendar
        for (let day = 1; day <= totalDays; day++) {
            const dayDiv = document.createElement("div");
            dayDiv.classList.add("calendar-day");
            dayDiv.id = `day-${day}`;
            dayDiv.innerHTML = `<span>${day}</span>`;

            // Add appointments for that day (if any)
            if (appointmentsByDay[day]) {
                let appointmentDetails = "<ul>";
                appointmentsByDay[day].forEach(appointment => {
                    appointmentDetails += `<li><strong>${appointment.patient_name}</strong><br>
                        ${appointment.appointment_time}<br>
                        Status: ${appointment.status}</li>`;
                });
                appointmentDetails += "</ul>";
                dayDiv.innerHTML += appointmentDetails;
            }

            // Add the day to the calendar grid
            calendarDays.appendChild(dayDiv);
        }
    }

    // Event listeners for navigation buttons
    document.getElementById("prev-month").addEventListener("click", function() {
        if (currentMonth === 0) {
            currentMonth = 11;
            currentYear--;
        } else {
            currentMonth--;
        }
        renderCalendar();
    });

    document.getElementById("next-month").addEventListener("click", function() {
        if (currentMonth === 11) {
            currentMonth = 0;
            currentYear++;
        } else {
            currentMonth++;
        }
        renderCalendar();
    });

    // Initial render of the calendar
    renderCalendar();
});
</script>
</body>
</html>
