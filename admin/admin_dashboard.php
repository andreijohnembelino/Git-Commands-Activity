<?php
include('../api/config/session_start.php');
include('../api/config/dbconn.php');
include('../admin/assets/inc/header.php');
include('../admin/assets/inc/sidebar.php');
include('../admin/assets/inc/navbar.php');

// Query to get the total number of patients
$totalPatientsQuery = "SELECT COUNT(*) as total_patients FROM patients";
$totalPatientsResult = mysqli_query($conn, $totalPatientsQuery);
$totalPatients = mysqli_fetch_assoc($totalPatientsResult)['total_patients'];

// Query to get the total number of appointments
$totalAppointmentsQuery = "SELECT COUNT(*) as total_appointments FROM appointments";
$totalAppointmentsResult = mysqli_query($conn, $totalAppointmentsQuery);
$totalAppointments = mysqli_fetch_assoc($totalAppointmentsResult)['total_appointments'];

// Query to get the available number of doctors from users table
$availableDoctorsQuery = "SELECT COUNT(*) as available_doctors FROM users WHERE role = 'doctor'";
$availableDoctorsResult = mysqli_query($conn, $availableDoctorsQuery);
$availableDoctors = mysqli_fetch_assoc($availableDoctorsResult)['available_doctors'];

// Query to get the available number of nurses from users table
$availableNursesQuery = "SELECT COUNT(*) as available_nurses FROM users WHERE role = 'nurse'";
$availableNursesResult = mysqli_query($conn, $availableNursesQuery);
$availableNurses = mysqli_fetch_assoc($availableNursesResult)['available_nurses'];

// Query to get the number of pending appointments
$pendingAppointmentsQuery = "SELECT COUNT(*) as pending_appointments FROM appointments WHERE status = 'Scheduled'";
$pendingAppointmentsResult = mysqli_query($conn, $pendingAppointmentsQuery);
$pendingAppointments = mysqli_fetch_assoc($pendingAppointmentsResult)['pending_appointments'];

// Query to fetch recent logs (last 5 logs)
$recentLogsQuery = "SELECT message, created_at FROM logs ORDER BY created_at DESC LIMIT 5";
$recentLogsResult = mysqli_query($conn, $recentLogsQuery);
$recentLogs = [];
while ($row = mysqli_fetch_assoc($recentLogsResult)) {
    $recentLogs[] = $row;
}

?>

<body>
    <div class="container mt-4">
        <h1 class="h3 mb-4">Admin Dashboard</h1>

        <div class="row g-4">
            <!-- Statistics Cards -->
            <div class="col-12">
                <div class="row g-4">
                    <div class="col-sm-6 col-lg-4">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <i class="fas fa-user-injured fa-2x text-primary"></i>
                                <h5 class="card-title">Total Patients</h5>
                                <p class="card-text display-6 fw-bold" id="total-patients"><?php echo $totalPatients; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <i class="fas fa-calendar-check fa-2x text-success"></i>
                                <h5 class="card-title">Total Appointments</h5>
                                <p class="card-text display-6 fw-bold" id="total-appointments"><?php echo $totalAppointments; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <i class="fas fa-user-md fa-2x text-warning"></i>
                                <h5 class="card-title">Available Doctors</h5>
                                <p class="card-text display-6 fw-bold" id="available-doctors"><?php echo $availableDoctors; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <i class="fas fa-user-nurse fa-2x text-info"></i>
                                <h5 class="card-title">Available Nurses</h5>
                                <p class="card-text display-6 fw-bold" id="available-nurse"><?php echo $availableNurses; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                                <h5 class="card-title">Pending Appointments</h5>
                                <p class="card-text display-6 fw-bold" id="pending-appointments"><?php echo $pendingAppointments; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recent Activity Card-->
        <div class="row g-4 mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-list fa-2x text-primary"></i>
                        <h5 class="card-title">Recent Activities</h5>
                        <ul class="list-unstyled" id="recent-activities">
                            <?php
                            if (!empty($recentLogs)) {
                                foreach ($recentLogs as $log) {
                                    echo "<li>" . htmlspecialchars($log['message']) . " on " . $log['created_at'] . "</li>";
                                }
                            } else {
                                echo "<li>No recent activities found.</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>