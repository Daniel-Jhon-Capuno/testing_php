<?php
include "../db.php";

$clients = mysqli_query($conn, "SELECT * FROM clients");
$services = mysqli_query($conn, "SELECT * FROM services WHERE is_active=1");

if(isset($_POST['submit'])){

  $client_id = $_POST['client_id'];
  $service_id = $_POST['service_id'];
  $date = $_POST['booking_date'];
  $hours = $_POST['hours'];

  $service = mysqli_fetch_assoc(mysqli_query($conn, "SELECT hourly_rate FROM services WHERE service_id=$service_id"));
  $rate = $service['hourly_rate'];

  $total = $rate * $hours;

  mysqli_query($conn, "INSERT INTO bookings 
  (client_id, service_id, booking_date, hours, hourly_rate_snapshot, total_cost)
  VALUES 
  ($client_id, $service_id, '$date', $hours, $rate, $total)");

  header("Location: bookings_list.php");
}
?>

<!doctype html>
<html>
<head>
<title>Create Booking</title>
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container">

<h2>Create Booking</h2>

<div class="card">

<form method="POST">

<label>Client</label>
<select name="client_id" required>
<?php while($c = mysqli_fetch_assoc($clients)) { ?>
<option value="<?php echo $c['client_id']; ?>">
<?php echo $c['full_name']; ?>
</option>
<?php } ?>
</select>

<label>Service</label>
<select name="service_id" required>
<?php while($s = mysqli_fetch_assoc($services)) { ?>
<option value="<?php echo $s['service_id']; ?>">
<?php echo $s['service_name']; ?>
</option>
<?php } ?>
</select>

<label>Booking Date</label>
<input type="date" name="booking_date" required>

<label>Hours</label>
<input type="number" name="hours" value="1" min="1">

<button class="btn" type="submit" name="submit">Save Booking</button>

</form>

</div>
</div>
</body>
</html>
