<?php
session_start();

require_once __DIR__ . '/../app/bootstrap.php';

$route = isset($_GET['route']) ? $_GET['route'] : 'dashboard';

switch ($route) {
	case 'login':
		$controller = new \App\Controllers\AuthController();
		$controller->login();
		break;
	case 'logout':
		$controller = new \App\Controllers\AuthController();
		$controller->logout();
		break;
	case 'dashboard':
		$controller = new \App\Controllers\DashboardController();
		$controller->index();
		break;
	case 'products':
		$controller = new \App\Controllers\ProductsController();
		$controller->index();
		break;
	case 'products_create':
		$controller = new \App\Controllers\ProductsController();
		$controller->create();
		break;
	case 'products_edit':
		$controller = new \App\Controllers\ProductsController();
		$controller->edit();
		break;
	case 'products_delete':
		$controller = new \App\Controllers\ProductsController();
		$controller->delete();
		break;
	default:
		http_response_code(404);
		echo '404 Not Found';
		break;
}
