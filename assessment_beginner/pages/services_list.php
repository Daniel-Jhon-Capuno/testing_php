<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

/* SOFT DELETE (Deactivate) */
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    mysqli_query($conn, "UPDATE services SET is_active=0 WHERE service_id=$delete_id");
    header("Location: services_list.php");
    exit;
}

/* FETCH ALL SERVICES */
$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Booking Management System</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include "../nav.php"; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>Service Management</h1>
            <p>Manage all your services and rates</p>
        </div>

        <div style="margin-bottom: 20px;">
            <a href="services_add.php" class="btn">➕ Add New Service</a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service Name</th>
                        <th>Description</th>
                        <th>Hourly Rate</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['service_id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($row['service_name']); ?></strong></td>
                            <td><?php echo htmlspecialchars(substr($row['description'], 0, 50)); ?><?php echo strlen($row['description']) > 50 ? '...' : ''; ?></td>
                            <td><strong>₱<?php echo number_format($row['hourly_rate'], 2); ?></strong></td>
                            <td>
                                <?php if ($row['is_active'] == 1): ?>
                                    <span style="color: #28a745; font-weight: 600;">✓ Active</span>
                                <?php else: ?>
                                    <span style="color: #dc3545; font-weight: 600;">✗ Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="services_edit.php?id=<?php echo $row['service_id']; ?>">✏️ Edit</a>
                                <?php if ($row['is_active'] == 1): ?>
                                    |
                                    <a href="services_list.php?delete_id=<?php echo $row['service_id']; ?>"
                                       onclick="return confirm('Deactivate this service?')"
                                       style="color: #dc3545;">
                                        🚫 Deactivate
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>