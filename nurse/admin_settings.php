<?php
include('../api/config/session_start.php');
include('../api/config/dbconn.php');
include('../nurse/assets/inc/header.php');
include('../nurse/assets/inc/sidebar.php');
include('../nurse/assets/inc/navbar.php');
?>
<main>
    <div class="container mt-4">
        <h1>System Settings</h1>
         <div class="row">
            <div class="col-12 col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title">General Settings</h5>
                    </div>
                     <div class="card-body">
                        <form id="generalSettingsForm" method="post" action="">
                               <div class="mb-3">
                                   <label for="clinicName" class="form-label">Clinic Name</label>
                                   <input type="text" class="form-control" id="clinicName" name="clinicName" value="Mini-Hospital" required>
                               </div>
                               <div class="mb-3">
                                  <label for="clinicAddress" class="form-label">Clinic Address</label>
                                  <input type="text" class="form-control" id="clinicAddress" name="clinicAddress" value="123 Main St" required>
                               </div>
                                <div class="mb-3">
                                   <label for="clinicContact" class="form-label">Contact Number</label>
                                    <input type="text" class="form-control" id="clinicContact" name="clinicContact" value="123-456-7890" required>
                                 </div>
                                 <div class="mb-3">
                                       <label for="clinicEmail" class="form-label">Clinic Email</label>
                                      <input type="email" class="form-control" id="clinicEmail" name="clinicEmail" value="info@example.com" required>
                                  </div>
                               <button type="submit" class="btn btn-primary">Save Changes</button>
                         </form>
                     </div>
                </div>
              </div>
             <div class="col-12 col-md-4">
                <div class="card shadow-sm">
                   <div class="card-header">
                      <h5 class="card-title">Theme Settings</h5>
                    </div>
                    <div class="card-body">
                         <form id="themeSettingsForm">
                           <div class="mb-3">
                            <label for="themeSelect" class="form-label">Theme</label>
                             <select class="form-select" id="themeSelect" name="themeSelect">
                                   <option value="light">Light</option>
                                     <option value="dark">Dark</option>
                            </select>
                         </div>
                         <button type="submit" class="btn btn-primary">Save Changes</button>
                       </form>
                   </div>
                </div>
            </div>
         </div>
    </div>
</main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
 <script>
    // Javascript implementation, You will have to implement the save data with php
   document.getElementById('generalSettingsForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

       // Get the data from the form
        const clinicName = document.getElementById('clinicName').value;
          const clinicAddress = document.getElementById('clinicAddress').value;
          const clinicContact = document.getElementById('clinicContact').value;
          const clinicEmail = document.getElementById('clinicEmail').value;
         // Prepare data
          const formData = {
           clinicName: clinicName,
          clinicAddress: clinicAddress,
           clinicContact: clinicContact,
             clinicEmail: clinicEmail
            };
          console.log(formData); // for debugging purposes
         // Display a success message or redirect to the patient list page
        alert("General Settings Saved, data has been logged in the console")
    });

   document.getElementById('themeSettingsForm').addEventListener('submit', function(event) {
         event.preventDefault();
        // Get the data from the form
         const themeSelect = document.getElementById('themeSelect').value;
        // Prepare data
         const formData = {
           themeSelect: themeSelect
            };
         console.log(formData); // for debugging purposes

         // Display a success message or redirect to the patient list page
          alert("Theme settings saved, data has been logged in the console")
         if(themeSelect === 'dark'){
          document.body.classList.add('dark-theme-variables')
       }else{
          document.body.classList.remove('dark-theme-variables');
        }
     });

</script>
</body>
</html>