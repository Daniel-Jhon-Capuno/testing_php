<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM clients ORDER BY client_id DESC");
?>

<!doctype html>
<html>
<head>
<title>Clients</title>
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container">

<h2>Clients</h2>

<a class="btn" href="clients_add.php">Add Client</a>

<br><br>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Address</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?php echo $row['client_id']; ?></td>
<td><?php echo $row['full_name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['phone']; ?></td>
<td><?php echo $row['address']; ?></td>
</tr>
<?php } ?>

</table>

</div>
</body>
</html>
