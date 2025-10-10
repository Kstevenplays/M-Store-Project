<?php
include 'includes/db.php';
include 'includes/logic.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Sales</h1>
        <div class="nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="index.php">Products</a>
            <a href="expenses.php">Expenses</a>
            <a href="sales_log.php">Sales Log</a>
        </div>
        <?php include 'includes/sales.php'; ?>
    </div>
</body>
</html>