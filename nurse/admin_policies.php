<?php
include('../api/config/dbconn.php');
include('../nurse/assets/inc/header.php');
include('../nurse/assets/inc/sidebar.php');
include('../nurse/assets/inc/navbar.php');

// Assume we have some way to get the current user's role (e.g., from a session or database)
// For now, let's use a simple placeholder. You'll need to adapt this to your authentication logic.
$userRole = 'admin'; // Options: 'admin' or 'staff'
?>
<main>
    <div class="container mt-4">
        <h1 class="h3 mb-4">Admin Help Center</h1>

         <div class="mb-4">
               <input type="text" class="form-control" placeholder="Search Policies and Procedures" id="helpSearch">
           </div>

           <!-- Admin Controls -->
            <?php if ($userRole === 'admin') : ?>
                <div class="mb-4 d-flex justify-content-end">
                      <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addPolicyModal">Add Policy</button>
                      <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modifyPolicyModal">Modify Policy</button>
                </div>
            <?php endif; ?>

        <!-- Policy and Procedures Sections -->
        <div class="accordion" id="helpAccordion">
            <!-- Patient Admission Policies -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingAdmissionPolicies">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdmissionPolicies" aria-expanded="true" aria-controls="collapseAdmissionPolicies">
                       Patient Admission Policies
                    </button>
                </h2>
                <div id="collapseAdmissionPolicies" class="accordion-collapse collapse show" aria-labelledby="headingAdmissionPolicies" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                       <p>
                            All patients must be registered in the system upon arrival. Collect the necessary information such as the patient's full name, date of birth, gender, contact information, address, medical history, and allergies.
                        </p>
                         <p>
                            For emergency admissions, prioritize immediate care. Complete the full registration process as soon as the patient’s condition allows.
                       </p>
                    </div>
                </div>
            </div>

            <!-- Appointment Scheduling Policies -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSchedulingPolicies">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSchedulingPolicies" aria-expanded="false" aria-controls="collapseSchedulingPolicies">
                        Appointment Scheduling Policies
                    </button>
                </h2>
                <div id="collapseSchedulingPolicies" class="accordion-collapse collapse" aria-labelledby="headingSchedulingPolicies" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                       <p>
                            Appointments should be scheduled based on the availability of the doctors and resources. Ensure to verify the time and date with the patient.
                       </p>
                      <p>
                            When rescheduling or canceling appointments, notify the patient at least 24 hours prior to the scheduled appointment.
                       </p>
                   </div>
                </div>
            </div>

            <!-- Inventory Management Protocols -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingInventoryProtocol">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInventoryProtocol" aria-expanded="false" aria-controls="collapseInventoryProtocol">
                       Inventory Management Protocols
                    </button>
                </h2>
                <div id="collapseInventoryProtocol" class="accordion-collapse collapse" aria-labelledby="headingInventoryProtocol" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <p>
                            All medical supplies and equipment must be tracked in the inventory system. Add each new item, and when quantities are reduced due to usage.
                        </p>
                         <p>
                            Set up alerts for low-stock items to ensure timely reordering and maintain adequate supplies.
                        </p>
                    </div>
                </div>
            </div>

             <!-- Billing Protocols -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingBillingProtocol">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBillingProtocol" aria-expanded="false" aria-controls="collapseBillingProtocol">
                        Billing Protocols
                    </button>
                </h2>
                 <div id="collapseBillingProtocol" class="accordion-collapse collapse" aria-labelledby="headingBillingProtocol" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <p>
                           All services rendered to patients must be billed accurately and promptly. Generate bills after each visit and record any payments accordingly.
                        </p>
                        <p>
                            Follow up on any outstanding bills and maintain clear payment records.
                       </p>
                    </div>
                 </div>
            </div>

            <!-- Patient Data Security Protocols -->
            <div class="accordion-item">
                 <h2 class="accordion-header" id="headingSecurityProtocol">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecurityProtocol" aria-expanded="false" aria-controls="collapseSecurityProtocol">
                        Patient Data Security Protocols
                    </button>
                </h2>
                <div id="collapseSecurityProtocol" class="accordion-collapse collapse" aria-labelledby="headingSecurityProtocol" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                         <p>
                            All patient data must be kept confidential and must not be shared with anyone not authorized. Use secure passwords. Always log off when your work is completed.
                         </p>
                         <p>
                            In case of suspected security breaches notify the system administrator immediately.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <!-- Add Policy Modal -->
    <div class="modal fade" id="addPolicyModal" tabindex="-1" aria-labelledby="addPolicyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                     <h5 class="modal-title" id="addPolicyModalLabel">Add New Policy</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPolicyForm" method="post" action="">
                           <div class="mb-3">
                                <label for="policyTitle" class="form-label">Policy Title</label>
                                <input type="text" class="form-control" id="policyTitle" name="policyTitle" required>
                           </div>
                           <div class="mb-3">
                                  <label for="policyContent" class="form-label">Policy Content</label>
                                   <textarea class="form-control" id="policyContent" name="policyContent" rows="5" required></textarea>
                           </div>
                        <button type="submit" class="btn btn-primary">Add Policy</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modify Policy Modal -->
   <div class="modal fade" id="modifyPolicyModal" tabindex="-1" aria-labelledby="modifyPolicyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="modifyPolicyModalLabel">Modify Policy</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     <form id="modifyPolicyForm" method="post" action="">
                          <div class="mb-3">
                                <label for="modifyPolicySelect" class="form-label">Select Policy</label>
                                <select class="form-select" id="modifyPolicySelect" name="modifyPolicySelect" required>
                                   <!-- You will have to add php code to populate the content of the select-->
                                   <option value="0">Select a policy</option>
                                    <option value="1">Patient Admission Policies</option>
                                     <option value="2">Appointment Scheduling Policies</option>
                                     <option value="3">Inventory Management Protocols</option>
                                      <option value="4">Billing Protocols</option>
                                    <option value="5">Patient Data Security Protocols</option>
                                </select>
                            </div>
                           <div class="mb-3">
                                  <label for="modifyPolicyContent" class="form-label">New Content</label>
                                   <textarea class="form-control" id="modifyPolicyContent" name="modifyPolicyContent" rows="5" required></textarea>
                           </div>
                        <button type="submit" class="btn btn-primary">Modify Policy</button>
                   </form>
               </div>
            </div>
        </div>
    </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Javascript implementation, You will have to implement the save data with php
       document.getElementById('addPolicyForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        // Get the data from the form
        const policyTitle = document.getElementById('policyTitle').value;
         const policyContent = document.getElementById('policyContent').value;

        // Prepare data
         const formData = {
             policyTitle: policyTitle,
            policyContent: policyContent
            };
        console.log(formData); // for debugging purposes
          // Reset the form
         document.getElementById('addPolicyForm').reset();
        // close modal
        const modal = document.getElementById('addPolicyModal');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
         // Display a success message or redirect to the patient list page
          alert("New policy added successfully, data logged in the console")
    });
    // Javascript implementation, You will have to implement the modify data with php
    document.getElementById('modifyPolicyForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

          // Get the data from the form
        const modifyPolicySelect = document.getElementById('modifyPolicySelect').value;
         const modifyPolicyContent = document.getElementById('modifyPolicyContent').value;

        // Prepare data
        const formData = {
            modifyPolicySelect: modifyPolicySelect,
            modifyPolicyContent: modifyPolicyContent
            };
        console.log(formData); // for debugging purposes

       // Reset the form
        document.getElementById('modifyPolicyForm').reset();
       // close modal
        const modal = document.getElementById('modifyPolicyModal');
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
      // Display a success message or redirect to the patient list page
       alert("Policy modified successfully, data logged in the console")
    });
 </script>
</body>
</html>