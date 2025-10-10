<?php
include 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Report - Sari-Sari Store</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Monthly Report</h1>
        <div class="nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="index.php">Products</a>
            <a href="expenses.php">Expenses</a>
            <a href="sales_log.php">Sales Log</a>
        </div>
        <form method="get" style="margin-bottom: 20px;">
            <label for="month">Select Month:</label>
            <input type="month" id="month" name="month" value="<?php echo isset($_GET['month']) ? htmlspecialchars($_GET['month']) : date('Y-m'); ?>">
            <input type="submit" value="View Report" class="btn">
        </form>
        <?php
        // For demo: Assume all products are added in the selected month (since no date field in products table)
        // In a real app, you would filter by a date column (e.g., created_at)
        $selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
        echo '<h2>Report for ' . date('F Y', strtotime($selectedMonth . '-01')) . '</h2>';
        $result = $conn->query('SELECT * FROM products');
        $total = 0;
        echo '<table><tr><th>Name</th><th>Price</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . number_format($row['price'], 2) . '</td>';
            echo '</tr>';
            $total += $row['price'];
        }
        echo '</table>';
        echo '<h3>Total Sales/Expenses: ₱' . number_format($total, 2) . '</h3>';
        ?>
    </div>
</body>
</html>
