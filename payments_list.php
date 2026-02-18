<?php
include "../db.php";

$query = "
SELECT p.*, c.full_name
FROM payments p
JOIN bookings b ON p.booking_id = b.booking_id
JOIN clients c ON b.client_id = c.client_id
ORDER BY p.payment_id DESC
";

$result = mysqli_query($conn, $query);
?>

<!doctype html>
<html>
<head>
<title>Payments</title>
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container">

<h2>Payments</h2>

<table>
<tr>
<th>ID</th>
<th>Client</th>
<th>Amount</th>
<th>Method</th>
<th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo $row['payment_id']; ?></td>
<td><?php echo $row['full_name']; ?></td>
<td>₱<?php echo number_format($row['amount_paid'],2); ?></td>
<td><?php echo $row['method']; ?></td>
<td><?php echo $row['payment_date']; ?></td>
</tr>
<?php } ?>

</table>

</div>
</body>
</html>
