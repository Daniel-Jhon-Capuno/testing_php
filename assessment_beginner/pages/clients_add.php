<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

include "../db.php";

$message = "";
$message_type = "";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    if (empty($name) || empty($email)) {
        $message = "Name and email are required!";
        $message_type = "error";
    } else {
        mysqli_query($conn, "INSERT INTO clients (full_name, email, phone, address)
        VALUES ('$name', '$email', '$phone', '$address')");
        
        header("Location: clients_list.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client - Booking Management System</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include "../nav.php"; ?>
    
    <div class="container">
        <div class="page-header">
            <h1>Add New Client</h1>
            <p>Enter client information below</p>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <form method="POST">
                <label>Full Name *</label>
                <input type="text" name="full_name" required placeholder="Enter full name">

                <label>Email *</label>
                <input type="email" name="email" required placeholder="client@example.com">

                <label>Phone</label>
                <input type="text" name="phone" placeholder="+63 912 345 6789">

                <label>Address</label>
                <textarea name="address" placeholder="Enter complete address"></textarea>

                <button type="submit" name="submit">💾 Save Client</button>
                <a href="clients_list.php" class="btn" style="background: #6c757d; margin-left: 10px;">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>