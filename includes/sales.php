<?php
// Display total sales/expenses
$result = $conn->query('SELECT SUM(price) as total FROM products');
$row = $result->fetch_assoc();
$total = $row['total'] ?? 0;
echo '<h2>Total Sales/Expenses: ₱' . number_format($total, 2) . '</h2>';
?>