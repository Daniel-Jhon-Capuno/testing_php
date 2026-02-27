<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?php echo (strpos($_SERVER['PHP_SELF'], '/pages/') !== false) ? '../style.css' : 'style.css'; ?>">
</head>
<body>
    <nav class="navbar">
        <div class="nav-brand">
            <span class="nav-logo">🛠️</span>
            <span class="nav-title">Booking System</span>
        </div>
        
        <div class="nav-links">
            <?php
            $base = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false) ? '../' : '';
            $pages_dir = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false) ? '' : 'pages/';
            ?>
            <a href="<?php echo $base; ?>index.php" class="nav-link">
                <span class="nav-icon">📊</span> Dashboard
            </a>
            <a href="<?php echo $base . $pages_dir; ?>clients_list.php" class="nav-link">
                <span class="nav-icon">👥</span> Clients
            </a>
            <a href="<?php echo $base . $pages_dir; ?>services_list.php" class="nav-link">
                <span class="nav-icon">🛠️</span> Services
            </a>
            <a href="<?php echo $base . $pages_dir; ?>bookings_list.php" class="nav-link">
                <span class="nav-icon">📅</span> Bookings
            </a>
            <a href="<?php echo $base . $pages_dir; ?>payments_list.php" class="nav-link">
                <span class="nav-icon">💳</span> Payments
            </a>
            <a href="<?php echo $base . $pages_dir; ?>tools_list_assign.php" class="nav-link">
                <span class="nav-icon">🔨</span> Tools
            </a>
        </div>
        
        <div class="nav-user">
            <span class="user-name"><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?></span>
            <a href="<?php echo $base; ?>logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>
</body>
</html>