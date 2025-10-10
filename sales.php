<?php
include 'includes/db.php';
include 'includes/logic.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Sales & Expenses</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Total Sales & Expenses</h1>
        <div class="nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="index.php">Products</a>
            <a href="sales.php">Sales/Expenses</a>
            <a href="monthly_report.php">Monthly Report</a>
        </div>
        <?php include 'includes/sales.php'; ?>
    </div>
</body>
</html>