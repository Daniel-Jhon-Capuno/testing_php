<?php
include "../db.php";
// Your existing query
$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #154C51; 
            --primary-hover: #0f3b3f;
            --secondary: #27ae60; 
            --secondary-hover: #219150;
            --bg-color: #f4f6f9;
            --text-main: #334155;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --surface: #ffffff;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        h2 {
            margin: 0;
            color: var(--primary);
            font-size: 24px;
            font-weight: 600;
        }

        .btn-add {
            background-color: var(--secondary);
            color: white !important;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(39, 174, 96, 0.2);
        }

        .btn-add:hover {
            background-color: var(--secondary-hover);
            transform: translateY(-1px);
        }

        .table-container {
            background: var(--surface);
            border-radius: 10px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background-color: #f8fafc;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-main);
            font-size: 14px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: #f1f5f9;
        }

        /* Status Badges */
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-yes {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-no {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .action-link {
            text-decoration: none;
            color: var(--primary);
            font-weight: 500;
            font-size: 13px;
            background: #e2e8f0;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .action-link:hover {
            background: #cbd5e1;
        }
    </style>
</head>
<body>

    <?php include "../nav.php"; ?>

    <div class="container">
        <div class="page-header">
            <h2>Services</h2>
            <a href="services_add.php" class="btn-add">+ Add New Service</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Rate</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><span style="color: var(--text-muted);">#<?php echo $row['service_id']; ?></span></td>
                        <td><strong><?php echo htmlspecialchars($row['service_name']); ?></strong></td>
                        <td>₱<?php echo number_format($row['hourly_rate'], 2); ?></td>
                        <td>
                            <?php if($row['is_active']): ?>
                                <span class="badge badge-yes">Active</span>
                            <?php else: ?>
                                <span class="badge badge-no">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="services_edit.php?id=<?php echo $row['service_id']; ?>" class="action-link">Edit</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>