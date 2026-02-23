<?php
include "../db.php";
 
$message = "";
 
if (isset($_POST['save'])) {
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
 
  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    $sql = "INSERT INTO clients (full_name, email, phone, address)
            VALUES ('$full_name', '$email', '$phone', '$address')";
    mysqli_query($conn, $sql);
    header("Location: clients_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Client</title>
  <link rel="stylesheet" href="../style.css?v=3">
</head>
<body>
<?php include "../nav.php"; ?>

<div class="container">
  <a href="clients_list.php" class="back-link">&larr; Back to Clients</a>
  <h2>Add Client</h2>
  
  <?php if($message != "") { ?>
    <p style="color:#d32f2f; background: #ffebee; padding: 10px; border-radius: 6px; display: inline-block;">
      <?php echo $message; ?>
    </p>
  <?php } ?>
 
  <div class="form-container">
    <form method="post">
      <div class="form-group">
        <label>Full Name*</label>
        <input type="text" name="full_name" placeholder="e.g. Geoff Granada">
      </div>
    
      <div class="form-group">
        <label>Email*</label>
        <input type="email" name="email" placeholder="email@example.com">
      </div>
    
      <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" placeholder="Phone number">
      </div>
    
      <div class="form-group">
        <label>Address</label>
        <input type="text" name="address" placeholder="Full address">
      </div>
    
      <button type="submit" name="save">Save Client</button>
    </form>
  </div>
</div>

</body>
</html>