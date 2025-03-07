<?php
include('../api/config/session_start.php');
include('../api/config/dbconn.php');
include('../admin/assets/inc/header.php');
include('../admin/assets/inc/sidebar.php');
include('../admin/assets/inc/navbar.php');
?>
<main>
    <div class="container mt-4">
        <h1>User Management</h1>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">List of Users</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</button>
                    </div>
                    <!-- Filter Options -->
                    <div class="card-body">
                        <form id="userFilterForm">
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label for="filterName" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="filterName" name="filterName" placeholder="Enter User Name">
                                </div>
                                <div class="col-md-4">
                                    <label for="filterRole" class="form-label">Role</label>
                                    <select class="form-select" id="filterRole" name="filterRole">
                                        <option value="">All</option>
                                        <option value="admin">Admin</option>
                                        <option value="doctor">Doctor</option>
                                        <option value="nurse">Nurse</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="userTableBody"> <!-- Data will be inserted here --></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" method="post" action="">
                        <div class="mb-3">
                            <label for="userName" class="form-label">Name</label>
                            <input type="text" class="form-control input-validate" id="userName" name="userName" required>
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" class="form-control input-validate" id="userEmail" name="userEmail" required>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="userPassword" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control input-validate" id="userPassword" name="userPassword" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="userPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="confirmPassword" class="form-label">Retype Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control input-validate" id="confirmPassword" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirmPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div id="passwordMatchMessage" class="mt-1 text-danger small"></div>
                        </div>
                        <div class="mb-3">
                            <label for="userRole" class="form-label">Role</label>
                            <select class="form-select input-validate" id="userRole" name="userRole" required>
                                <option value="admin">Admin</option>
                                <option value="doctor">Doctor</option>
                                <option value="nurse">Nurse</option>
                                <option value="receptionist">Receptionist</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons (for visibility toggle) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


   <!-- Update User Modal -->
<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateUserForm">
                <div class="modal-body">
                    <input type="hidden" id="updateUserId" name="userId">

                    <div class="mb-3">
                        <label for="updateUserName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="updateUserName" name="userName" required>
                    </div>

                    <div class="mb-3">
                        <label for="updateUserEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="updateUserEmail" name="userEmail" required>
                    </div>

                    <div class="mb-3">
                        <label for="updateUserRole" class="form-label">Role</label>
                        <select class="form-control" id="updateUserRole" name="userRole" required>
                            <option value="Admin">Admin</option>
                            <option value="Doctor">Doctor</option>
                            <option value="Nurse">Nurse</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="updateUserPassword" class="form-label">New Password (Optional)</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="updateUserPassword" name="userPassword" placeholder="Enter new password">
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="updateUserPassword">
                                👁
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="updateUserConfirmPassword" class="form-label">Retype Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="updateUserConfirmPassword" name="confirmPassword" placeholder="Retype password">
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="updateUserConfirmPassword">
                                👁
                            </button>
                        </div>
                        <small id="passwordMatchMessage" class="text-danger"></small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    // ===========================
    //  ADD USER FUNCTIONALITIES
    // ===========================

    const form = document.getElementById("addUserForm");
    const passwordField = document.getElementById("userPassword");
    const confirmPasswordField = document.getElementById("confirmPassword");
    const passwordMatchMessage = document.getElementById("passwordMatchMessage");

    // Function to validate password match
    function validatePasswordMatch() {
        if (!passwordField.value || !confirmPasswordField.value) {
            passwordMatchMessage.textContent = "";
            confirmPasswordField.classList.remove("is-valid", "is-invalid");
            return;
        }

        const isMatch = passwordField.value === confirmPasswordField.value;
        confirmPasswordField.classList.toggle("is-valid", isMatch);
        confirmPasswordField.classList.toggle("is-invalid", !isMatch);
        passwordMatchMessage.textContent = isMatch ? "Passwords match!" : "Passwords do not match!";
        passwordMatchMessage.classList.toggle("text-success", isMatch);
        passwordMatchMessage.classList.toggle("text-danger", !isMatch);
    }

    // Function to toggle password visibility
    function togglePasswordVisibility(event) {
        const targetInput = document.getElementById(event.target.dataset.target);
        targetInput.type = targetInput.type === "password" ? "text" : "password";
        event.target.innerHTML = targetInput.type === "password" ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
    }

    // Function to add green glow effect on input fields
    function handleInputValidation(event) {
        event.target.classList.toggle("is-valid", event.target.value.trim() !== "");
    }

    // Function to handle form submission
    async function handleAddUserSubmit(event) {
        event.preventDefault();

        const formData = new FormData(form);
        try {
            const response = await fetch("../api/user_management/add_user.php", {
                method: "POST",
                body: formData
            });
            const data = await response.json();

            if (data.success) {
                alert("User added successfully!");
                form.reset();
                document.querySelectorAll(".input-validate").forEach(input => input.classList.remove("is-valid", "is-invalid"));
                passwordMatchMessage.textContent = "";
                
                const modal = bootstrap.Modal.getInstance(document.getElementById("addUserModal"));
                modal.hide();
                window.location.reload();
            } else {
                alert("Something went wrong! Please try again.");
            }
        } catch (error) {
            console.error("Error:", error);
            alert("Something went wrong! Please try again.");
        }
    }

    // Event Listeners
    passwordField.addEventListener("input", validatePasswordMatch);
    confirmPasswordField.addEventListener("input", validatePasswordMatch);
    document.querySelectorAll(".toggle-password").forEach(button => button.addEventListener("click", togglePasswordVisibility));
    document.querySelectorAll(".input-validate").forEach(input => input.addEventListener("input", handleInputValidation));
    form.addEventListener("submit", handleAddUserSubmit);

    // ===========================
    //  DISPLAY & FILTER USERS
    // ===========================

    let usersData = [];

    function displayUsers(users) {
        const tableBody = document.getElementById("userTableBody");
        tableBody.innerHTML = "";

        users.forEach(user => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${user.user_id}</td>
                <td>${user.user_name}</td>
                <td>${user.email}</td>
                <td>${user.role}</td>
                <td>
                    <button class="btn btn-primary btn-sm update-btn" data-id="${user.user_id}">
                        Update
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    async function fetchUsers() {
        try {
            const response = await fetch("../api/user_management/get_user.php");
            usersData = await response.json();
            displayUsers(usersData);
        } catch (error) {
            console.error("Error fetching users:", error);
        }
    }

    function applyFilters() {
        const nameFilter = document.getElementById("filterName").value.toLowerCase();
        const roleFilter = document.getElementById("filterRole").value.toLowerCase();

        const filteredUsers = usersData.filter(user =>
            (user.user_name.toLowerCase().includes(nameFilter) || nameFilter === "") &&
            (user.role.toLowerCase() === roleFilter || roleFilter === "")
        );

        displayUsers(filteredUsers);
    }

    document.getElementById("userFilterForm").addEventListener("submit", function (event) {
        event.preventDefault();
        applyFilters();
    });

    document.getElementById("filterName").addEventListener("input", applyFilters);
    document.getElementById("filterRole").addEventListener("change", applyFilters);

    // Fetch users on load
    fetchUsers();

    // ===========================
    //  UPDATE USER FUNCTIONALITIES
    // ===========================

    document.getElementById("userTableBody").addEventListener("click", function (event) {
        if (event.target.classList.contains("update-btn")) {
            const userId = event.target.dataset.id;
            const user = usersData.find(user => user.user_id === userId);

            if (user) {
                document.getElementById("updateUserId").value = user.user_id;
                document.getElementById("updateUserName").value = user.user_name;
                document.getElementById("updateUserEmail").value = user.email;
                document.getElementById("updateUserRole").value = user.role;

                const updateModal = new bootstrap.Modal(document.getElementById("updateUserModal"));
                updateModal.show();
            }
        }
    });

    const updateForm = document.getElementById("updateUserForm");
    const updatePasswordField = document.getElementById("updateUserPassword");
    const updateConfirmPasswordField = document.getElementById("updateUserConfirmPassword");
    const updatePasswordMatchMessage = document.getElementById("updatePasswordMatchMessage");

    function validateUpdatePasswordMatch() {
        if (!updateConfirmPasswordField.value || !updatePasswordField.value) {
            updatePasswordMatchMessage.textContent = "";
            updateConfirmPasswordField.classList.remove("is-valid", "is-invalid");
            return;
        }

        const isMatch = updatePasswordField.value === updateConfirmPasswordField.value;
        updateConfirmPasswordField.classList.toggle("is-valid", isMatch);
        updateConfirmPasswordField.classList.toggle("is-invalid", !isMatch);
        updatePasswordMatchMessage.textContent = isMatch ? "Passwords match!" : "Passwords do not match!";
        updatePasswordMatchMessage.classList.toggle("text-success", isMatch);
        updatePasswordMatchMessage.classList.toggle("text-danger", !isMatch);
    }

    async function handleUpdateUserSubmit(event) {
        event.preventDefault();

        if (updatePasswordField.value && updatePasswordField.value !== updateConfirmPasswordField.value) {
            alert("Passwords do not match!");
            return;
        }

        const formData = {
            userId: document.getElementById("updateUserId").value,
            userName: document.getElementById("updateUserName").value,
            userEmail: document.getElementById("updateUserEmail").value,
            userRole: document.getElementById("updateUserRole").value,
            userPassword: updatePasswordField.value || null
        };

        try {
            const response = await fetch("../api/user_management/update_user.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(formData)
            });

            const result = await response.json();
            if (result.success) {
                alert("User updated successfully!");
                fetchUsers();
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById("updateUserModal"));
                modalInstance.hide();
                updateForm.reset();
            } else {
                alert("Failed to update user: " + result.message);
            }
        } catch (error) {
            console.error("Error updating user:", error);
        }
    }

    updatePasswordField.addEventListener("input", validateUpdatePasswordMatch);
    updateConfirmPasswordField.addEventListener("input", validateUpdatePasswordMatch);
    updateForm.addEventListener("submit", handleUpdateUserSubmit);
});
</script>
</body>

</html>