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
    <style>
        body {
            display: flex;
            background-color: #1e1e2f;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
        }

        #sidebar {
            width: 250px;
            min-height: 100vh;
            background: #2a2a3f;
            color: white;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
            transition: 0.3s;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        #sidebar.active {
            width: 70px;
        }

        #sidebar ul {
            padding: 0;
            list-style: none;
        }

        #sidebar ul li {
            padding: 15px;
            cursor: pointer;
            transition: background 0.3s;
            display: flex;
            align-items: center;
        }

        #sidebar ul li:hover {
            background: #3a3a4f;
        }

        #sidebar ul li i {
            font-size: 20px;
            margin-right: 10px;
        }

        #sidebar ul li span {
            font-size: 16px;
        }

        #sidebar.active ul li {
            text-align: center;
            padding: 15px 0;
        }

        #sidebar.active ul li i {
            font-size: 20px;
            margin-right: 0;
        }

        #sidebar.active ul li span {
            display: none;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
            width: 100%;
            background-color: #1e1e2f;
        }

        .content-section {
            display: none;
            background-color: #2a2a3f;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: opacity 0.3s ease-in-out;
            opacity: 0;
            height: 0;
            overflow: hidden;
        }

        .content-section.active {
            opacity: 1;
            height: auto;
        }

        #homeContent {
            display: block;
        }

        .btn {
            margin: 5px;
            transition: background 0.3s;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .table {
            background-color: #2a2a3f;
            color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table th,
        .table td {
            border-color: #3a3a4f;
        }

        .table thead th {
            background-color: #3a3a4f;
            border-color: #3a3a4f;
        }

        .table tbody tr {
            background-color: #2a2a3f;
            transition: background 0.3s;
        }

        .table tbody tr:hover {
            background-color: #3a3a4f;
        }

        .table tbody tr td {
            padding: 15px;
            border-top: 1px solid #3a3a4f;
            border-bottom: 1px solid #3a3a4f;
        }

        .table tbody tr td:first-child {
            border-left: 1px solid #3a3a4f;
            border-radius: 10px 0 0 10px;
        }

        .table tbody tr td:last-child {
            border-right: 1px solid #3a3a4f;
            border-radius: 0 10px 10px 0;
        }

        .card {
            background-color: #3a3a4f;
            padding: 15px;
            border-radius: 10px;
            margin: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #ffffff;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card i {
            margin-right: 10px;
            font-size: 1.2em;
        }

        .dashboard-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .stats .card {
            flex: 1 1 calc(25% - 20px);
            text-align: center;
        }

        .chart-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .chart-container {
            flex: 1 1 calc(33.33% - 20px);
            background-color: #2a2a3f;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .chart-container h4 {
            margin-bottom: 15px;
            color: #ffffff;
        }

        canvas {
            background-color: #2a2a3f;
            border-radius: 10px;
            padding: 10px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #3a3a4f;
            border-radius: 5px;
            background-color: #2a2a3f;
            color: #ffffff;
            font-size: 14px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #4a90e2;
            outline: none;
        }

        form button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4a90e2;
            color: #ffffff;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        form button:hover {
            background-color: #357abd;
        }

        .update-form {
            background-color: #2a2a3f;
            padding: 20px;
            border-radius: 10px;
            margin-top: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .update-form input,
        .update-form select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #3a3a4f;
            border-radius: 5px;
            background-color: #2a2a3f;
            color: #ffffff;
        }

        .update-form button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4a90e2;
            color: #ffffff;
            cursor: pointer;
        }

        .update-form button:hover {
            background-color: #357abd;
        }

        @media (max-width: 768px) {
            #sidebar {
                width: 70px;
            }

            #sidebar.active {
                width: 250px;
            }

            .content {
                margin-left: 80px;
            }

            .stats .card {
                flex: 1 1 calc(50% - 20px);
            }

            .chart-container {
                flex: 1 1 100%;
            }
        }
    </style>
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
                                <a href="<?= BURL ?>/Admin/deleteUser/<?= $user['id'] ?>" class="btn btn-sm btn-danger"><i
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
                        label: 'Number of Users',
                        data: <?= json_encode(array_column($usersByNiveau, 'count')) ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });

            const departmentCtx = document.getElementById('userDepartmentChart').getContext('2d');
            new Chart(departmentCtx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode(array_column($usersByDepartment, 'department')) ?>,
                    datasets: [{
                        label: 'Number of Users',
                        data: <?= json_encode(array_column($usersByDepartment, 'count')) ?>,
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