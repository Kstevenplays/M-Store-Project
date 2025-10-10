<?php
include 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sari-Sari Store</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <div class="nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="index.php">Products</a>
            <a href="sales.php">Sales/Expenses</a>
            <a href="monthly_report.php">Monthly Report</a>
            <button id="darkModeToggle" class="btn" style="float:right;">🌙 Dark Mode</button>
        </div>
        <script>
        // Dark mode toggle logic
        const toggle = document.getElementById('darkModeToggle');
        function setDarkMode(on) {
            document.body.classList.toggle('darkmode', on);
            localStorage.setItem('darkmode', on ? '1' : '0');
            toggle.textContent = on ? '☀️ Light Mode' : '🌙 Dark Mode';
        }
        toggle.addEventListener('click', () => {
            setDarkMode(!document.body.classList.contains('darkmode'));
        });
        // On load
        if (localStorage.getItem('darkmode') === '1') setDarkMode(true);
        </script>
        <div class="dashboard-cards">
            <?php
            $result = $conn->query('SELECT COUNT(*) as count FROM products');
            $row = $result->fetch_assoc();
            $product_count = $row['count'] ?? 0;
            $result = $conn->query('SELECT SUM(price) as total FROM products');
            $row = $result->fetch_assoc();
            $total_sales = $row['total'] ?? 0;
            ?>
            <div class="card">
                <h2><?php echo $product_count; ?></h2>
                <p>Total Products</p>
            </div>
            <div class="card">
                <h2>₱<?php echo number_format($total_sales, 2); ?></h2>
                <p>Total Sales/Expenses</p>
            </div>
        </div>
        <div class="dashboard-links">
            <a href="index.php" class="btn">Manage Products</a>
            <a href="sales.php" class="btn">View Sales/Expenses</a>
        </div>
    </div>
</body>
</html>