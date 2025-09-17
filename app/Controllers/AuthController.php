<?php
namespace App\Controllers;

class AuthController
{
	public function login()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// TODO: Replace with DB-backed auth
			$username = isset($_POST['username']) ? trim($_POST['username']) : '';
			$password = isset($_POST['password']) ? $_POST['password'] : '';
			if ($username === 'admin' && $password === 'admin') {
				$_SESSION['user'] = ['username' => 'admin', 'role' => 'admin'];
				header('Location: index.php?route=dashboard');
				exit;
			}
			$errors = ['Invalid username or password'];
			view('auth/login', ['title' => 'Login', 'errors' => $errors]);
			return;
		}
		view('auth/login', ['title' => 'Login']);
	}

	public function logout()
	{
		unset($_SESSION['user']);
		header('Location: index.php?route=login');
		exit;
	}
}
