<div class="modal fade" id="viewPatientModal" tabindex="-1" aria-labelledby="viewPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Use modal-xl for a larger modal -->
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
                            <p><strong>Gender:</strong> <span id="patientGenderDisplay"></span></p>
                            <p><strong>Contact Number:</strong> <span id="patientContactDisplay"></span></p>
                            <p><strong>Address:</strong> <span id="patientAddressDisplay"></span></p>
                            <p><strong>Admission type:</strong> <span id="patientAddressDisplay"></span></p>
                            <p><strong>patient_status:</strong> <span id="patientAddressDisplay"></span></p>
                            <button id="editPatientButton" class="btn btn-sm btn-primary">Edit</button>
                        </div>

                        <!-- Middle Column: Diagnostic/Checkup Part -->
                        <div id="symptomsAccordion">
                            <!-- General Symptoms -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingGeneral">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral" aria-expanded="true" aria-controls="collapseGeneral">
                                        General Symptoms
                                        <i class="bi bi-plus-lg"></i>
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <h5>Detailed Explanation</h5>
                                    <textarea class="form-control" id="detailedExplanation" rows="3"></textarea>
                                </div>
                                <div class="mt-3">
                                    <h5>Gemini AI Suggestions for the Sickness</h5>
                                    <textarea class="form-control" id="aiSuggestions" rows="3" readonly></textarea>
                                </div>
                                <button class="btn btn-secondary mt-3" id="generateResultButton">Generate Result</button>
                                <button class="btn btn-secondary mt-3">Add to Result</button>
                            </div>

                            <!-- Right Column: Result -->
                            <div class="col-md-4">
                                <h4>Result</h4>
                                <div>
                                    <h5>Detailed Confirmed Sickness Description</h5>
                                    <textarea class="form-control" id="sicknessDescription" rows="3" readonly></textarea>
                                </div>
                                <div class="mt-3">
                                    <h5>Gemini AI Suggestions for Health Recovery</h5>
                                    <textarea class="form-control" id="healthRecovery" rows="3" readonly></textarea>
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

    <script>
         function getSelectedSymptoms() {
        const selectedSymptoms = [];
        document.querySelectorAll('#symptomsAccordion input[type="checkbox"]:checked').forEach(checkbox => {
            selectedSymptoms.push(checkbox.value);
        });
    return selectedSymptoms
    }

    function getModalData() {
        // Get selected symptoms
        const selectedSymptoms = getSelectedSymptoms();

        // Get detailed explanation
        const detailedExplanation = document.getElementById('detailedExplanation').value;
          //Add all the data to a formData object
        const formData = {
            symptoms: selectedSymptoms,
           explanation: detailedExplanation
        };
        return formData
    }

     //Handle to generate the result from the gemini API
     document.getElementById('generateResultButton').addEventListener('click', function(event) {
              const modal = document.getElementById('viewInventoryModal');
              //prevents the from from being reloaded
            event.preventDefault();
            const aiSuggestionsTextArea = document.getElementById('aiSuggestions');
            const sicknessDescriptionTextArea = document.getElementById('sicknessDescription');
             // Get all modal data
                const formData = getModalData();
             //fetch this api to send to get gennedated ai suggestions
              fetch('../api/gemini/generate_suggestions.php', {
                method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                },
                  body: JSON.stringify(formData)
                })
                .then(response => {
                    if (!response.ok) {
                      throw new Error('Failed to generate AI suggestions');
                     }
                    return response.json();
                })
                 .then(data => {
                  if (data.success) {
                        document.getElementById('aiSuggestions').value = data.aiSickness;
                       document.getElementById('sicknessDescription').value = data.aiHealth;
                   } else {
                        alert('Failed to generate AI suggestions' + data.message);
                    }
               })
               .catch(error => {
                 console.error('Error:', error);
                    alert('Failed to generate AI suggestions!');
                });
        });

   // Handle to add to the result after you press the add to the result button
     document.getElementById('addResultButton').addEventListener('click', function(event) {
         //code will be added here for the add result button
     });
    </script>