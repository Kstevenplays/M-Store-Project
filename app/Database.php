<?php
namespace App;

use PDO;
use PDOException;

class Database
{
	private static $pdo = null;

	public static function getConnection()
	{
		if (self::$pdo !== null) {
			return self::$pdo;
		}
		$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		];
		try {
			self::$pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
			return self::$pdo;
		} catch (PDOException $e) {
			http_response_code(500);
			echo 'Database connection failed.';
			exit;
		}
	}
}
