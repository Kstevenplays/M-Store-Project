<?php
// Handle add/edit product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $name = $_POST['product_name'];
        $price = $_POST['product_price'];
        if ($name && $price) {
            $stmt = $conn->prepare('INSERT INTO products (name, price) VALUES (?, ?)');
            $stmt->bind_param('sd', $name, $price);
            $stmt->execute();
        }
    }
    if (isset($_POST['edit_product'])) {
        $id = $_POST['product_id'];
        $name = $_POST['product_name'];
        $price = $_POST['product_price'];
        if ($id && $name && $price) {
            $stmt = $conn->prepare('UPDATE products SET name=?, price=? WHERE id=?');
            $stmt->bind_param('sdi', $name, $price, $id);
            $stmt->execute();
        }
    }
}
?>