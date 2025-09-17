<?php $viewFile = __FILE__; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
	<h1 class="h4 mb-0">Dashboard</h1>
	<div class="text-muted">Welcome, <?php echo htmlspecialchars($user['username'] ?? ''); ?></div>
</div>
<div class="row g-3">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<h6 class="card-title">Quick Links</h6>
				<ul class="list-unstyled mb-0">
					<li><a href="#">Products</a></li>
					<li><a href="#">Sales</a></li>
					<li><a href="#">Expenses</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="alert alert-info">App scaffold ready. Next: database schema and features.</div>
	</div>
</div>
