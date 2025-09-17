<?php

// Basic config
require_once __DIR__ . '/../config/config.php';

// Simple PSR-4 like autoloader for App namespace
spl_autoload_register(function ($class) {
	$prefix = 'App\\';
	$base_dir = __DIR__ . '/';
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		return;
	}
	$relative_class = substr($class, $len);
	$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
	if (file_exists($file)) {
		require $file;
	}
});

// Simple view renderer
function view($template, $data = []) {
	extract($data);
	$viewFile = __DIR__ . '/Views/' . $template . '.php';
	if (!file_exists($viewFile)) {
		echo 'View not found';
		return;
	}
	require __DIR__ . '/Views/layout.php';
}

// DB helper
function db() {
	return \App\Database::getConnection();
}
