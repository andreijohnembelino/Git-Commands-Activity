<?php
include('../api/config/dbconn.php');
include('../admin/assets/inc/header.php');
include('../admin/assets/inc/sidebar.php');
include('../admin/assets/inc/navbar.php');
?>
<main>
    <div class="container mt-4">
        <h1>Billing Management</h1>
         <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">List of Bills/Invoices</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBillingModal">Add New Bill</button>
                    </div>
                    <!-- Filter Options -->
                   <div class="card-body">
                       <form id="billingFilterForm">
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                  <label for="filterPatient" class="form-label">Patient Name</label>
                                    <input type="text" class="form-control" id="filterPatient" name="filterPatient" placeholder="Enter Patient Name">
                                 </div>
                                  <div class="col-md-4">
                                       <label for="filterStatus" class="form-label">Status</label>
                                      <select class="form-select" id="filterStatus" name="filterStatus">
                                           <option value="">All</option>
                                           <option value="pending">Pending</option>
                                           <option value="paid">Paid</option>
                                           <option value="cancelled">Cancelled</option>
                                    </select>
                                 </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                      <button type="submit" class="btn btn-secondary  w-100" id="applyFiltersButton">Apply Filters</button>
                                  </div>
                             </div>
                           <div class="row g-3 mb-3">
                                 <div class="col-md-4">
                                     <label for="filterStartDate" class="form-label">Start Date</label>
                                     <input type="date" class="form-control" id="filterStartDate" name="filterStartDate">
                                   </div>
                                   <div class="col-md-4">
                                     <label for="filterEndDate" class="form-label">End Date</label>
                                     <input type="date" class="form-control" id="filterEndDate" name="filterEndDate">
                                   </div>
                             </div>
                        </form>
                   </div>
                   <div class="card-body">
                        <div class="table-responsive">
                             <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Bill ID</th>
                                         <th>Patient Name</th>
                                         <th>Bill Date</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="billing-table-body">
                                     <tr>
                                        <td>1</td>
                                        <td>Patient A</td>
                                         <td>2024-07-28</td>
                                         <td>150.00</td>
                                         <td>Pending</td>
                                        <td>
                                             <button class="btn btn-sm btn-info view-billing-btn" data-bs-toggle="modal" data-bs-target="#viewBillingModal" data-billing-id="1">View</button>
                                            <a href="admin_edit_billing.php" class="btn btn-sm btn-primary">Edit</a>
                                        </td>
                                    </tr>
                                      <tr>
                                          <td>2</td>
                                          <td>Patient B</td>
                                          <td>2024-07-27</td>
                                           <td>250.00</td>
                                           <td>Paid</td>
                                            <td>
                                                <button class="btn btn-sm btn-info view-billing-btn" data-bs-toggle="modal" data-bs-target="#viewBillingModal" data-billing-id="2">View</button>
                                               <a href="admin_edit_billing.php" class="btn btn-sm btn-primary">Edit</a>
                                            </td>
                                     </tr>
                                      <tr>
                                         <td>3</td>
                                          <td>Patient C</td>
                                          <td>2024-07-26</td>
                                         <td>300.00</td>
                                         <td>Cancelled</td>
                                           <td>
                                               <button class="btn btn-sm btn-info view-billing-btn" data-bs-toggle="modal" data-bs-target="#viewBillingModal" data-billing-id="3">View</button>
                                               <a href="admin_edit_billing.php" class="btn btn-sm btn-primary">Edit</a>
                                           </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Billing Modal -->
   <div class="modal fade" id="addBillingModal" tabindex="-1" aria-labelledby="addBillingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBillingModalLabel">Add New Bill/Invoice</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                      <form id="addBillingForm" method="post" action="">
                            <div class="mb-3">
                                 <label for="billingPatient" class="form-label">Patient Name</label>
                                  <input type="text" class="form-control" id="billingPatient" name="billingPatient" required>
                             </div>
                             <div class="mb-3">
                                <label for="billingDate" class="form-label">Billing Date</label>
                                 <input type="date" class="form-control" id="billingDate" name="billingDate" required>
                           </div>
                            <div class="mb-3">
                                 <label for="billingAmount" class="form-label">Total Amount</label>
                                   <input type="number" class="form-control" id="billingAmount" name="billingAmount" step="0.01" required>
                            </div>
                          <div class="mb-3">
                              <label for="billingStatus" class="form-label">Status</label>
                              <select class="form-select" id="billingStatus" name="billingStatus" required>
                                   <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                      <option value="cancelled">Cancelled</option>
                             </select>
                           </div>
                           <button type="submit" class="btn btn-primary">Add Bill</button>
                       </form>
                   </div>
            </div>
        </div>
   </div>

    <!-- View Billing Modal -->
    <div class="modal fade" id="viewBillingModal" tabindex="-1" aria-labelledby="viewBillingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewBillingModalLabel">Bill/Invoice Details</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                 <div class="modal-body" id="viewBillingModalBody">
                   <p><strong>Bill ID:</strong> <span id="billingIdDisplay"></span></p>
                    <p><strong>Patient Name:</strong> <span id="billingPatientDisplay"></span></p>
                   <p><strong>Bill Date:</strong> <span id="billingDateDisplay"></span></p>
                   <p><strong>Total Amount:</strong> <span id="billingAmountDisplay"></span></p>
                   <p><strong>Status:</strong> <span id="billingStatusDisplay"></span></p>
                   <a id="editBillingButton" href="" class="btn btn-sm btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>
</main>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
     // Javascript implementation, You will have to implement the save data with php
    document.getElementById('addBillingForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        // Get the data from the form
         const billingPatient = document.getElementById('billingPatient').value;
        const billingDate = document.getElementById('billingDate').value;
        const billingAmount = document.getElementById('billingAmount').value;
         const billingStatus = document.getElementById('billingStatus').value;

        // Prepare data
         const formData = {
           billingPatient: billingPatient,
           billingDate: billingDate,
             billingAmount: billingAmount,
           billingStatus: billingStatus
            };
        console.log(formData); // for debugging purposes
        // Reset the form
          document.getElementById('addBillingForm').reset();
          // close modal
        const modal = document.getElementById('addBillingModal');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
         // Display a success message or redirect to the patient list page
        alert("Bill Added Successfully, data has been logged in the console")
           window.location.href = "admin_billing.php"; //redirect to the current page
   });
      // handle filter form
     document.getElementById('billingFilterForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
         // Get all the filter values
         const filterPatient = document.getElementById('filterPatient').value;
        const filterStatus = document.getElementById('filterStatus').value;
        const filterStartDate = document.getElementById('filterStartDate').value;
        const filterEndDate = document.getElementById('filterEndDate').value;

           // Prepare filter data
         const filterData = {
            filterPatient: filterPatient,
              filterStatus: filterStatus,
            filterStartDate: filterStartDate,
           filterEndDate: filterEndDate
            };
        console.log(filterData); // for debugging purposes
       // you will have to make a php api to use this data and update the content of the table, using fetch
        // for the moment we are using a console log
        alert("Filters have been applied, see console")
    });

     // Handle view billing button clicks using javascript
      document.querySelectorAll('.view-billing-btn').forEach(button => {
        button.addEventListener('click', function() {
            const billingId = this.getAttribute('data-billing-id');
           // Example of hardcoded data, here you need to implement php for it.
              const billingDetails = {
              "1": {
                  patient: "Patient A",
                    date: "2024-07-28",
                    amount: 150.00,
                   status: "Pending"
                },
              "2": {
                  patient: "Patient B",
                  date: "2024-07-27",
                    amount: 250.00,
                   status: "Paid"
                },
                "3": {
                     patient: "Patient C",
                    date: "2024-07-26",
                    amount: 300.00,
                    status: "Cancelled"
                    }
             };
         const billing = billingDetails[billingId];
         // Set the content of the modal based on the selected billing
           document.getElementById('billingIdDisplay').textContent = billingId;
          document.getElementById('billingPatientDisplay').textContent = billing.patient;
           document.getElementById('billingDateDisplay').textContent = billing.date;
          document.getElementById('billingAmountDisplay').textContent = billing.amount;
            document.getElementById('billingStatusDisplay').textContent = billing.status;
           document.getElementById('editBillingButton').href = `admin_edit_billing.php?id=${billingId}`;
        });
    });
</script>
</body>
</html>