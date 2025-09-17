<?php /** @var string $viewFile */ ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo isset($title) ? htmlspecialchars($title) . ' - ' : ''; ?>M-Store</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="index.php?route=dashboard">M-Store</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample" aria-controls="navbarsExample" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarsExample">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<?php $route = $_GET['route'] ?? 'dashboard'; ?>
					<?php if (isset($_SESSION['user'])): ?>
					<li class="nav-item"><a class="nav-link <?php echo $route==='dashboard'?'active':''; ?>" href="index.php?route=dashboard">Dashboard</a></li>
					<li class="nav-item"><a class="nav-link <?php echo in_array($route, ['products','products_create','products_edit'])?'active':''; ?>" href="index.php?route=products">Products</a></li>
					<?php endif; ?>
				</ul>
				<div>
					<?php if (isset($_SESSION['user'])): ?>
					<a class="btn btn-outline-light btn-sm" href="index.php?route=logout">Logout</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</nav>
	<main class="container my-4">
		<?php require $viewFile; ?>
	</main>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
