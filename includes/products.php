<?php
// Display products and add/edit form
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM products WHERE id=$id");
    $product = $result->fetch_assoc();
}
// Search form
?>
<form method="get" style="margin-bottom: 16px;">
    <input type="text" name="search" placeholder="Search product name" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" style="padding:8px; border:1px solid #ccc; border-radius:4px; margin-right:8px;">
    <input type="submit" value="Search" style="background:#2980b9; color:#fff; border:none; padding:8px 16px; border-radius:4px; cursor:pointer;">
</form>
<form method="post">
    <input type="hidden" name="product_id" value="<?php echo isset($product) ? $product['id'] : ''; ?>">
    <input type="text" name="product_name" placeholder="Product Name" value="<?php echo isset($product) ? $product['name'] : ''; ?>" required>
    <input type="number" name="product_price" placeholder="Price" step="0.01" value="<?php echo isset($product) ? $product['price'] : ''; ?>" required>
    <?php if (isset($product)) { ?>
        <input type="submit" name="edit_product" value="Update Product" style="background:#e67e22; color:#fff; border:none; padding:8px 16px; border-radius:4px; cursor:pointer; margin-right:8px;">
        <a href="index.php<?php echo isset($_GET['search']) ? '?search=' . urlencode($_GET['search']) : ''; ?>" style="background:#7f8c8d; color:#fff; padding:8px 16px; border-radius:4px; text-decoration:none;">Cancel</a>
    <?php } else { ?>
        <input type="submit" name="add_product" value="Add Product" style="background:#27ae60; color:#fff; border:none; padding:8px 16px; border-radius:4px; cursor:pointer;">
    <?php } ?>
</form>
<table>
    <tr><th>Name</th><th>Price</th><th>Action</th></tr>
    <?php
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $query = $search ? "SELECT * FROM products WHERE name LIKE '%$search%'" : 'SELECT * FROM products';
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . number_format($row['price'], 2) . '</td>';
        echo '<td><a href="?edit=' . $row['id'] . ( $search ? '&search=' . urlencode($search) : '' ) . '">Edit</a> | <a href="?delete=' . $row['id'] . ( $search ? '&search=' . urlencode($search) : '' ) . '" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a></td>';
        echo '</tr>';
    }
    ?>
</table>
