<?php
include 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Log</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Product Sales Log</h1>
        <div class="nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="index.php">Products</a>
            <a href="expenses.php">Expenses</a>
            <a href="sales_log.php">Sales Log</a>
        </div>
        <table>
            <tr><th>Date</th><th>Product</th><th>Quantity</th><th>Sale Price</th></tr>
            <?php
            $sql = 'SELECT s.sale_date, p.name, s.quantity, s.sale_price FROM sales s JOIN products p ON s.product_id = p.id ORDER BY s.sale_date DESC';
            $result = $conn->query($sql);
            $total_sales = 0;
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['sale_date']) . '</td>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . (int)$row['quantity'] . '</td>';
                echo '<td>₱' . number_format($row['sale_price'], 2) . '</td>';
                echo '</tr>';
                $total_sales += $row['sale_price'] * $row['quantity'];
            }
            ?>
        </table>
        <h2 style="text-align:right; margin-top:20px;">Total Sales: ₱<?php echo number_format($total_sales, 2); ?></h2>
    </div>
</body>
</html>
