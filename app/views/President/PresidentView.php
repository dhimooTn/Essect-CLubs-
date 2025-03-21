<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>President Panel</title>
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
            <li id="requestsBtn"><i class="fas fa-envelope"></i> <span>Requests</span></li>
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
            <p>Welcome to the president panel! Here's a quick overview of your club's data:</p>

            <div class="dashboard-container">
                <div class="stats">
                    <div class="card"><i class="fas fa-users"></i> Total Members : <?= $totalMembers ?></div>
                    <div class="card"><i class="fas fa-envelope"></i> Pending Requests : <?= $pendingRequests ?></div>
                    <div class="card"><i class="fas fa-chart-line"></i> Club Activity : High</div>
                </div>
            </div>
        </div>

        <!-- Users Content -->
        <div id="usersContent" class="content-section">
            <h2><i class="fas fa-users"></i> Manage Club Members</h2>
            <button id="addUserBtn" class="btn btn-success"><i class="fas fa-plus"></i> Add Member</button>
            <div id="addUserForm" style="display: none;">
                <form method="POST" action="<?= BURL ?>President/addUser">
                    <input type="text" name="first_name" placeholder="First Name" required>
                    <input type="text" name="last_name" placeholder="Last Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
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


                    <?php if (!empty($clubMembers)): ?>
                        <?php foreach ($clubMembers as $member): ?>
                            <tr>
                                <td><?= $member['id'] ?></td>
                                <td><?= $member['first_name'] ?></td>
                                <td><?= $member['last_name'] ?></td>
                                <td><?= $member['email'] ?></td>
                                <td><?= $member['role'] ?></td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-warning edit-btn"
                                        data-id="<?= $member['id'] ?>"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="<?= BURL ?>President/deleteUser/<?= $member['id'] ?>"
                                        class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                            <!-- Update Form for each member (initially hidden) -->
                            <div id="updateUserForm_<?= $member['id'] ?>" class="update-form" style="display: none;">
                                <form method="POST" action="<?= BURL ?>President/updateUser/<?= $member['id'] ?>">
                                    <input type="text" name="first_name" value="<?= $member['first_name'] ?>" required>
                                    <input type="text" name="last_name" value="<?= $member['last_name'] ?>" required>
                                    <input type="email" name="email" value="<?= $member['email'] ?>" required>
                                    <input type="password" name="password" placeholder="New Password">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No members found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>


        <!-- Requests Content -->
        <div id="requestsContent" class="content-section">
            <h2><i class="fas fa-envelope"></i> Manage Membership Requests</h2>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Facebook URL</th>
                        <th>Niveau</th>
                        <th>Spécialité</th>
                        <th>Club Experience</th>
                        <th>Previous Club</th>
                        <th>Department</th>
                        <th>Motivation</th>
                        <th>Interview Availability</th>
                        <th>CV</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($request)): ?>
                        <?php foreach ($request as $requests): ?>
                            <tr>
                                <td><?= htmlspecialchars($requests['id']) ?></td>
                                <td><?= htmlspecialchars($requests['first_name']) . " " . htmlspecialchars($requests['last_name']) ?>
                                </td>
                                <td><?= htmlspecialchars($requests['email']) ?></td>
                                <td><?= htmlspecialchars($requests['phone']) ?></td>
                                <td><a href="<?= htmlspecialchars($requests['facebook_url']) ?>" target="_blank">Profile</a>
                                </td>
                                <td><?= htmlspecialchars($requests['niveau']) ?></td>
                                <td><?= htmlspecialchars($requests['specialite']) ?></td>
                                <td><?= htmlspecialchars($requests['club_experience']) ?></td>
                                <td><?= htmlspecialchars($requests['previous_club']) ?></td>
                                <td><?= htmlspecialchars($requests['department']) ?></td>
                                <td><?= htmlspecialchars($requests['motivation']) ?></td>
                                <td><?= htmlspecialchars($requests['interview_availability']) ?></td>
                                <td><a href="<?= htmlspecialchars($requests['cv_path']) ?>" target="_blank">View CV</a></td>
                                <td>
                                    <a href="<?= BURL ?>President/acceptRequest/<?= $requests['id'] ?>"
                                        class="btn btn-sm btn-success"><i class="fas fa-check"></i> Accept</a>
                                    <a href="<?= BURL ?>President/rejectRequest/<?= $requests['id'] ?>"
                                        class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Reject</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="14" class="text-center">No requests found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>



        <!-- BI Dashboard Content -->
        <div id="biDashboardContent" class="content-section">
            <h2><i class="fas fa-chart-line"></i> BI Dashboard</h2>
            <div class="dashboard-container">
                <h3>Club Statistics</h3>
                <div class="stats">
                    <div class="card"><i class="fas fa-users"></i> Total Members :
                        <?= $totalMembers ?>
                    </div>
                    <div class="card"><i class="fas fa-envelope"></i> Pending Requests :
                        <?= $pendingRequests ?>
                    </div>
                </div>

                <!-- Chart Row -->
                <div class="chart-row">
                    <div class="chart-container">
                        <h4>Members by Department</h4>
                        <canvas id="membersByDepartmentChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <h4>Members by Niveau</h4>
                        <canvas id="membersByNiveauChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <h4>Members by Role</h4>
                        <canvas id="membersByDepartmentChart"></canvas>
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
            document.querySelector("#requestsBtn").addEventListener("click", function () {
                showSection("#requestsContent");
            });
            document.querySelector("#biDashboardBtn").addEventListener("click", function () {
                showSection("#biDashboardContent");
            });

            // Toggle forms
            document.querySelector("#addUserBtn").addEventListener("click", function () {
                let form = document.querySelector("#addUserForm");
                form.style.display = (form.style.display === "none") ? "block" : "none";
            });

            // Edit member forms
            document.querySelectorAll(".edit-btn").forEach(button => {
                button.addEventListener("click", function () {
                    const userId = this.getAttribute("data-id");
                    const updateForm = document.querySelector(`#updateUserForm_${userId}`);
                    updateForm.style.display = (updateForm.style.display === "none") ? "block" : "none";
                });
            });

            // Chart.js for BI Dashboard
            const departmentCtx = document.getElementById('membersByDepartmentChart').getContext('2d');
            new Chart(departmentCtx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode(array_column($membersByDepartment, 'department')) ?>,
                    datasets: [{
                        label: 'Number of Members',
                        data: <?= json_encode(array_column($membersByDepartment, 'count')) ?>,
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

            const niveauCtx = document.getElementById('membersByNiveauChart').getContext('2d');
            new Chart(niveauCtx, {
                type: 'pie',
                data: {
                    labels: <?= json_encode(array_column($membersByNiveau, 'niveau')) ?>,
                    datasets: [{
                        label: 'Number of Members',
                        data: <?= json_encode(array_column($membersByNiveau, 'count')) ?>,
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

            const roleCtx = document.getElementById('membersByDepartmentChart').getContext('2d');
            new Chart(roleCtx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode(array_column($membersByDepartment, 'role')) ?>,
                    datasets: [{
                        label: 'Number of Members',
                        data: <?= json_encode(array_column($membersByDepartment, 'count')) ?>,
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