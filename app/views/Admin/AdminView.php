<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="/assets/admin.css">
</head>

<body>

    <!-- Sidebar -->
    <div id="sidebar">
        <button id="sidebarCollapse" class="btn btn-light"><i class="fas fa-bars"></i></button>
        <ul>
            <li id="homeBtn"><i class="fas fa-home"></i> <span>Home</span></li>
            <li id="usersBtn"><i class="fas fa-users"></i> <span>Users</span></li>
            <li id="clubsBtn"><i class="fas fa-trophy"></i> <span>Clubs</span></li>
            <li id="biDashboardBtn"><i class="fas fa-chart-line"></i> <span>BI Dashboard</span></li>
            <li><a href="<?php echo BURL; ?>Session/logout" class="btn btn-danger btn-sm"><i
                        class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Home Content -->
        <div id="homeContent" class="content-section active">
            <h2><i class="fas fa-home"></i> Dashboard</h2>
            <p>Welcome to the admin panel! Here's a quick overview of your data:</p>

            <div class="dashboard-container">
                <div class="stats">
                    <div class="card"><i class="fas fa-users"></i> Total Users : <?= $totalUsers ?></div>
                    <div class="card"><i class="fas fa-user-friends"></i> Members : <?= $usersByRole[0]['count'] ?? 0 ?></div>
                    <div class="card"><i class="fas fa-user-tie"></i> Presidents : <?= $usersByRole[1]['count'] ?? 0 ?></div>
                    <div class="card"><i class="fas fa-user-shield"></i> Admins : <?= $usersByRole[2]['count'] ?? 0 ?></div>
                </div>
            </div>
        </div>

        <!-- Users Content -->
        <div id="usersContent" class="content-section">
            <h2><i class="fas fa-users"></i> Manage Users</h2>
            <button id="addUserBtn" class="btn btn-success"><i class="fas fa-plus"></i> Add User</button>
            <div id="addUserForm" style="display: none;">
                <form method="POST" action="<?= BURL ?>Admin/addUser">
                    <input type="text" name="first_name" placeholder="First Name" required>
                    <input type="text" name="last_name" placeholder="Last Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>

                    <!-- Dropdown for Club -->
                    <select name="club" required>
                        <option value="" disabled selected>Select Club</option>
                        <option value="1">Infolab</option>
                        <option value="2">Enactus</option>
                        <option value="3">ClubRadio</option>
                    </select>

                    <!-- Dropdown for Role -->
                    <select name="role" required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="membre">Membre</option>
                        <option value="president">Président</option>
                    </select>

                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                </form>
            </div>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['first_name'] ?></td>
                            <td><?= $user['last_name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['role'] ?></td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-sm btn-warning edit-btn"
                                    data-id="<?= $user['id'] ?>"><i class="fas fa-edit"></i> Edit</a>
                                <a href="<?= BURL ?>Admin/deleteUser/<?= $user['id'] ?>" class="btn btn-sm btn-danger"><i
                                        class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                        <!-- Update Form for each user (initially hidden) -->
                        <div id="updateUserForm_<?= $user['id'] ?>" class="update-form" style="display: none;">
                            <form method="POST" action="<?= BURL ?>Admin/updateUser/<?= $user['id'] ?>">
                                <input type="text" name="first_name" value="<?= $user['first_name'] ?>" required>
                                <input type="text" name="last_name" value="<?= $user['last_name'] ?>" required>
                                <input type="email" name="email" value="<?= $user['email'] ?>" required>
                                <input type="password" name="password" placeholder="New Password">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Clubs Content -->
        <div id="clubsContent" class="content-section">
            <h2><i class="fas fa-trophy"></i> Manage Clubs</h2>
            <button id="addClubBtn" class="btn btn-success"><i class="fas fa-plus"></i> Add Club</button>
            <div id="addClubForm" style="display: none;">
                <form method="POST" action="<?= BURL ?>Admin/addClub">
                    <input type="text" name="club_name" placeholder="Club Name" required>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                </form>
            </div>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Club Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clubs as $club): ?>
                        <tr>
                            <td><?= $club['id'] ?></td>
                            <td><?= $club['name'] ?></td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-sm btn-warning edit-club-btn"
                                    data-id="<?= $club['id'] ?>"><i class="fas fa-edit"></i> Edit</a>
                                <a href="<?= BURL ?>Admin/deleteClub/<?= $club['id'] ?>" class="btn btn-sm btn-danger"><i
                                        class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                        <!-- Update Form for each club (initially hidden) -->
                        <div id="updateClubForm_<?= $club['id'] ?>" class="update-form" style="display: none;">
                            <form method="POST" action="<?= BURL ?>Admin/updateClub/<?= $club['id'] ?>">
                                <input type="text" name="club_name" value="<?= $club['name'] ?>" required>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- BI Dashboard Content -->
        <div id="biDashboardContent" class="content-section">
            <h2><i class="fas fa-chart-line"></i> BI Dashboard</h2>
            <div class="dashboard-container">
                <h3>Statistiques</h3>
                <div class="stats">
                    <div class="card"><i class="fas fa-users"></i> Total Utilisateurs : <?= $totalUsers ?></div>
                    <div class="card"><i class="fas fa-user-friends"></i> Membres : <?= $usersByRole[0]['count'] ?? 0 ?></div>
                    <div class="card"><i class="fas fa-user-tie"></i> Présidents : <?= $usersByRole[1]['count'] ?? 0 ?></div>
                    <div class="card"><i class="fas fa-user-shield"></i> Admins : <?= $usersByRole[2]['count'] ?? 0 ?></div>
                </div>

                <!-- Chart Row -->
                <div class="chart-row">
                    <div class="chart-container">
                        <h4>Users by Role</h4>
                        <canvas id="userRoleChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <h4>Users by Niveau</h4>
                        <canvas id="userNiveauChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <h4>Users by Department</h4>
                        <canvas id="userDepartmentChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <h4>Users by club</h4>
                        <canvas id="userClubChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Sidebar toggle
            document.querySelector("#sidebarCollapse").addEventListener("click", function () {
                document.querySelector("#sidebar").classList.toggle("active");
            });

            // Function to show a specific section and hide others
            function showSection(sectionId) {
                // Hide all sections
                document.querySelectorAll(".content-section").forEach(section => {
                    section.classList.remove("active");
                    section.style.display = "none";
                });

                // Show the selected section
                const activeSection = document.querySelector(sectionId);
                if (activeSection) {
                    activeSection.style.display = "block";
                    setTimeout(() => activeSection.classList.add("active"), 10);
                }
            }

            // Set the default active section to Home
            showSection("#homeContent");

            // Navigation buttons
            document.querySelector("#homeBtn").addEventListener("click", function () {
                showSection("#homeContent");
            });
            document.querySelector("#usersBtn").addEventListener("click", function () {
                showSection("#usersContent");
            });
            document.querySelector("#clubsBtn").addEventListener("click", function () {
                showSection("#clubsContent");
            });
            document.querySelector("#biDashboardBtn").addEventListener("click", function () {
                showSection("#biDashboardContent");
            });

            // Toggle forms
            document.querySelector("#addUserBtn").addEventListener("click", function () {
                let form = document.querySelector("#addUserForm");
                form.style.display = (form.style.display === "none") ? "block" : "none";
            });

            document.querySelector("#addClubBtn").addEventListener("click", function () {
                let form = document.querySelector("#addClubForm");
                form.style.display = (form.style.display === "none") ? "block" : "none";
            });

            // Edit user and club forms
            document.querySelectorAll(".edit-btn").forEach(button => {
                button.addEventListener("click", function () {
                    const userId = this.getAttribute("data-id");
                    const updateForm = document.querySelector(`#updateUserForm_${userId}`);
                    updateForm.style.display = (updateForm.style.display === "none") ? "block" : "none";
                });
            });

            document.querySelectorAll(".edit-club-btn").forEach(button => {
                button.addEventListener("click", function () {
                    const clubId = this.getAttribute("data-id");
                    const updateForm = document.querySelector(`#updateClubForm_${clubId}`);
                    updateForm.style.display = (updateForm.style.display === "none") ? "block" : "none";
                });
            });

            // Chart.js for BI Dashboard
            const roleCtx = document.getElementById('userRoleChart').getContext('2d');
            new Chart(roleCtx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode(array_column($usersByRole, 'role')) ?>,
                    datasets: [{
                        label: 'Number of Users',
                        data: <?= json_encode(array_column($usersByRole, 'count')) ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            const niveauCtx = document.getElementById('userNiveauChart').getContext('2d');
            new Chart(niveauCtx, {
                type: 'pie',
                data: {
                    labels: <?= json_encode(array_column($usersByNiveau, 'niveau')) ?>,
                    datasets: [{
                        label: 'Number of Users by Niveau',
                        data: <?= json_encode(array_column($usersByNiveau, 'count')) ?>,
                        backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A6'],
                    }]
                },
                options: {
                    responsive: true
                }
            });

            const departmentCtx = document.getElementById('userDepartmentChart').getContext('2d');
            new Chart(departmentCtx, {
                type: 'pie',
                data: {
                    labels: <?= json_encode(array_column($usersByDepartment, 'department_name')) ?>,
                    datasets: [{
                        label: 'Users by Department',
                        data: <?= json_encode(array_column($usersByDepartment, 'count')) ?>,
                        backgroundColor: ['#FFEB3B', '#FF9800', '#2196F3', '#4CAF50'],
                    }]
                },
                options: {
                    responsive: true
                }
            });

            const clubCtx = document.getElementById('userClubChart').getContext('2d');
            new Chart(clubCtx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode(array_column($usersByClub, 'club_name')) ?>,
                    datasets: [{
                        label: 'Users by Club',
                        data: <?= json_encode(array_column($usersByClub, 'count')) ?>,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>

</body>

</html>