<?php
include('../api/config/session_start.php');
include('../api/config/dbconn.php');
include('../client/assets/inc/header.php');
include('../client/assets/inc/sidebar.php');
include('../client/assets/inc/navbar.php');
include('../admin/assets/inc/footer.php');
?>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 w-50">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav nav-pills nav-justified mb-3">
                        <li class="nav-item">
                            <a href="#aboutme" data-bs-toggle="pill" class="nav-link active">Update Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="#settings" data-bs-toggle="pill" class="nav-link">Change Password</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="aboutme">
                            <form id="profileForm" method="post">
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>

                                <div class="form-group">
                                    <label for="inputFullname">Full Name</label>
                                    <input type="text" required name="fullname" class="form-control" id="inputFullname">
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail">Email Address</label>
                                    <input type="email" required name="email" class="form-control" id="inputEmail">
                                </div>

                                <div id="statusMessage" class="mt-2"></div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="settings">
                            <form id="changePasswordForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Old Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="old_password" id="oldPassword">
                                            <button class="btn btn-outline-secondary password-toggle" type="button" onclick="togglePassword('oldPassword')" title="Show/Hide Password">
                                                👁
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">New Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="new_password" id="newPassword">
                                            <button class="btn btn-outline-secondary password-toggle" type="button" onclick="togglePassword('newPassword')" title="Show/Hide Password">
                                                👁
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="confirm_password" id="confirmPassword">
                                        <button class="btn btn-outline-secondary password-toggle" type="button" onclick="togglePassword('confirmPassword')" title="Show/Hide Password">
                                            👁
                                        </button>
                                    </div>
                                </div>
                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-success">Update Password</button>
                                </div>
                                <div id="passwordStatusMessage" class="mt-2"></div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const profileForm = document.getElementById("profileForm");
            const profilePicInput = document.getElementById("inputProfile");
            const profilePicPreview = document.getElementById("profilePicPreview");
            const statusMessage = document.getElementById("statusMessage");

            // Handle profile update submission
            profileForm.addEventListener("submit", function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                fetch("../api/profile_management/update_profile.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        statusMessage.innerText = data.message;
                        statusMessage.style.color = data.success ? "green" : "red";
                    })
                    .catch(error => console.error("Error updating profile:", error));
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("#changePasswordForm");
            const oldPassword = document.getElementById("oldPassword");
            const newPassword = document.getElementById("newPassword");
            const confirmPassword = document.getElementById("confirmPassword");
            const passwordStatusMessage = document.getElementById("passwordStatusMessage");
            const strengthIndicator = document.createElement("div");

            newPassword.parentElement.appendChild(strengthIndicator);

            function togglePassword(fieldId) {
                const field = document.getElementById(fieldId);
                field.type = field.type === "password" ? "text" : "password";
            }

            function validatePassword() {
                const newPasswordValue = newPassword.value;
                const confirmPasswordValue = confirmPassword.value;
                let strength = checkPasswordStrength(newPasswordValue);

                strengthIndicator.innerHTML = `<span class="${strength.class}">${strength.text}</span>`;

                if (newPasswordValue.length < 8) {
                    passwordStatusMessage.innerHTML = '<span class="text-danger">Password must be at least 8 characters long.</span>';
                } else if (newPasswordValue !== confirmPasswordValue) {
                    passwordStatusMessage.innerHTML = '<span class="text-danger">Passwords do not match.</span>';
                } else {
                    passwordStatusMessage.innerHTML = '<span class="text-success">Passwords match!</span>';
                }
            }

            function checkPasswordStrength(password) {
                let strength = {
                    text: "Weak",
                    class: "text-danger"
                };
                const regexWeak = /[a-zA-Z0-9]{8,}/;
                const regexMedium = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}/;
                const regexStrong = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}/;

                if (regexStrong.test(password)) {
                    strength = {
                        text: "Strong",
                        class: "text-success"
                    };
                } else if (regexMedium.test(password)) {
                    strength = {
                        text: "Medium",
                        class: "text-warning"
                    };
                }

                return strength;
            }

            newPassword.addEventListener("input", validatePassword);
            confirmPassword.addEventListener("input", validatePassword);

            form.addEventListener("submit", function(e) {
                e.preventDefault();

                const newPasswordValue = newPassword.value;
                const confirmPasswordValue = confirmPassword.value;
                const oldPasswordValue = oldPassword.value;

                if (!oldPasswordValue || newPasswordValue.length < 8 || newPasswordValue !== confirmPasswordValue) {
                    passwordStatusMessage.innerHTML = '<div class="alert alert-danger">Please fix errors before updating.</div>';
                    return;
                }

                let formData = new FormData(this);

                fetch("../api/profile_management/change_password.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => {
                        console.log("🔹 Response Headers:", response.headers);
                        const contentType = response.headers.get("content-type");

                        if (!contentType || !contentType.includes("application/json")) {
                            throw new Error("❌ Invalid JSON response");
                        }

                        return response.json();
                    })
                    .then(data => {
                        console.log("✅ Parsed Data:", data);
                        if (data.status === "success") {
                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: data.message,
                                confirmButtonColor: "#28a745"
                            }).then(() => {
                                form.reset();
                                strengthIndicator.innerHTML = "";
                            });
                        } else {
                            passwordStatusMessage.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                        }
                    })
                    .catch(error => {
                        console.error("❌ Fetch Error:", error);
                        passwordStatusMessage.innerHTML = `<div class="alert alert-danger">An error occurred. Please try again.</div>`;
                    });



            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>