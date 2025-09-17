<?php $viewFile = __FILE__; ?>
<div class="row justify-content-center">
	<div class="col-md-4">
		<h1 class="h4 mb-3">Login</h1>
		<?php if (!empty($errors ?? [])): ?>
			<div class="alert alert-danger">
				<?php foreach (($errors ?? []) as $e): ?>
					<div><?php echo htmlspecialchars($e); ?></div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<form method="post" action="index.php?route=login">
			<div class="mb-3">
				<label class="form-label">Username</label>
				<input type="text" name="username" class="form-control" required>
			</div>
			<div class="mb-3">
				<label class="form-label">Password</label>
				<input type="password" name="password" class="form-control" required>
			</div>
			<button class="btn btn-primary w-100">Login</button>
			<div class="form-text mt-2">Use admin/admin for now.</div>
		</form>
	</div>
</div>
