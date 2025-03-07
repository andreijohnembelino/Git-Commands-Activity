<?php
include('../api/config/session_start.php');
include('../api/config/dbconn.php');
include('../nurse/assets/inc/header.php');
include('../nurse/assets/inc/sidebar.php');
include('../nurse/assets/inc/navbar.php');
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
          <!-- Filter Options -->
          <div class="card-body">
            <form id="patientFilterForm">
              <div class="row g-3 mb-3">
                <div class="col-md-4">
                  <label for="filterName" class="form-label">Name</label>
                  <input type="text" class="form-control" id="filterName" name="filterName" placeholder="Enter Patient Name">
                </div>
                <div class="col-md-4">
                  <label for="filterAge" class="form-label">Age</label>
                  <input type="number" class="form-control" id="filterAge" name="filterAge" placeholder="Enter age">
                </div>
                <div class="col-md-4">
                  <label for="filterGender" class="form-label">Gender</label>
                  <select class="form-select" id="filterGender" name="filterGender">
                    <option value="">All</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                  </select>
                </div>
              </div>
              <div class="row g-3 mb-3">
                <div class="col-md-4">
                  <label for="filterAdmissionType" class="form-label">Admission Type</label>
                  <select class="form-select" id="filterAdmissionType" name="filterAdmissionType">
                    <option value="">All</option>
                    <option value="staff">Staff</option>
                    <option value="self-registered">Self-Registered</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="filterStatus" class="form-label">Patient Status</label>
                  <select class="form-select" id="filterStatus" name="filterStatus">
                    <option value="">All</option>
                    <option value="active">Active</option>
                    <option value="discharged">Discharged</option>
                  </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                  <button type="submit" class="btn btn-secondary w-100" id="applyFiltersButton">Apply Filters</button>
                </div>
              </div>
              <div class="row g-3 mb-3">

              </div>
            </form>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Admission Type</th>
                    <th>Patient Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="patient-table-body">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
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

  <!-- Diagnostic Result Modal -->
  <div class="modal fade" id="diagnosticResultModal" tabindex="-1" aria-labelledby="diagnosticResultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="diagnosticResultModalLabel">Diagnostic Result</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p><strong>Patient Symptoms:</strong> <span id="patientSymptomsDisplay"></span></p>
          <p><strong>Detailed Explanation:</strong></p>
          <textarea class="form-control" id="patientDetailExplanationDisplay" rows="4" readonly style="overflow-y:auto;resize: none;"></textarea>
          <p><strong>Sickness Description and Approved Medication:</strong></p>
          <textarea class="form-control" id="patientSicknessDescriptionDisplay" rows="6" readonly style="overflow-y:auto;resize: none;"></textarea>
          <p><strong>Published By:</strong> <span id="publishedByDisplay"></span></p>
        </div>
      </div>
    </div>
  </div>


  <!-- View Patient Modal -->
  <div class="modal fade" id="viewPatientModal" tabindex="-1" aria-labelledby="viewPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewPatientModalLabel">Patient Details and Checkup</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <!-- Left Column: Patient Details -->
              <div class="col-md-4">
                <h4>Patient Details</h4>
                <p><strong>Patient ID:</strong> <span id="patientIdDisplay"></span></p>
                <p><strong>Name:</strong> <span id="patientNameDisplay"></span></p>
                <p><strong>Date of Birth:</strong> <span id="patientDobDisplay"></span></p>
                <p><strong>Age:</strong> <span id="patientAgeDisplay"></span></p>
                <p><strong>Gender:</strong> <span id="patientGenderDisplay"></span></p>
                <p><strong>Contact Number:</strong> <span id="patientContactDisplay"></span></p>
                <p><strong>Address:</strong> <span id="patientAddressDisplay"></span></p>
                <p><strong>Admission Type:</strong> <span id="patientAdmissionTypeDisplay"></span></p>
                <p><strong>Patient Status:</strong> <span id="patientStatusDisplay"></span></p>
                <p><strong>Medical History:</strong> <span id="patientMedicalHistoryDisplay"></span></p>
                <p><strong>Allergies:</strong> <span id="patientAllergiesDisplay"></span></p>
              </div>

              <!-- Middle Column: Diagnostic/Checkup Part -->
              <div class="col-md-4">
                <h4>Diagnostic or Checkup</h4>
                <div id="symptomsAccordion">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingGeneral">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral" aria-expanded="true" aria-controls="collapseGeneral">
                        <i class="bi bi-plus-lg"></i> General Symptoms
                      </button>
                    </h2>
                    <div id="collapseGeneral" class="accordion-collapse collapse show" aria-labelledby="headingGeneral" data-bs-parent="#symptomsAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="fever" id="symptomFever">
                              <label class="form-check-label" for="symptomFever">Fever</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="cough" id="symptomCough">
                              <label class="form-check-label" for="symptomCough">Cough</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="fatigue" id="symptomFatigue">
                              <label class="form-check-label" for="symptomFatigue">Fatigue</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="weakness" id="symptomWeakness">
                              <label class="form-check-label" for="symptomWeakness">Weakness</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="chills" id="symptomChills">
                              <label class="form-check-label" for="symptomChills">Chills</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="nightSweats" id="symptomNightSweats">
                              <label class="form-check-label" for="symptomNightSweats">Night sweats</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Respiratory Symptoms -->
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingRespiratory">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRespiratory" aria-expanded="false" aria-controls="collapseRespiratory">
                        <i class="bi bi-plus-lg"></i> Respiratory Symptoms
                      </button>
                    </h2>
                    <div id="collapseRespiratory" class="accordion-collapse collapse" aria-labelledby="headingRespiratory" data-bs-parent="#symptomsAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="shortnessOfBreath" id="symptomShortnessOfBreath">
                              <label class="form-check-label" for="symptomShortnessOfBreath">Shortness of breath (dyspnea)</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="soreThroat" id="symptomSoreThroat">
                              <label class="form-check-label" for="symptomSoreThroat">Sore throat</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="runnyNose" id="symptomRunnyNose">
                              <label class="form-check-label" for="symptomRunnyNose">Runny or stuffy nose</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="sneezing" id="symptomSneezing">
                              <label class="form-check-label" for="symptomSneezing">Sneezing</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="wheezing" id="symptomWheezing">
                              <label class="form-check-label" for="symptomWheezing">Wheezing</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="chestPain" id="symptomChestPain">
                              <label class="form-check-label" for="symptomChestPain">Chest pain</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Digestive Symptoms -->
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDigestive">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDigestive" aria-expanded="false" aria-controls="collapseDigestive">
                        <i class="bi bi-plus-lg"></i> Digestive Symptoms
                      </button>
                    </h2>
                    <div id="collapseDigestive" class="accordion-collapse collapse" aria-labelledby="headingDigestive" data-bs-parent="#symptomsAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="nausea" id="symptomNausea">
                              <label class="form-check-label" for="symptomNausea">Nausea</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="vomiting" id="symptomVomiting">
                              <label class="form-check-label" for="symptomVomiting">Vomiting</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="diarrhea" id="symptomDiarrhea">
                              <label class="form-check-label" for="symptomDiarrhea">Diarrhea</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="constipation" id="symptomConstipation">
                              <label class="form-check-label" for="symptomConstipation">Constipation</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="abdominalPain" id="symptomAbdominalPain">
                              <label class="form-check-label" for="symptomAbdominalPain">Abdominal pain</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="bloating" id="symptomBloating">
                              <label class="form-check-label" for="symptomBloating">Bloating</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Neurological Symptoms -->
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingNeurological">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNeurological" aria-expanded="false" aria-controls="collapseNeurological">
                        <i class="bi bi-plus-lg"></i> Neurological Symptoms
                      </button>
                    </h2>
                    <div id="collapseNeurological" class="accordion-collapse collapse" aria-labelledby="headingNeurological" data-bs-parent="#symptomsAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="headache" id="symptomHeadache">
                              <label class="form-check-label" for="symptomHeadache">Headache</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="dizziness" id="symptomDizziness">
                              <label class="form-check-label" for="symptomDizziness">Dizziness</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="confusion" id="symptomConfusion">
                              <label class="form-check-label" for="symptomConfusion">Confusion</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="numbness" id="symptomNumbness">
                              <label class="form-check-label" for="symptomNumbness">Numbness or tingling</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="muscleWeakness" id="symptomMuscleWeakness">
                              <label class="form-check-label" for="symptomMuscleWeakness">Muscle weakness</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Skin-Related Symptoms -->
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSkin">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSkin" aria-expanded="false" aria-controls="collapseSkin">
                        <i class="bi bi-plus-lg"></i> Skin-Related Symptoms
                      </button>
                    </h2>
                    <div id="collapseSkin" class="accordion-collapse collapse" aria-labelledby="headingSkin" data-bs-parent="#symptomsAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="rash" id="symptomRash">
                              <label class="form-check-label" for="symptomRash">Rash</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="itching" id="symptomItching">
                              <label class="form-check-label" for="symptomItching">Itching</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="swelling" id="symptomSwelling">
                              <label class="form-check-label" for="symptomSwelling">Swelling</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="bruising" id="symptomBruising">
                              <label class="form-check-label" for="symptomBruising">Bruising</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="paleSkin" id="symptomPaleSkin">
                              <label class="form-check-label" for="symptomPaleSkin">Pale or bluish skin (cyanosis)</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Pain-Related Symptoms -->
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPain">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePain" aria-expanded="false" aria-controls="collapsePain">
                        <i class="bi bi-plus-lg"></i> Pain-Related Symptoms
                      </button>
                    </h2>
                    <div id="collapsePain" class="accordion-collapse collapse" aria-labelledby="headingPain" data-bs-parent="#symptomsAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="jointPain" id="symptomJointPain">
                              <label class="form-check-label" for="symptomJointPain">Joint pain</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="musclePain" id="symptomMusclePain">
                              <label class="form-check-label" for="symptomMusclePain">Muscle pain (myalgia)</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="backPain" id="symptomBackPain">
                              <label class="form-check-label" for="symptomBackPain">Back pain</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="chestPain" id="symptomChestPain2">
                              <label class="form-check-label" for="symptomChestPain2">Chest pain</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Eye & Ear Symptoms -->
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="headingEyeEar">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEyeEar" aria-expanded="false" aria-controls="collapseEyeEar">
                        <i class="bi bi-plus-lg"></i> Eye & Ear Symptoms
                      </button>
                    </h2>
                    <div id="collapseEyeEar" class="accordion-collapse collapse" aria-labelledby="headingEyeEar" data-bs-parent="#symptomsAccordion">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="redEyes" id="symptomRedEyes">
                              <label class="form-check-label" for="symptomRedEyes">Red or itchy eyes</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="blurredVision" id="symptomBlurredVision">
                              <label class="form-check-label" for="symptomBlurredVision">Blurred vision</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="earPain" id="symptomEarPain">
                              <label class="form-check-label" for="symptomEarPain">Ear pain</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="hearingLoss" id="symptomHearingLoss">
                              <label class="form-check-label" for="symptomHearingLoss">Hearing loss</label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button id="clearSymptomsBtn" class="btn btn-secondary  mt-3">Clear Selection</button>
                  </div>
                </div>
                <div class="mt-3">
                  <h5>Detailed Explanation</h5>
                  <textarea class="form-control" id="detailedExplanation" rows="3" style="
    overflow-y:auto; 
    resize: none;
    transition: height 3.3s ease-in-out;
    min-height: 300px;"></textarea>
                </div>
                <h5>Result</h5>
                <div>
                  <h6>Detailed Confirmed Sickness Description With Medication</h6>
                  <textarea class="form-control" id="sicknessDescription" rows="3" style="
    overflow-y:auto; 
    resize: none;
    transition: height 3.3s ease-in-out;
    min-height: 300px;"></textarea>
                </div>
                <button class="btn btn-secondary mt-3" id="publishBtn">Publish Result</button>
              </div>





              <!-- Right Column: Result -->
              <div class="col-md-4">
                <h4>Ask AI Assistant</h4>
                <div class="mt-3">
                  <h5>AI possible Sickness Suggestions And Health Recovery Recommendations</h5>
                  <textarea class="form-control" id="aiSuggestions" rows="3" readonly style="
    overflow-y:auto; 
    resize: none;
    transition: height 3.3s ease-in-out;
    min-height: 400px;"></textarea>
                </div>
                <button class="btn btn-secondary mt-3" id="generateResultButton">Generate Result</button>
                <div id="loadingIndicator" style="display: none;">
                  <span class="spinner-border text-primary" role="status"></span> Generating AI suggestions...
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Function to fetch and display patient data
  function fetchPatientsData(filterData = {}) {
    fetch('../api/patients_management/list_patients.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          filterData: filterData
        })
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Failed to fetch patients');
        }
        return response.json();
      })
      .then(patients => {
        displayPatients(patients);
      })
      .catch(error => {
        console.error('Error fetching patients:', error);
        alert('Failed to fetch patients');
      });
  }
  // Function to display patient data in the table
  function displayPatients(patients) {
    const tableBody = document.getElementById('patient-table-body');
    tableBody.innerHTML = ''; // Clear existing data
    patients.forEach(patient => {
      const row = tableBody.insertRow();
      row.innerHTML = `
                      <td>${patient.patient_id}</td>
                     <td>${patient.patient_name}</td>
                      <td>${patient.age}</td>
                      <td>${patient.gender}</td>
                      <td>${patient.admission_type}</td>
                      <td>${patient.patient_status}</td>
                       <td>
                         <button class="btn btn-sm btn-info view-patient-btn" data-bs-toggle="modal" data-bs-target="#viewPatientModal" data-patient-id="${patient.patient_id}">Conduct Diagnostic</button>
                         <button class="btn btn-sm btn-success view-diagnostic-btn" data-bs-toggle="modal" data-bs-target="#diagnosticResultModal" data-patient-id="${patient.patient_id}">Diagnostic Result</button>
                         </td>
                      `;
    });
  }
  // handle filter form
  document.getElementById('patientFilterForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting normally
    // Get all the filter values
    const filterName = document.getElementById('filterName').value;
    const filterAge = document.getElementById('filterAge').value;
    const filterGender = document.getElementById('filterGender').value;
    const filterAdmissionType = document.getElementById('filterAdmissionType').value;
    const filterStatus = document.getElementById('filterStatus').value;
    // Prepare filter data
    const filterData = {
      filterName: filterName,
      filterAge: filterAge,
      filterGender: filterGender,
      filterAdmissionType: filterAdmissionType,
      filterStatus: filterStatus,
    };
    fetchPatientsData(filterData); // Fetch data with filters
  });


  // Add patient button
  document.getElementById('addPatientForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting normally
    // Get form values (you can add validation in here)
    const patientName = document.getElementById('patientName').value;
    const patientDob = document.getElementById('patientDob').value;
    const patientGender = document.getElementById('patientGender').value;
    const patientContact = document.getElementById('patientContact').value;
    const patientAddress = document.getElementById('patientAddress').value;
    const patientMedicalHistory = document.getElementById('patientMedicalHistory').value;
    const patientAllergies = document.getElementById('patientAllergies').value;
    const patientAge = document.getElementById('patientAge').value;
    // Prepare data
    const formData = {
      patientName: patientName,
      patientDob: patientDob,
      patientGender: patientGender,
      patientContact: patientContact,
      patientAddress: patientAddress,
      patientMedicalHistory: patientMedicalHistory,
      patientAllergies: patientAllergies,
      patientAge: patientAge
    };
    fetch('../api/patients_management/add_patient.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Failed to add patient');
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          alert("Patient Added Successfully");
          document.getElementById('patientFilterForm').dispatchEvent(new Event('submit'));
          const modal = document.getElementById('addPatientModal');
          const modalInstance = bootstrap.Modal.getInstance(modal);
          modalInstance.hide();
          document.getElementById('addPatientForm').reset();
        } else {
          alert('Failed to add patient: ' + data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Failed to add patient!');
      });
  });

  //age calculator
  document.getElementById('patientDob').addEventListener('change', function() {
    const dob = new Date(this.value);
    const today = new Date();
    let age = today.getFullYear() - dob.getFullYear();
    const month = today.getMonth() - dob.getMonth();
    if (month < 0 || (month === 0 && today.getDate() < dob.getDate())) {
      age--;
    }
    document.getElementById('patientAge').value = age;
  });


  //Conduct diagnostic modal function
  document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(event) {
      if (event.target.classList.contains('view-patient-btn')) {
        const patientId = event.target.getAttribute('data-patient-id');
        fetchPatientItem(patientId);
      }
    });
  });
//display patient details
  function fetchPatientItem(patientId) {
    fetch(`../api/patients_management/get_patient.php?patientId=${patientId}`)
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Populate the modal with item details
          const patient = data.data;
          document.getElementById('patientIdDisplay').textContent = patient.patient_id;
          document.getElementById('patientNameDisplay').textContent = patient.patient_name;
          document.getElementById('patientDobDisplay').textContent = patient.date_of_birth;
          document.getElementById('patientAgeDisplay').textContent = patient.age;
          document.getElementById('patientGenderDisplay').textContent = patient.gender;
          document.getElementById('patientContactDisplay').textContent = patient.contact_number;
          document.getElementById('patientAddressDisplay').textContent = patient.address;
          document.getElementById('patientMedicalHistoryDisplay').textContent = patient.medical_history;
          document.getElementById('patientAllergiesDisplay').textContent = patient.allergies;
          document.getElementById('patientAdmissionTypeDisplay').textContent = patient.admission_type;
          document.getElementById('patientStatusDisplay').textContent = patient.patient_status;
          // Ensure symptoms exist before joining
          document.getElementById('patientSymptomsDisplay').value = Array.isArray(patient.selectedSymptoms) ?
            patient.selectedSymptoms.join(", ") :
            "No symptoms recorded";

          // Set explanation and sickness description (handle null values)
          document.getElementById('patientDetailExplanationDisplay').value =
            patient.detailedExplanation || "No detailed explanation available";
          document.getElementById('patientSicknessDescriptionDisplay').value =
            patient.sicknessDescription || "No sickness description available";
        } else {
          alert('Failed to retrieve item details.');
        }
      })
      .catch(error => console.error('Error:', error));
  }
  //display selected symptoms in list
  document.addEventListener("DOMContentLoaded", function() {
    const symptomCheckboxes = document.querySelectorAll(".form-check-input");
    const selectedSymptomsContainer = document.createElement("div");
    selectedSymptomsContainer.id = "selectedSymptomsContainer";
    selectedSymptomsContainer.innerHTML = `
        <h5><strong>Selected Symptoms:</strong></h5>
        <ul id='selectedSymptomsList' class="list-group"></ul>
    `;
    document.querySelector("#symptomsAccordion").insertAdjacentElement("afterend", selectedSymptomsContainer);

    const generateButton = document.getElementById('generateResultButton');
    const clearSymptomsBtn = document.getElementById("clearSymptomsBtn");
    const loadingIndicator = document.getElementById('loadingIndicator');
    const aiSuggestions = document.getElementById('aiSuggestions');
    const healthRecovery = document.getElementById('healthRecovery');

    // Function to get selected symptoms
    function getSelectedSymptoms() {
      return Array.from(symptomCheckboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value);
    }

    // Function to update selected symptoms display
    function updateSelectedSymptoms() {
      const selectedSymptomsList = document.getElementById("selectedSymptomsList");
      selectedSymptomsList.innerHTML = "";

      const selectedSymptoms = getSelectedSymptoms();

      if (selectedSymptoms.length === 0) {
        selectedSymptomsList.innerHTML = `<li class="list-group-item text-muted">No symptoms selected</li>`;
      } else {
        selectedSymptoms.forEach(symptom => {
          const listItem = document.createElement("li");
          listItem.textContent = symptom;
          listItem.classList.add("list-group-item");
          selectedSymptomsList.appendChild(listItem);
        });
      }
    }

    // Function to show/hide loading indicator
    function toggleLoading(show) {
      loadingIndicator.style.display = show ? 'block' : 'none';
      if (generateButton) generateButton.disabled = show;
    }

    // Handle AI Suggestion Generation
    if (generateButton) {
      generateButton.addEventListener('click', function() {
        const symptoms = getSelectedSymptoms();
        const explanation = document.getElementById('detailedExplanation').value.trim();

        // Validation Checks
        if (symptoms.length === 0) {
          alert('⚠ Please select at least one symptom.');
          return;
        }
        if (!explanation) {
          alert('⚠ Please provide a detailed explanation.');
          return;
        }

        // Prepare Data to Send
        const formData = {
          symptoms,
          explanation
        };

        // Show Loading Indicator
        toggleLoading(true);

        // Fetch API Request
        fetch('../api/gemini/generate_suggestions.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
          })
          .then(response => response.json())
          .then(data => {
            const combinedResult = `${data.aiSickness || "⚠ No diagnosis available."}\n\n${data.aiHealth || "⚠ No recommendations available."}`;
            // Display in a single text area
            aiSuggestions.textContent = combinedResult;
          })
          .catch(error => {
            console.error('Error:', error);
            alert('❌ An error occurred while generating suggestions.');
          })
          .finally(() => toggleLoading(false)); // Hide Loading Indicator
      });
    }

    function autoExpandTextarea() {
      const textarea = document.getElementById('aiSuggestions');

      // Reset height to auto before calculating new height
      textarea.style.height = 'auto';

      // Set new height based on scrollHeight
      textarea.style.height = textarea.scrollHeight + 'px';
    }


    // Clear Selection Button Functionality
    function clearAllSymptoms() {
      symptomCheckboxes.forEach(checkbox => checkbox.checked = false);
      updateSelectedSymptoms();
    }

    // Add event listeners to checkboxes
    symptomCheckboxes.forEach(checkbox => checkbox.addEventListener("change", updateSelectedSymptoms));

    // Add event listener for clearing symptoms
    if (clearSymptomsBtn) {
      clearSymptomsBtn.addEventListener("click", clearAllSymptoms);
    }

    // Initialize with no symptoms selected
    updateSelectedSymptoms();



    //publish button
    const publishBtn = document.getElementById('publishBtn');
    if (publishBtn) {
      publishBtn.addEventListener('click', publishResult);
    } else {
      console.error("publishBtn element not found!");
    }

    //Process the publish result
    function publishResult() {
      // Get selected symptoms using the existing function
      const selectedSymptoms = getSelectedSymptoms();
      // Get the patientId from the span element and convert it to a number
      const patientIdString = document.getElementById('patientIdDisplay').textContent.trim();
      const patientId = parseInt(patientIdString, 10);

      // Get the detailed explanation
      const detailedExplanation = document.getElementById('detailedExplanation').value.trim();

      // Get the confirmed sickness description with medication
      const sicknessDescription = document.getElementById('sicknessDescription').value.trim();

      // Validation
      if (selectedSymptoms.length === 0) {
        alert('⚠ Please select at least one symptom.');
        return;
      }
      if (!detailedExplanation) {
        alert('⚠ Please provide a detailed explanation.');
        return;
      }
      if (!sicknessDescription) {
        alert('⚠ Please provide a detailed confirmed sickness description with medication.');
        return;
      }

      // Prepare data to send
      const formData = {
        symptoms: selectedSymptoms,
        explanation: detailedExplanation,
        sicknessDescription: sicknessDescription,
        patientId: patientId
      };

      // Diagnotic modal 
      fetch('../api/patients_management/publish_result.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('✅ Result published successfully!');
            document.getElementById('patientSymptomsDisplay').value = selectedSymptoms.join(", ");
            document.getElementById('patientDetailExplanationDisplay').value = detailedExplanation;
            document.getElementById('patientSicknessDescriptionDisplay').value = sicknessDescription;
          } else {
            alert(`❌ Failed to publish result: ${data.message}`);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('❌ An error occurred while publishing the result.');
        });
    }


  });
  document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('click', function(event) {
      if (event.target.classList.contains('view-diagnostic-btn')) {
        const patientId = event.target.getAttribute('data-patient-id');
        fetchDiagnosticResult(patientId);
      }
    });
  });

  function fetchDiagnosticResult(patientId) {
    fetch(`../api/patients_management/get_diagnostic_result.php?patientId=${patientId}`)
      .then(response => response.json())
      .then(data => {
        console.log("API Response:", data); // Debugging output

        if (data.success) {
          const diagnostic = data.data;

          // ✅ Correctly set values
          document.getElementById('patientSymptomsDisplay').textContent =
            diagnostic.selectedSymptoms.length ? diagnostic.selectedSymptoms.join(", ") : "No symptoms recorded";

          document.getElementById('patientDetailExplanationDisplay').value =
            diagnostic.detailedExplanation || "No detailed explanation available";

          document.getElementById('patientSicknessDescriptionDisplay').value =
            diagnostic.sicknessDescription || "No sickness description available";

          document.getElementById('publishedByDisplay').textContent =
            diagnostic.published_by_name || "Unknown User";

        } else {
          alert('❌ Failed to retrieve diagnostic results: ' + data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('❌ An error occurred while fetching the diagnostic data.');
      });
  }





  // Fetch patients on page load (initial display)
  fetchPatientsData();
</script>
</body>

</html>"