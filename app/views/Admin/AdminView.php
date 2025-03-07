<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>You are now logged in.</p>
    <a href="../app/controllers/SessionController.php?logout=true">Logout</a>
</body>
</html>