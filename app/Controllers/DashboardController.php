<?php
namespace App\Controllers;

class DashboardController
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
		view('dashboard/index', [
			'title' => 'Dashboard',
			'user' => $_SESSION['user']
		]);
	}
}
