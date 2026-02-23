<?php 
include "db.php";

$clients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM clients"))['c'];
$services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS s FROM services"))['s'];
$bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS b FROM bookings"))['b'];

$revRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS s FROM payments"));
$revenue = $revRow['s'];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f4f6f9;
    }

    .container {
      padding: 30px;
      max-width: 1100px;
      margin: auto;
    }

    h2 {
      margin-bottom: 25px;
      color: #333;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .card {
      background: white;
      padding: 25px;
      border-radius: 12px;
      
    }

    

    .card h3 {
      margin: 0 0 10px;
      font-size: 15px;
      color: #666;
      font-weight: 500;
    }

    .card .value {
      font-size: 28px;
      font-weight: bold;
      color: #154C51;
    }

    .links {
      margin-top: 20px;
    }

    .btn {
      display: inline-block;
      padding: 10px 18px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 500;
      margin-right: 10px;
      transition: 0.2s;
    }

    .btn-primary {
      background: #154C51;
      color: white;
    }

    .btn-primary:hover {
      background: #0f3b3f;
    }

    .btn-secondary {
      background: #e4e6eb;
      color: #333;
    }

    .btn-secondary:hover {
      background: #d0d3d8;
    }

  </style>
</head>
<body>

<?php include "nav.php"; ?>

<div class="container">
  <h2>Dashboard Overview</h2>

  <div class="cards">
    <div class="card">
      <h3>Total Clients</h3>
      <div class="value"><?php echo $clients; ?></div>
    </div>

    <div class="card">
      <h3>Total Services</h3>
      <div class="value"><?php echo $services; ?></div>
    </div>

    <div class="card">
      <h3>Total Bookings</h3>
      <div class="value"><?php echo $bookings; ?></div>
    </div>

    <div class="card">
      <h3>Total Revenue</h3>
      <div class="value">₱<?php echo number_format($revenue,2); ?></div>
    </div>
  </div>

  <div class="links">
    <a href="/assessment_beginner/pages/clients_add.php" class="btn btn-primary">+ Add Client</a>
    <a href="/assessment_beginner/pages/bookings_create.php" class="btn btn-secondary">+ Create Booking</a>
  </div>
</div>

</body>
</html>
