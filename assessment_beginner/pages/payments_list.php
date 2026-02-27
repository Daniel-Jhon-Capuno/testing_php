<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$sql = "
SELECT p.*, b.booking_date, c.full_name, s.service_name
FROM payments p
JOIN bookings b ON p.booking_id = b.booking_id
JOIN clients c ON b.client_id = c.client_id
JOIN services s ON b.service_id = s.service_id
ORDER BY p.payment_id DESC
";
$result = mysqli_query($conn, $sql);

// Calculate total revenue
$totalRevenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS total FROM payments"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments - Booking Management System</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include "../nav.php"; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>Payment Records</h1>
            <p>View all payment transactions</p>
        </div>

        <div class="card" style="margin-bottom: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <h2 style="color: white; margin-bottom: 10px;">Total Revenue</h2>
            <h1 style="color: white; font-size: 48px; margin: 0;">₱<?php echo number_format($totalRevenue, 2); ?></h1>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Booking ID</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($p = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><strong>#<?php echo $p['payment_id']; ?></strong></td>
                            <td><?php echo htmlspecialchars($p['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($p['service_name']); ?></td>
                            <td><a href="payment_process.php?booking_id=<?php echo $p['booking_id']; ?>">#<?php echo $p['booking_id']; ?></a></td>
                            <td><strong style="color: #28a745;">₱<?php echo number_format($p['amount_paid'], 2); ?></strong></td>
                            <td>
                                <span style="padding: 5px 10px; background: #e7f3ff; color: #0066cc; border-radius: 5px; font-size: 12px; font-weight: 600;">
                                    <?php echo $p['method']; ?>
                                </span>
                            </td>
                            <td><?php echo date('M d, Y h:i A', strtotime($p['payment_date'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>