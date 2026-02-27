<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$message = "";
$message_type = "";

// ASSIGN TOOL
if (isset($_POST['assign'])) {
    $booking_id = intval($_POST['booking_id']);
    $tool_id = intval($_POST['tool_id']);
    $qty = intval($_POST['qty_used']);

    $toolRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT quantity_available FROM tools WHERE tool_id=$tool_id"));

    if ($qty > $toolRow['quantity_available']) {
        $message = "Not enough available tools! Only " . $toolRow['quantity_available'] . " available.";
        $message_type = "error";
    } else {
        mysqli_query($conn, "INSERT INTO booking_tools (booking_id, tool_id, qty_used)
          VALUES ($booking_id, $tool_id, $qty)");

        mysqli_query($conn, "UPDATE tools SET quantity_available = quantity_available - $qty WHERE tool_id=$tool_id");

        $message = "Tool assigned successfully!";
        $message_type = "success";
    }
}

$tools = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
$bookings = mysqli_query($conn, "SELECT b.booking_id, c.full_name, s.service_name 
                          FROM bookings b 
                          JOIN clients c ON b.client_id = c.client_id
                          JOIN services s ON b.service_id = s.service_id
                          ORDER BY b.booking_id DESC");

// Get assigned tools
$assigned = mysqli_query($conn, "
    SELECT bt.*, t.tool_name, b.booking_id, c.full_name
    FROM booking_tools bt
    JOIN tools t ON bt.tool_id = t.tool_id
    JOIN bookings b ON bt.booking_id = b.booking_id
    JOIN clients c ON b.client_id = c.client_id
    ORDER BY bt.booking_tool_id DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tools Management - Booking Management System</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include "../nav.php"; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>Tools & Inventory Management</h1>
            <p>Manage tools and assign them to bookings</p>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <h3>Available Tools Inventory</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tool Name</th>
                        <th>Total Quantity</th>
                        <th>Available</th>
                        <th>In Use</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    mysqli_data_seek($tools, 0);
                    while ($t = mysqli_fetch_assoc($tools)): 
                        $in_use = $t['quantity_total'] - $t['quantity_available'];
                        $availability = ($t['quantity_available'] / $t['quantity_total']) * 100;
                    ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($t['tool_name']); ?></strong></td>
                            <td><?php echo $t['quantity_total']; ?></td>
                            <td><strong style="color: #28a745;"><?php echo $t['quantity_available']; ?></strong></td>
                            <td style="color: #dc3545;"><?php echo $in_use; ?></td>
                            <td>
                                <?php if ($availability >= 50): ?>
                                    <span style="color: #28a745;">✓ Good Stock</span>
                                <?php elseif ($availability > 0): ?>
                                    <span style="color: #ffc107;">⚠ Low Stock</span>
                                <?php else: ?>
                                    <span style="color: #dc3545;">✗ Out of Stock</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3>Assign Tool to Booking</h3>
            <form method="post">
                <label>Select Booking *</label>
                <select name="booking_id" required>
                    <option value="">-- Choose Booking --</option>
                    <?php while ($b = mysqli_fetch_assoc($bookings)): ?>
                        <option value="<?php echo $b['booking_id']; ?>">
                            Booking #<?php echo $b['booking_id']; ?> - <?php echo htmlspecialchars($b['full_name']); ?> 
                            (<?php echo htmlspecialchars($b['service_name']); ?>)
                        </option>
                    <?php endwhile; ?>
                </select>

                <label>Select Tool *</label>
                <select name="tool_id" required>
                    <option value="">-- Choose Tool --</option>
                    <?php
                    $tools2 = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
                    while ($t2 = mysqli_fetch_assoc($tools2)):
                    ?>
                        <option value="<?php echo $t2['tool_id']; ?>" <?php echo $t2['quantity_available'] == 0 ? 'disabled' : ''; ?>>
                            <?php echo htmlspecialchars($t2['tool_name']); ?> 
                            (Available: <?php echo $t2['quantity_available']; ?>)
                        </option>
                    <?php endwhile; ?>
                </select>

                <label>Quantity to Use *</label>
                <input type="number" name="qty_used" min="1" value="1" required>

                <button type="submit" name="assign">🔨 Assign Tool</button>
            </form>
        </div>

        <div class="card">
            <h3>Tool Assignment History</h3>
            <table>
                <thead>
                    <tr>
                        <th>Assignment ID</th>
                        <th>Booking ID</th>
                        <th>Client</th>
                        <th>Tool</th>
                        <th>Quantity</th>
                        <th>Date Assigned</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($a = mysqli_fetch_assoc($assigned)): ?>
                        <tr>
                            <td>#<?php echo $a['booking_tool_id']; ?></td>
                            <td><a href="payment_process.php?booking_id=<?php echo $a['booking_id']; ?>">#<?php echo $a['booking_id']; ?></a></td>
                            <td><?php echo htmlspecialchars($a['full_name']); ?></td>
                            <td><strong><?php echo htmlspecialchars($a['tool_name']); ?></strong></td>
                            <td><?php echo $a['qty_used']; ?></td>
                            <td><?php echo date('M d, Y', strtotime($a['created_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>