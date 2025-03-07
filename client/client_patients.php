<?php
include('../api/config/session_start.php');
include('../api/config/dbconn.php');
include('../client/assets/inc/header.php');
include('../client/assets/inc/sidebar.php');
include('../client/assets/inc/navbar.php');

?>
<main>
  <div class="container mt-4">
    <h1>Patient Management</h1>
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">List of Patients</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPatientModal">Add New Patient</button>
          </div>
          <!-- patients card -->
          <div class="container mt-4">
            <h1>My Patients</h1>
            <div class="row" id="patient-list"></div>
          </div>

          <!-- Add Patient Modal -->
          <div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addPatientModalLabel">Add New Patient</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="addPatientForm" method="post" action="">
                    <div class="mb-3">
                      <label for="patientName" class="form-label">Name</label>
                      <input type="text" class="form-control" id="patientName" name="patientName" required>
                    </div>
                    <div class="mb-3">
                      <label for="patientDob" class="form-label">Date of Birth</label>
                      <input type="date" class="form-control" id="patientDob" name="patientDob" required>
                    </div>
                    <div class="mb-3">
                      <label for="patientGender" class="form-label">Gender</label>
                      <select class="form-select" id="patientGender" name="patientGender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <input type="hidden" class="form-control" id="patientAge" name="patientAge" required>
                    </div>
                    <div class="mb-3">
                      <label for="patientContact" class="form-label">Contact Number</label>
                      <input type="text" class="form-control" id="patientContact" name="patientContact" required>
                    </div>
                    <div class="mb-3">
                      <label for="patientAddress" class="form-label">Address</label>
                      <input type="text" class="form-control" id="patientAddress" name="patientAddress" required>
                    </div>
                    <div class="mb-3">
                      <label for="patientMedicalHistory" class="form-label">Medical History</label>
                      <textarea class="form-control" id="patientMedicalHistory" name="patientMedicalHistory"></textarea>
                    </div>
                    <div class="mb-3">
                      <label for="patientAllergies" class="form-label">Allergies</label>
                      <textarea class="form-control" id="patientAllergies" name="patientAllergies"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Patient</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- View Patient Modal with Diagnostic -->
          <div class="modal fade" id="patientModal" tabindex="-1" aria-labelledby="patientModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="patientModalLabel">Patient Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <ul class="nav nav-tabs" id="patientTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">Patient Info</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="diagnostic-tab" data-bs-toggle="tab" data-bs-target="#diagnostic" type="button" role="tab" aria-controls="diagnostic" aria-selected="false">Diagnostic</button>
                    </li>
                  </ul>
                  <div class="tab-content mt-3" id="patientTabContent">
                    <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                      <p><strong>Name:</strong> <span id="modalPatientName"></span></p>
                      <p><strong>Age:</strong> <span id="modalPatientAge"></span></p>
                      <p><strong>Gender:</strong> <span id="modalPatientGender"></span></p>
                      <p><strong>Contact:</strong> <span id="modalPatientContact"></span></p>
                      <p><strong>Address:</strong> <span id="modalPatientAddress"></span></p>
                      <p><strong>Medical History:</strong> <span id="modalPatientMedicalHistory"></span></p>
                      <p><strong>Allergies:</strong> <span id="modalPatientAllergies"></span></p>
                    </div>
                    <div class="tab-pane fade" id="diagnostic" role="tabpanel" aria-labelledby="diagnostic-tab">
                      <p><strong>Published By:</strong> <span id="modalPublishedBy">No diagnostic conducted yet.</span></p>
                      <p><strong>Symptoms:</strong> <span id="modalPatientSymptoms">No diagnostic conducted yet.</span></p>
                      <p><strong>Explanation:</strong> <span id="modalPatientExplanation">No diagnostic explanation available.</span></p>
                      <strong>Diagnosis:</strong>
                      <div class="form-control" style="height: 300px; overflow-y: auto;">
                        <p><span id="modalPatientDiagnosis">No diagnostic results available.</span></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Edit Patient Modal -->
            <div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editPatientModalLabel">Edit Patient Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form id="editPatientForm" method="post" action="">
                      <input type="hidden" id="editPatientId" name="patientId">
                      <div class="mb-3">
                        <label for="editPatientName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editPatientName" name="patientName" required>
                      </div>
                      <div class="mb-3">
                        <label for="editPatientDob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="editPatientDob" name="patientDob" required>
                      </div>
                      <div class="mb-3">
                        <label for="editPatientGender" class="form-label">Gender</label>
                        <select class="form-select" id="editPatientGender" name="patientGender" required>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                          <option value="Other">Other</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="editPatientContact" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="editPatientContact" name="patientContact" required>
                      </div>
                      <div class="mb-3">
                        <label for="editPatientAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="editPatientAddress" name="patientAddress" required>
                      </div>
                      <div class="mb-3">
                        <label for="editPatientMedicalHistory" class="form-label">Medical History</label>
                        <textarea class="form-control" id="editPatientMedicalHistory" name="patientMedicalHistory"></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="editPatientAllergies" class="form-label">Allergies</label>
                        <textarea class="form-control" id="editPatientAllergies" name="patientAllergies"></textarea>
                      </div>
                      <button type="submit" class="btn btn-success">Save Changes</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  //add patient form
  document.getElementById('addPatientForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Ensure patientAge is calculated
    const dobInput = document.getElementById('patientDob').value;
    if (dobInput) {
      const dob = new Date(dobInput);
      const today = new Date();
      let age = today.getFullYear() - dob.getFullYear();
      if (today.getMonth() < dob.getMonth() || (today.getMonth() === dob.getMonth() && today.getDate() < dob.getDate())) {
        age--;
      }
      document.getElementById('patientAge').value = age; // Set in form field
    }

    // Now fetch all form values correctly
    const formData = {
      patientName: document.getElementById('patientName').value,
      patientDob: document.getElementById('patientDob').value,
      patientGender: document.getElementById('patientGender').value,
      patientContact: document.getElementById('patientContact').value,
      patientAddress: document.getElementById('patientAddress').value,
      patientMedicalHistory: document.getElementById('patientMedicalHistory').value,
      patientAllergies: document.getElementById('patientAllergies').value,
      patientAge: document.getElementById('patientAge').value // Now patientAge is guaranteed to be set
    };

    fetch('../api/client/patient_management/add_patient.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert("Patient Added Successfully");
          const modal = document.getElementById('addPatientModal');
          const modalInstance = bootstrap.Modal.getInstance(modal);
          modalInstance.hide();
          document.getElementById('addPatientForm').reset();
          location.reload();
        } else {
          alert('Failed to add patient: ' + data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Failed to add patient!');
      });
  });
  //list patient in card type
  document.addEventListener('DOMContentLoaded', function() {
    fetch('../api/client/patient_management/list_patients.php')
      .then(response => response.json())
      .then(data => {
        const patientList = document.getElementById('patient-list');
        if (data.success) {
          data.patients.forEach(patient => {
            const card = `
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm bg-success">
                            <div class="card-body">
                                <h5 class="card-title">${patient.patient_name}</h5>
                                <p class="card-text">Age: ${patient.age}</p>
                                <p class="card-text">Gender: ${patient.gender}</p>
                                <button class="btn btn-primary view-patient" data-id="${patient.patient_id}" data-bs-toggle="modal" data-bs-target="#patientModal">View</button>
                                <button class="btn btn-danger delete-patient" data-id="${patient.patient_id}">Delete</button>
                            </div>
                        </div>
                    </div>`;
            patientList.innerHTML += card;
          });
        } else {
          patientList.innerHTML = '<p>No patients found.</p>';
        }
      })
      .catch(error => console.error('Error fetching patients:', error));
    //view patient modal
    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('view-patient')) {
        const patientId = e.target.getAttribute('data-id');
        fetch(`../api/client/patient_management/get_patient.php?patientId=${patientId}`)
          .then(response => response.json())
          .then(patient => {
            if (patient.success) {
              document.getElementById('modalPatientName').textContent = patient.data.patient_name;
              document.getElementById('modalPatientAge').textContent = patient.data.age;
              document.getElementById('modalPatientGender').textContent = patient.data.gender;
              document.getElementById('modalPatientContact').textContent = patient.data.contact_number;
              document.getElementById('modalPatientAddress').textContent = patient.data.address;
              document.getElementById('modalPatientMedicalHistory').textContent = patient.data.medical_history;
              document.getElementById('modalPatientAllergies').textContent = patient.data.allergies;
              document.getElementById('modalPatientSymptoms').textContent = patient.data.selected_symptoms || 'No diagnostic conducted yet.';
              document.getElementById('modalPatientExplanation').textContent = patient.data.detailed_explanation || 'No diagnostic explanation available.';
              document.getElementById('modalPatientDiagnosis').textContent = patient.data.sickness_description || 'No diagnostic results available.';
              document.getElementById('modalPublishedBy').textContent = patient.data.published_by_name || 'No diagnostic results available.';



            }
          });
      } else if (e.target.classList.contains('delete-patient')) {
        const patientId = e.target.getAttribute('data-id');
        if (confirm('Are you sure you want to delete this patient?')) {
          fetch(`../api/client/patient_management/delete_patient.php?patientId=${patientId}`, {
              method: 'DELETE',
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                alert('Patient deleted successfully!');
                location.reload(); // Reload to update the patient list
              } else {
                alert('Failed to delete patient: ' + data.message);
              }
            })
            .catch(error => {
              console.error('Error:', error);
              alert('Failed to delete patient!');
            });
        }
      }
    });



    document.getElementById('editPatientForm').addEventListener('submit', function(event) {
      event.preventDefault();
      const formData = new FormData(this);
      fetch('../api/client/patient_management/edit_patient.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Patient info updated successfully!');
            bootstrap.Modal.getInstance(document.getElementById('editPatientModal')).hide();
            location.reload();
          } else {
            alert('Failed to update patient info: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Failed to update patient info!');
        });
    });

  });
</script>
</body>

</html>"