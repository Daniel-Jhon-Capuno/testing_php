<?php
include "../db.php";

if(isset($_POST['submit'])){
  $name = $_POST['full_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];

  mysqli_query($conn, "INSERT INTO clients (full_name,email,phone,address)
  VALUES ('$name','$email','$phone','$address')");

  header("Location: clients_list.php");
}
?>

<!doctype html>
<html>
<head>
<title>Add Client</title>
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container">

<h2>Add Client</h2>

<div class="card">
<form method="POST">

<label>Full Name</label>
<input type="text" name="full_name" required>

<label>Email</label>
<input type="email" name="email" required>

<label>Phone</label>
<input type="text" name="phone">

<label>Address</label>
<textarea name="address"></textarea>

<button class="btn" type="submit" name="submit">Save Client</button>

</form>
</div>

</div>
</body>
</html>
