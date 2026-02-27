<?php
session_start();

// If not logged in, redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$clients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM clients"))['c'];
$services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM services"))['c'];
$bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM bookings"))['c'];
$revRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS s FROM payments"));
$revenue = $revRow['s'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Booking Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "nav.php"; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>Dashboard</h1>
            <p class="welcome-text">Welcome back, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>! 👋</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card clients">
                <div class="stat-icon">👥</div>
                <div class="stat-content">
                    <h3><?php echo $clients; ?></h3>
                    <p>Total Clients</p>
                </div>
            </div>

            <div class="stat-card services">
                <div class="stat-icon">🛠️</div>
                <div class="stat-content">
                    <h3><?php echo $services; ?></h3>
                    <p>Total Services</p>
                </div>
            </div>

            <div class="stat-card bookings">
                <div class="stat-icon">📅</div>
                <div class="stat-content">
                    <h3><?php echo $bookings; ?></h3>
                    <p>Total Bookings</p>
                </div>
            </div>

            <div class="stat-card revenue">
                <div class="stat-icon">💰</div>
                <div class="stat-content">
                    <h3>₱<?php echo number_format($revenue, 2); ?></h3>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>

        <div class="quick-actions">
            <h2>Quick Actions</h2>
            <div class="action-buttons">
                <a href="pages/clients_add.php" class="action-btn">
                    <span class="action-icon">➕</span>
                    Add Client
                </a>
                <a href="pages/bookings_create.php" class="action-btn">
                    <span class="action-icon">📝</span>
                    Create Booking
                </a>
                <a href="pages/services_add.php" class="action-btn">
                    <span class="action-icon">🔧</span>
                    Add Service
                </a>
                <a href="pages/tools_list_assign.php" class="action-btn">
                    <span class="action-icon">🔨</span>
                    Manage Tools
                </a>
            </div>
        </div>
    </div>
</body>
</html>