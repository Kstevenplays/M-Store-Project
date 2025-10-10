<?php
// Main page for Sari-Sari Store
include 'includes/db.php';
include 'includes/logic.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sari-Sari Store</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Sari-Sari Store Management</h1>
        <div class="nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="index.php">Products</a>
            <a href="sales.php">Sales/Expenses</a>
            <a href="monthly_report.php">Monthly Report</a>
        </div>
        <?php include 'includes/products.php'; ?>
    </div>
</body>
</html>