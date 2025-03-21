<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/assets/admin.css">
</head>

<body>

    <!-- Sidebar -->
    <div id="sidebar">
        <button id="sidebarCollapse" class="btn btn-light"><i class="fas fa-bars"></i></button>
        <ul>
            <li id="homeBtn"><i class="fas fa-home"></i> <span>Home</span></li>
            <li id="eventsBtn"><i class="fas fa-calendar-alt"></i> <span>Events</span></li>
            <li><a href="<?php echo BURL; ?>Session/logout" class="btn btn-danger btn-sm"><i
                        class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Home Content -->
        <div id="homeContent" class="content-section active">
            <h2><i class="fas fa-home"></i> Welcome to the Member Space</h2>
            <p>Hello, <?= $_SESSION['username'] ?>! Welcome to your member dashboard. Here, you can stay updated with the latest events and activities in your club.</p>

            <!-- Simple Dashboard -->
            <div class="dashboard-container mt-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center p-3">
                            <h4><i class="fas fa-calendar-alt"></i> Upcoming Events</h4>
                            <p>Check out the latest events happening in your club.</p>
                            <!-- Fix the button to use an anchor tag instead of a link to view events -->
                            <a href="#eventsContent" class="btn btn-primary" id="viewEventsBtn">View Events</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center p-3">
                            <h4><i class="fas fa-bullhorn"></i> Announcements</h4>
                            <p>Stay informed about important club announcements.</p>
                            <button class="btn btn-secondary" disabled>Coming Soon</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center p-3">
                            <h4><i class="fas fa-users"></i> Club Members</h4>
                            <p>Connect with all members of your club.</p>
                            <button class="btn btn-secondary" disabled>Coming Soon</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Events Content -->
        <div id="eventsContent" class="content-section">
            <h2><i class="fas fa-calendar-alt"></i> Events Calendar</h2>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($events)): ?>
                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td><?= $event['id'] ?></td>
                                <td><?= $event['title'] ?></td>
                                <td><?= $event['description'] ?></td>
                                <td><?= $event['date'] ?></td>
                                <td><?= $event['location'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No events found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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
            document.querySelector("#eventsBtn").addEventListener("click", function () {
                showSection("#eventsContent");
            });

            // Scroll smoothly to events section
            const viewEventsBtn = document.getElementById("viewEventsBtn");
            if (viewEventsBtn) {
                viewEventsBtn.addEventListener("click", function (event) {
                    event.preventDefault(); // Prevents the default behavior of the link
                    const target = document.getElementById("eventsContent");

                    // Check if the target section exists
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' }); // Scroll to the section smoothly
                    }
                });
            }
        });
    </script>

</body>

</html>
