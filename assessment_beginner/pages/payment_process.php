<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$booking_id = intval($_GET['booking_id']);

$booking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id=$booking_id"));

if (!$booking) {
    header("Location: bookings_list.php");
    exit();
}

$paidRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
$total_paid = $paidRow['paid'];

$balance = $booking['total_cost'] - $total_paid;
$message = "";
$message_type = "";

if (isset($_POST['pay'])) {
    $amount = floatval($_POST['amount_paid']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);

    if ($amount <= 0) {
        $message = "Invalid amount!";
        $message_type = "error";
    } elseif ($amount > $balance) {
        $message = "Amount exceeds balance! Maximum: ₱" . number_format($balance, 2);
        $message_type = "error";
    } else {
        // Insert payment
        mysqli_query($conn, "INSERT INTO payments (booking_id, amount_paid, method)
          VALUES ($booking_id, $amount, '$method')");

        // Recompute total paid
        $paidRow2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
        $total_paid2 = $paidRow2['paid'];

        // Recompute new balance
        $new_balance = $booking['total_cost'] - $total_paid2;

        // If fully paid, update booking status to PAID
        if ($new_balance <= 0.009) {
            mysqli_query($conn, "UPDATE bookings SET status='PAID' WHERE booking_id=$booking_id");
        }

        header("Location: bookings_list.php");
        exit;
    }
}

// Fetch payment history
$payment_history = mysqli_query($conn, "SELECT * FROM payments WHERE booking_id=$booking_id ORDER BY payment_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Payment - Booking Management System</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include "../nav.php"; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>Process Payment</h1>
            <p>Booking ID: #<?php echo $booking_id; ?></p>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <h3>Payment Summary</h3>
            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    <div>
                        <p style="color: #6c757d; margin-bottom: 5px;">Total Cost</p>
                        <h2 style="color: #333;">₱<?php echo number_format($booking['total_cost'], 2); ?></h2>
                    </div>
                    <div>
                        <p style="color: #6c757d; margin-bottom: 5px;">Amount Paid</p>
                        <h2 style="color: #28a745;">₱<?php echo number_format($total_paid, 2); ?></h2>
                    </div>
                    <div>
                        <p style="color: #6c757d; margin-bottom: 5px;">Balance Due</p>
                        <h2 style="color: #dc3545;">₱<?php echo number_format($balance, 2); ?></h2>
                    </div>
                </div>
            </div>

            <?php if ($balance > 0): ?>
                <h3>Add Payment</h3>
                <form method="post">
                    <label>Payment Amount (₱) *</label>
                    <input type="number" name="amount_paid" step="0.01" min="0.01" max="<?php echo $balance; ?>" 
                           placeholder="Enter amount" required>

                    <label>Payment Method *</label>
                    <select name="method" required>
                        <option value="CASH">Cash</option>
                        <option value="GCASH">GCash</option>
                        <option value="CARD">Credit/Debit Card</option>
                        <option value="BANK">Bank Transfer</option>
                    </select>

                    <button type="submit" name="pay">💳 Process Payment</button>
                    <a href="bookings_list.php" class="btn" style="background: #6c757d; margin-left: 10px;">Cancel</a>
                </form>
            <?php else: ?>
                <div class="message success">
                    ✓ This booking is fully paid!
                </div>
                <a href="bookings_list.php" class="btn">← Back to Bookings</a>
            <?php endif; ?>
        </div>

        <?php if (mysqli_num_rows($payment_history) > 0): ?>
            <div class="card" style="margin-top: 20px;">
                <h3>Payment History</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($p = mysqli_fetch_assoc($payment_history)): ?>
                            <tr>
                                <td><?php echo date('M d, Y h:i A', strtotime($p['payment_date'])); ?></td>
                                <td><strong>₱<?php echo number_format($p['amount_paid'], 2); ?></strong></td>
                                <td><?php echo $p['method']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>