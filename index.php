<?php
include "db.php";

$clients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM clients"))['c'];
$services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM services"))['c'];
$bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM bookings"))['c'];

$revRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS s FROM payments"));
$revenue = $revRow['s'];
?>

<!doctype html>
<html>
<head>
  <title>Dashboard</title>
</head>
<body>

<?php include "nav.php"; ?>

<div class="container">

  <h2>Dashboard Overview</h2>

  <div class="stats">

    <div class="stat-box">
      <h3><?php echo $clients; ?></h3>
      <p>Total Clients</p>
    </div>

    <div class="stat-box">
      <h3><?php echo $services; ?></h3>
      <p>Total Services</p>
    </div>

    <div class="stat-box">
      <h3><?php echo $bookings; ?></h3>
      <p>Total Bookings</p>
    </div>

    <div class="stat-box">
      <h3>₱<?php echo number_format($revenue,2); ?></h3>
      <p>Total Revenue</p>
    </div>

  </div>

  <div class="card">
    <h3>Quick Actions</h3>
    <a class="btn" href="/assessment_beginner/pages/clients_add.php">Add Client</a>
    <a class="btn" href="/assessment_beginner/pages/bookings_create.php">Create Booking</a>
  </div>

</div>

</body>

</html>
