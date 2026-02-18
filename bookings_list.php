<?php
include "../db.php";

$query = "
SELECT b.*, c.full_name, s.service_name
FROM bookings b
JOIN clients c ON b.client_id = c.client_id
JOIN services s ON b.service_id = s.service_id
ORDER BY b.booking_id DESC
";

$result = mysqli_query($conn, $query);
?>

<!doctype html>
<html>
<head>
<title>Bookings</title>
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container">

<h2>Bookings</h2>

<table>
<tr>
<th>ID</th>
<th>Client</th>
<th>Service</th>
<th>Date</th>
<th>Total</th>
<th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo $row['booking_id']; ?></td>
<td><?php echo $row['full_name']; ?></td>
<td><?php echo $row['service_name']; ?></td>
<td><?php echo $row['booking_date']; ?></td>
<td>₱<?php echo number_format($row['total_cost'],2); ?></td>
<td><?php echo $row['status']; ?></td>
</tr>
<?php } ?>

</table>

</div>
</body>
</html>
