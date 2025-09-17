<?php
namespace App\Controllers;

class ProductsController
{
	private function ensureAuthenticated()
	{
		if (!isset($_SESSION['user'])) {
			header('Location: index.php?route=login');
			exit;
		}
	}

	public function index()
	{
		$this->ensureAuthenticated();
		$pdo = db();
		$search = isset($_GET['q']) ? trim($_GET['q']) : '';
		if ($search !== '') {
			$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :q OR category LIKE :q ORDER BY name ASC");
			$stmt->execute([':q' => "%$search%"]);
		} else {
			$stmt = $pdo->query("SELECT * FROM products ORDER BY name ASC");
		}
		$products = $stmt->fetchAll();
		view('products/index', [
			'title' => 'Products',
			'products' => $products,
			'q' => $search,
		]);
	}

	public function create()
	{
		$this->ensureAuthenticated();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$name = trim($_POST['name'] ?? '');
			$category = trim($_POST['category'] ?? '');
			$price = (float)($_POST['price'] ?? 0);
			$stock = (int)($_POST['stock'] ?? 0);
			$low = (int)($_POST['low_stock_threshold'] ?? 5);
			$expires = $_POST['expires_at'] ?? null;
			$expires = $expires === '' ? null : $expires;
			$errors = [];
			if ($name === '') $errors[] = 'Name is required';
			if ($price < 0) $errors[] = 'Price must be >= 0';
			if ($stock < 0) $errors[] = 'Stock must be >= 0';
			if ($low < 0) $errors[] = 'Low stock threshold must be >= 0';
			if (empty($errors)) {
				$pdo = db();
				$stmt = $pdo->prepare("INSERT INTO products (name, category, price, stock, low_stock_threshold, expires_at) VALUES (?,?,?,?,?,?)");
				$stmt->execute([$name, $category ?: null, $price, $stock, $low, $expires]);
				header('Location: index.php?route=products');
				exit;
			}
			view('products/create', ['title' => 'Add Product', 'errors' => $errors, 'form' => $_POST]);
			return;
		}
		view('products/create', ['title' => 'Add Product']);
	}

	public function edit()
	{
		$this->ensureAuthenticated();
		$pdo = db();
		$id = (int)($_GET['id'] ?? 0);
		if ($id <= 0) { http_response_code(400); echo 'Bad Request'; return; }
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$name = trim($_POST['name'] ?? '');
			$category = trim($_POST['category'] ?? '');
			$price = (float)($_POST['price'] ?? 0);
			$stock = (int)($_POST['stock'] ?? 0);
			$low = (int)($_POST['low_stock_threshold'] ?? 5);
			$expires = $_POST['expires_at'] ?? null;
			$expires = $expires === '' ? null : $expires;
			$errors = [];
			if ($name === '') $errors[] = 'Name is required';
			if ($price < 0) $errors[] = 'Price must be >= 0';
			if ($stock < 0) $errors[] = 'Stock must be >= 0';
			if ($low < 0) $errors[] = 'Low stock threshold must be >= 0';
			$pdo->beginTransaction();
			try {
				$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? FOR UPDATE");
				$stmt->execute([$id]);
				$existing = $stmt->fetch();
				if (!$existing) { $pdo->rollBack(); http_response_code(404); echo 'Not Found'; return; }
				if (empty($errors)) {
					$stmt = $pdo->prepare("UPDATE products SET name=?, category=?, price=?, stock=?, low_stock_threshold=?, expires_at=? WHERE id=?");
					$stmt->execute([$name, $category ?: null, $price, $stock, $low, $expires, $id]);
					if ((float)$existing['price'] !== $price) {
						$hist = $pdo->prepare("INSERT INTO product_price_history (product_id, old_price, new_price, changed_by_user_id) VALUES (?,?,?,?)");
						$hist->execute([$id, (float)$existing['price'], $price, $_SESSION['user']['id'] ?? null]);
					}
					$pdo->commit();
					header('Location: index.php?route=products');
					exit;
				}
				$pdo->rollBack();
			} catch (\Throwable $e) {
				if ($pdo->inTransaction()) { $pdo->rollBack(); }
				$errors[] = 'Failed to update product';
			}
			$product = array_merge($existing ?? [], $_POST);
			view('products/edit', ['title' => 'Edit Product', 'errors' => $errors, 'product' => $product]);
			return;
		}
		$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
		$stmt->execute([$id]);
		$product = $stmt->fetch();
		if (!$product) { http_response_code(404); echo 'Not Found'; return; }
		view('products/edit', ['title' => 'Edit Product', 'product' => $product]);
	}

	public function delete()
	{
		$this->ensureAuthenticated();
		$pdo = db();
		$id = (int)($_GET['id'] ?? 0);
		if ($id <= 0) { http_response_code(400); echo 'Bad Request'; return; }
		$stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
		$stmt->execute([$id]);
		header('Location: index.php?route=products');
		exit;
	}
}
