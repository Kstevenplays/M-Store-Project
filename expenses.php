<?php
include 'includes/db.php';
// Handle add expense
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_expense'])) {
    $desc = $_POST['expense_desc'];
    $amount = $_POST['expense_amount'];
    if ($desc && $amount) {
        $stmt = $conn->prepare('INSERT INTO expenses (description, amount) VALUES (?, ?)');
        $stmt->bind_param('sd', $desc, $amount);
        $stmt->execute();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Expenses</h1>
        <div class="nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="index.php">Products</a>
            <a href="expenses.php">Expenses</a>
            <a href="sales_log.php">Sales Log</a>
        </div>
        <form method="post" style="margin-bottom:20px;">
            <input type="text" name="expense_desc" placeholder="Expense Description" required>
            <input type="number" name="expense_amount" placeholder="Amount" step="0.01" required>
            <input type="submit" name="add_expense" value="Add Expense">
        </form>
        <table>
            <tr><th>Date</th><th>Description</th><th>Amount</th></tr>
            <?php
            $result = $conn->query('SELECT * FROM expenses ORDER BY expense_date DESC');
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['expense_date']) . '</td>';
                echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                echo '<td>₱' . number_format($row['amount'], 2) . '</td>';
                echo '</tr>';
            }
            ?>
        </table>
    </div>
</body>
</html>
