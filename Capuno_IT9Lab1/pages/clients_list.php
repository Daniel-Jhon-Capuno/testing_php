<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM clients ORDER BY client_id DESC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Clients</title>
  <link rel="stylesheet" href="../style.css?v=2">
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container">
  
  <div class="page-header">
    <h2>Clients</h2>
    <a href="clients_add.php" class="btn-add">+ Add Client</a>
  </div>
 
  <div class="table-container">
    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Action</th>
      </tr>
      <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $row['client_id']; ?></td>
          <td><?php echo $row['full_name']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php echo $row['phone']; ?></td>
          <td>
            <a href="clients_edit.php?id=<?php echo $row['client_id']; ?>" class="action-link">Edit</a>
          </td>
        </tr>
      <?php } ?>
    </table>
  </div>

</div>

</body>
</html>