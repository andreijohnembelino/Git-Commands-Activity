<?php
include('../api/config/session_start.php');
include('../api/config/dbconn.php');
include('../nurse/assets/inc/header.php');
include('../nurse/assets/inc/sidebar.php');
include('../nurse/assets/inc/navbar.php');

// Fetch data from the database

// Total patients
$total_patients_query = "SELECT COUNT(*) AS total FROM patients";
$total_patients_result = mysqli_query($conn, $total_patients_query);
$total_patients_row = mysqli_fetch_assoc($total_patients_result);
$total_patients = $total_patients_row['total'];

// Total appointments
$total_appointments_query = "SELECT COUNT(*) AS total FROM appointments";
$total_appointments_result = mysqli_query($conn, $total_appointments_query);
$total_appointments_row = mysqli_fetch_assoc($total_appointments_result);
$total_appointments = $total_appointments_row['total'];

// Pending appointments
$pending_appointments_query = "SELECT COUNT(*) AS total FROM appointments WHERE status = 'pending'";
$pending_appointments_result = mysqli_query($conn, $pending_appointments_query);
$pending_appointments_row = mysqli_fetch_assoc($pending_appointments_result);
$pending_appointments = $pending_appointments_row['total'];

// Fetch all inventory items for the chart
$inventory_query = "SELECT item_name, quantity FROM inventory"; // Fetch all items
$inventory_result = mysqli_query($conn, $inventory_query);
$inventory_items = [];
while ($row = mysqli_fetch_assoc($inventory_result)) {
    $inventory_items[] = $row;
}

// Fetch recent activities
$recent_activities_query = "SELECT message, created_at FROM logs ORDER BY created_at DESC LIMIT 5";
$recent_activities_result = mysqli_query($conn, $recent_activities_query);
$recent_activities = [];
while ($row = mysqli_fetch_assoc($recent_activities_result)) {
    $recent_activities[] = $row;
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
                                <h5 class="card-title">Total Patients</h5>
                                <p class="card-text display-6 fw-bold" id="total-patients"><?= $total_patients ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <h5 class="card-title">Total Appointments</h5>
                                <p class="card-text display-6 fw-bold" id="total-appointments"><?= $total_appointments ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <h5 class="card-title">Pending Appointments</h5>
                                <p class="card-text display-6 fw-bold" id="pending-appointments"><?= $pending_appointments ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Low Stock Items Card with Graph -->
                    <div class="col-sm-6 col-lg-12"> <!-- Make the card take the full width (col-lg-12) -->
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <h5 class="card-title">Inventory Items</h5>
                                <canvas id="lowStockChart" width="400" height="150"></canvas>
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
                        <h5 class="card-title">Recent Activities</h5>
                        <ul class="list-unstyled" id="recent-activities">
                            <?php foreach ($recent_activities as $activity) { ?>
                                <li><?= $activity['message'] ?> on <?= $activity['created_at'] ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Prepare the data for the low stock chart
        const inventoryItems = <?php echo json_encode($inventory_items); ?>;

        // Extract item names and quantities
        const itemNames = inventoryItems.map(item => item.item_name);
        const itemQuantities = inventoryItems.map(item => item.quantity);

        // Define the color of the bars based on stock quantity (red for low stock)
        const barColors = itemQuantities.map(quantity =>
            quantity < 11 ? 'red' :
            quantity < 50 ? 'yellow' :
            'green'
        ); // red for low stock (< 11), yellow for medium stock (< 50), green for normal stock (>= 50)


        // Create a bar chart for low stock items
        const ctx = document.getElementById('lowStockChart').getContext('2d');
        const lowStockChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: itemNames,
                datasets: [{
                    label: 'Inventory Quantity',
                    data: itemQuantities,
                    backgroundColor: barColors, // Dynamic colors based on quantity
                    borderColor: 'black',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>