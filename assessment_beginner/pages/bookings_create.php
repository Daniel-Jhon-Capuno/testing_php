<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$clients = mysqli_query($conn, "SELECT * FROM clients ORDER BY full_name ASC");
$services = mysqli_query($conn, "SELECT * FROM services WHERE is_active=1 ORDER BY service_name ASC");

if (isset($_POST['create'])) {
    $client_id = intval($_POST['client_id']);
    $service_id = intval($_POST['service_id']);
    $booking_date = mysqli_real_escape_string($conn, $_POST['booking_date']);
    $hours = intval($_POST['hours']);

    // Get service hourly rate
    $s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT hourly_rate FROM services WHERE service_id=$service_id"));
    $rate = $s['hourly_rate'];

    $total = $rate * $hours;

    mysqli_query($conn, "INSERT INTO bookings (client_id, service_id, booking_date, hours, hourly_rate_snapshot, total_cost, status)
      VALUES ($client_id, $service_id, '$booking_date', $hours, $rate, $total, 'PENDING')");

    header("Location: bookings_list.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Booking - Booking Management System</title>
    <link rel="stylesheet" href="../style.css">
    <script>
        function calculateTotal() {
            const serviceSelect = document.querySelector('select[name="service_id"]');
            const hoursInput = document.querySelector('input[name="hours"]');
            const totalDisplay = document.getElementById('total-display');
            
            if (serviceSelect.value && hoursInput.value) {
                const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                const rate = parseFloat(selectedOption.dataset.rate);
                const hours = parseInt(hoursInput.value);
                const total = rate * hours;
                
                totalDisplay.innerHTML = `<strong>Estimated Total: ₱${total.toFixed(2)}</strong>`;
            }
        }
    </script>
</head>
<body>
    <?php include "../nav.php"; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>Create New Booking</h1>
            <p>Schedule a new service booking</p>
        </div>

        <div class="card">
            <form method="post">
                <label>Select Client *</label>
                <select name="client_id" required>
                    <option value="">-- Choose Client --</option>
                    <?php while ($c = mysqli_fetch_assoc($clients)): ?>
                        <option value="<?php echo $c['client_id']; ?>">
                            <?php echo htmlspecialchars($c['full_name']); ?> (<?php echo htmlspecialchars($c['email']); ?>)
                        </option>
                    <?php endwhile; ?>
                </select>

                <label>Select Service *</label>
                <select name="service_id" onchange="calculateTotal()" required>
                    <option value="">-- Choose Service --</option>
                    <?php while ($s = mysqli_fetch_assoc($services)): ?>
                        <option value="<?php echo $s['service_id']; ?>" data-rate="<?php echo $s['hourly_rate']; ?>">
                            <?php echo htmlspecialchars($s['service_name']); ?> 
                            (₱<?php echo number_format($s['hourly_rate'], 2); ?>/hr)
                        </option>
                    <?php endwhile; ?>
                </select>

                <label>Booking Date *</label>
                <input type="date" name="booking_date" min="<?php echo date('Y-m-d'); ?>" required>

                <label>Number of Hours *</label>
                <input type="number" name="hours" min="1" value="1" onchange="calculateTotal()" required>

                <div id="total-display" style="padding: 15px; background: #e7f3ff; border-radius: 8px; margin-bottom: 20px; color: #0066cc;">
                    Select service and hours to calculate total
                </div>

                <button type="submit" name="create">📝 Create Booking</button>
                <a href="bookings_list.php" class="btn" style="background: #6c757d; margin-left: 10px;">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>