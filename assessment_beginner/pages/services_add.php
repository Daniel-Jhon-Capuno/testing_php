<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$message = "";
$message_type = "";

if (isset($_POST['save'])) {
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $hourly_rate = $_POST['hourly_rate'];
    $is_active = $_POST['is_active'];

    if (empty($service_name) || empty($hourly_rate)) {
        $message = "Service name and hourly rate are required!";
        $message_type = "error";
    } elseif (!is_numeric($hourly_rate) || $hourly_rate <= 0) {
        $message = "Hourly rate must be a number greater than 0.";
        $message_type = "error";
    } else {
        $sql = "INSERT INTO services (service_name, description, hourly_rate, is_active)
                VALUES ('$service_name', '$description', '$hourly_rate', '$is_active')";
        mysqli_query($conn, $sql);

        header("Location: services_list.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service - Booking Management System</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include "../nav.php"; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>Add New Service</h1>
            <p>Create a new service offering</p>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <form method="post">
                <label>Service Name *</label>
                <input type="text" name="service_name" placeholder="e.g., Plumbing, Electrical" required>

                <label>Description</label>
                <textarea name="description" rows="4" placeholder="Describe the service..."></textarea>

                <label>Hourly Rate (₱) *</label>
                <input type="number" name="hourly_rate" step="0.01" min="0" placeholder="500.00" required>

                <label>Status</label>
                <select name="is_active">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>

                <button type="submit" name="save">💾 Save Service</button>
                <a href="services_list.php" class="btn" style="background: #6c757d; margin-left: 10px;">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>