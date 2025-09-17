<?php $viewFile = __FILE__; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
	<h1 class="h4 mb-0">Products</h1>
	<a href="index.php?route=products_create" class="btn btn-primary">Add Product</a>
</div>
<form class="row g-2 mb-3" method="get" action="index.php">
	<input type="hidden" name="route" value="products">
	<div class="col-sm-8 col-md-6">
		<input type="text" name="q" class="form-control" placeholder="Search by name or category" value="<?php echo htmlspecialchars($q ?? ''); ?>">
	</div>
	<div class="col-auto">
		<button class="btn btn-outline-secondary">Search</button>
	</div>
</form>
<div class="table-responsive">
	<table class="table table-striped align-middle">
		<thead>
			<tr>
				<th>Name</th>
				<th>Category</th>
				<th class="text-end">Price</th>
				<th class="text-end">Stock</th>
				<th class="text-end">Low</th>
				<th>Expires</th>
				<th style="width:140px;"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach (($products ?? []) as $p): ?>
				<tr class="<?php echo ($p['stock'] <= $p['low_stock_threshold']) ? 'table-warning' : ''; ?>">
					<td><?php echo htmlspecialchars($p['name']); ?></td>
					<td><?php echo htmlspecialchars($p['category'] ?? ''); ?></td>
					<td class="text-end">₱<?php echo number_format((float)$p['price'], 2); ?></td>
					<td class="text-end"><?php echo (int)$p['stock']; ?></td>
					<td class="text-end"><?php echo (int)$p['low_stock_threshold']; ?></td>
					<td><?php echo htmlspecialchars($p['expires_at'] ?? ''); ?></td>
					<td class="text-end">
						<a class="btn btn-sm btn-outline-primary" href="index.php?route=products_edit&id=<?php echo (int)$p['id']; ?>">Edit</a>
						<a class="btn btn-sm btn-outline-danger" href="index.php?route=products_delete&id=<?php echo (int)$p['id']; }?>" onclick="return confirm('Delete this product?');">Delete</a>
					</td>
				</tr>
			<?php endforeach; ?>
			<?php if (empty($products)): ?>
				<tr><td colspan="7" class="text-center text-muted">No products found</td></tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>
