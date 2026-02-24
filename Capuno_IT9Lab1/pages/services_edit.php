<?php
include "../db.php";
$id = $_GET['id'];

$get = mysqli_query($conn, "SELECT * FROM services WHERE service_id = $id");
$service = mysqli_fetch_assoc($get);

if (isset($_POST['update'])) {
  $name = mysqli_real_escape_string($conn, $_POST['service_name']);
  $desc = mysqli_real_escape_string($conn, $_POST['description']);
  $rate = mysqli_real_escape_string($conn, $_POST['hourly_rate']);
  $active = $_POST['is_active'];

  mysqli_query($conn, "UPDATE services 
    SET service_name='$name', description='$desc', hourly_rate='$rate', is_active='$active' 
    WHERE service_id=$id");

  header("Location: services_list.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Service</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #154C51; --primary-hover: #0f3b3f;
            --bg-color: #f4f6f9; --text-main: #334155;
            --text-muted: #64748b; --border-color: #e2e8f0;
            --surface: #ffffff;
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-color); color: var(--text-main); margin: 0; }
        .container { max-width: 1000px; margin: 0 auto; padding: 40px 20px; }
        .page-header { margin-bottom: 24px; }
        h2 { color: var(--primary); margin: 0; font-size: 24px; }
        .form-container { background: var(--surface); padding: 32px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); max-width: 500px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: 500; margin-bottom: 8px; font-size: 14px; }
        input[type="text"], select, textarea { 
            width: 100%; padding: 12px; border: 1px solid var(--border-color); 
            border-radius: 6px; box-sizing: border-box; font-family: inherit;
        }
        input:focus, select:focus, textarea:focus { 
            outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(21, 76, 81, 0.1); 
        }
        button { 
            background: var(--primary); color: white; padding: 12px; border: none; 
            border-radius: 6px; cursor: pointer; width: 100%; font-weight: 500; font-size: 15px;
        }
        button:hover { background: var(--primary-hover); }
        .back-link { text-decoration: none; color: var(--text-muted); font-size: 14px; display: inline-block; margin-bottom: 20px; }
    </style>
</head>
<body>
    <?php include "../nav.php"; ?>

    <div class="container">
        <a href="services_list.php" class="back-link">← Back to Services</a>
        
        <div class="page-header">
            <h2>Edit Service</h2>
        </div>

        <div class="form-container">
            <form method="post">
                <div class="form-group">
                    <label>Service Name</label>
                    <input type="text" name="service_name" value="<?php echo htmlspecialchars($service['service_name']); ?>">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4"><?php echo htmlspecialchars($service['description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Hourly Rate ($)</label>
                    <input type="text" name="hourly_rate" value="<?php echo htmlspecialchars($service['hourly_rate']); ?>">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="is_active">
                        <option value="1" <?php if($service['is_active']==1) echo "selected"; ?>>Active (Visible)</option>
                        <option value="0" <?php if($service['is_active']==0) echo "selected"; ?>>Inactive (Hidden)</option>
                    </select>
                </div>

                <button type="submit" name="update">Update Service</button>
            </form>
        </div>
    </div>
</body>
</html>