<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$sql = "
SELECT b.*, c.full_name AS client_name, s.service_name
FROM bookings b
JOIN clients c ON b.client_id = c.client_id
JOIN services s ON b.service_id = s.service_id
ORDER BY b.booking_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings - Booking Management System</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-paid {
            background: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <?php include "../nav.php"; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>Booking Management</h1>
            <p>View and manage all bookings</p>
        </div>

        <div style="margin-bottom: 20px;">
            <a href="bookings_create.php" class="btn">➕ Create New Booking</a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Hours</th>
                        <th>Total Cost</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($b = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><strong>#<?php echo $b['booking_id']; ?></strong></td>
                            <td><?php echo htmlspecialchars($b['client_name']); ?></td>
                            <td><?php echo htmlspecialchars($b['service_name']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($b['booking_date'])); ?></td>
                            <td><?php echo $b['hours']; ?>h</td>
                            <td><strong>₱<?php echo number_format($b['total_cost'], 2); ?></strong></td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower($b['status']); ?>">
                                    <?php echo $b['status']; ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($b['status'] == 'PENDING'): ?>
                                    <a href="payment_process.php?booking_id=<?php echo $b['booking_id']; ?>">
                                        💳 Process Payment
                                    </a>
                                <?php else: ?>
                                    <span style="color: #28a745;">✓ Completed</span>
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