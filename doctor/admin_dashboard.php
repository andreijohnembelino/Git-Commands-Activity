<?php
include('../api/config/session_start.php');
include('../api/config/dbconn.php');
include('../doctor/assets/inc/header.php');
include('../doctor/assets/inc/sidebar.php');
include('../doctor/assets/inc/navbar.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die('User not logged in.');
}

$doctorId = $_SESSION['user_id']; // Assuming the logged-in user is a doctor and their ID is stored in session

// Query to get the total number of patients (no user filtering)
$totalPatientsQuery = "SELECT COUNT(*) as total_patients FROM patients";
$totalPatientsResult = mysqli_query($conn, $totalPatientsQuery);
$totalPatients = mysqli_fetch_assoc($totalPatientsResult)['total_patients'];

// Query to get the total number of appointments for the logged-in doctor
$totalAppointmentsQuery = "SELECT COUNT(*) as total_appointments FROM appointments WHERE doctor_id = '$doctorId'";
$totalAppointmentsResult = mysqli_query($conn, $totalAppointmentsQuery);
$totalAppointments = mysqli_fetch_assoc($totalAppointmentsResult)['total_appointments'];

// Query to get the number of appointments for today for the logged-in doctor
$appointmentsTodayQuery = "SELECT COUNT(*) as appointments_today FROM appointments WHERE appointment_date = CURDATE() AND doctor_id = '$doctorId'";
$appointmentsTodayResult = mysqli_query($conn, $appointmentsTodayQuery);
$appointmentsToday = mysqli_fetch_assoc($appointmentsTodayResult)['appointments_today'];

// Query to get the number of pending appointments for the logged-in doctor
$pendingAppointmentsQuery = "SELECT COUNT(*) as pending_appointments FROM appointments WHERE status = 'Scheduled' AND doctor_id = '$doctorId'";
$pendingAppointmentsResult = mysqli_query($conn, $pendingAppointmentsQuery);
$pendingAppointments = mysqli_fetch_assoc($pendingAppointmentsResult)['pending_appointments'];
?>
<body>
    <div class="container mt-4">
        <h1 class="h3 mb-4">Doctor Dashboard</h1>

        <div class="row g-4">
            <!-- Total Patients Card -->
            <div class="col-sm-6 col-lg-2">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <i class="fas fa-user-injured fa-2x text-primary"></i>
                        <h5 class="card-title mt-3">Total Patients</h5>
                        <p class="card-text display-6 fw-bold text-muted" id="total-patients"><?php echo $totalPatients; ?></p>
                    </div>
                </div>
            </div>

            <!-- Total Appointments Card -->
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <i class="fas fa-calendar-check fa-2x text-success"></i>
                        <h5 class="card-title mt-3">Total Appointments</h5>
                        <p class="card-text display-6 fw-bold text-muted" id="total-appointments"><?php echo $totalAppointments; ?></p>
                    </div>
                </div>
            </div>

            <!-- Appointments Today Card -->
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <i class="fas fa-calendar-day fa-2x text-info"></i>
                        <h5 class="card-title mt-3">Appointments Today</h5>
                        <p class="card-text display-6 fw-bold text-muted" id="appointments-today"><?php echo $appointmentsToday; ?></p>
                    </div>
                </div>
            </div>

            <!-- Pending Appointments Card -->
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <i class="fas fa-clock fa-2x text-warning"></i>
                        <h5 class="card-title mt-3">Pending Appointments</h5>
                        <p class="card-text display-6 fw-bold text-muted" id="pending-appointments"><?php echo $pendingAppointments; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // If you want to update these values dynamically in the future with JavaScript, you can fetch and update them here
        // For example, using AJAX or Fetch API to call a PHP script that returns the latest stats
        // Example: fetch('/api/get_dashboard_data.php').then(response => response.json()).then(data => {...});
    </script>
</body>
</html>
