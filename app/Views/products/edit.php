<?php $viewFile = __FILE__; ?>
<h1 class="h4 mb-3">Edit Product</h1>
<?php if (!empty($errors ?? [])): ?>
	<div class="alert alert-danger">
		<?php foreach (($errors ?? []) as $e): ?>
			<div><?php echo htmlspecialchars($e); ?></div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<form method="post" action="index.php?route=products_edit&id=<?php echo (int)($product['id'] ?? 0); ?>" class="row g-3">
	<div class="col-md-6">
		<label class="form-label">Name</label>
		<input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" required>
	</div>
	<div class="col-md-6">
		<label class="form-label">Category</label>
		<input type="text" name="category" class="form-control" value="<?php echo htmlspecialchars($product['category'] ?? ''); ?>">
	</div>
	<div class="col-md-4">
		<label class="form-label">Price</label>
		<input type="number" step="0.01" min="0" name="price" class="form-control" value="<?php echo htmlspecialchars((string)($product['price'] ?? '0')); ?>" required>
	</div>
	<div class="col-md-4">
		<label class="form-label">Stock</label>
		<input type="number" step="1" min="0" name="stock" class="form-control" value="<?php echo htmlspecialchars((string)($product['stock'] ?? '0')); ?>" required>
	</div>
	<div class="col-md-4">
		<label class="form-label">Low Stock Threshold</label>
		<input type="number" step="1" min="0" name="low_stock_threshold" class="form-control" value="<?php echo htmlspecialchars((string)($product['low_stock_threshold'] ?? '5')); ?>" required>
	</div>
	<div class="col-md-4">
		<label class="form-label">Expiry Date (optional)</label>
		<input type="date" name="expires_at" class="form-control" value="<?php echo htmlspecialchars($product['expires_at'] ?? ''); ?>">
	</div>
	<div class="col-12">
		<button class="btn btn-primary">Save</button>
		<a href="index.php?route=products" class="btn btn-secondary">Cancel</a>
	</div>
</form>
