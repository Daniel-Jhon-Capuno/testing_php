<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM services");
?>

<!doctype html>
<html>
<head>
<title>Services</title>
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container">

<h2>Services</h2>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Description</th>
<th>Rate</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo $row['service_id']; ?></td>
<td><?php echo $row['service_name']; ?></td>
<td><?php echo $row['description']; ?></td>
<td>₱<?php echo number_format($row['hourly_rate'],2); ?></td>
</tr>
<?php } ?>

</table>

</div>
</body>
</html>
