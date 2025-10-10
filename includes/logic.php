<?php
// Handle add/edit/delete product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $name = $_POST['product_name'];
        $price = $_POST['product_price'];
        $stock = isset($_POST['product_stock']) ? (int)$_POST['product_stock'] : 0;
        if ($name && $price) {
            $stmt = $conn->prepare('INSERT INTO products (name, price, stock) VALUES (?, ?, ?)');
            $stmt->bind_param('sdi', $name, $price, $stock);
            $stmt->execute();
        }
    }
    if (isset($_POST['edit_product'])) {
        $id = $_POST['product_id'];
        $name = $_POST['product_name'];
        $price = $_POST['product_price'];
        $stock = isset($_POST['product_stock']) ? (int)$_POST['product_stock'] : 0;
        if ($id && $name && $price) {
            $stmt = $conn->prepare('UPDATE products SET name=?, price=?, stock=? WHERE id=?');
            $stmt->bind_param('sdii', $name, $price, $stock, $id);
            $stmt->execute();
        }
    }
    // Handle product sale
    if (isset($_POST['sell_product'])) {
        $product_id = $_POST['sell_product_id'];
        $quantity = max(1, (int)$_POST['sell_quantity']);
        $sale_price = (float)$_POST['sell_price'];
        if ($product_id && $quantity && $sale_price >= 0) {
            $stmt = $conn->prepare('INSERT INTO sales (product_id, quantity, sale_price) VALUES (?, ?, ?)');
            $stmt->bind_param('iid', $product_id, $quantity, $sale_price);
            $stmt->execute();
            // Decrease stock
            $stmt2 = $conn->prepare('UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?');
            $stmt2->bind_param('iii', $quantity, $product_id, $quantity);
            $stmt2->execute();
        }
    }
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($id) {
        $stmt = $conn->prepare('DELETE FROM products WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
}
?>