<?php

namespace src\Repositories;

require_once __DIR__ . '/../../vendor/autoload.php'; // needed for Composer dependencies

use PDO;
use PDOException;
use Dotenv\Dotenv;

class Repository {

	protected PDO $pdo;
	private string $hostname;
	private string $username;
	private string $databaseName;
	private string $databasePassword;
	private string $charset;

	public function __construct() {

		// TODO: Load database environment information using DotEnv: https://github.com/vlucas/phpdotenv
		
		// dev -> QA -> staging -> production
		//$dotenv = Dotenv::createImmutable(__DIR__ . '/../../', .env.something); // if you called the env something else
		$dotenv = Dotenv::createImmutable(__DIR__ . '/../../'); // from current directory go back two directories
		$dotenv->load();

		//$this->hostname = 'localhost';
		$this->hostname = $_ENV['DB_HOST'];
		$this->username = 'root';
		$this->databaseName = 'posts_web_app2';
		$this->databasePassword = 'root';
		$this->charset = 'utf8mb4';

		$dsn = "mysql:host=$this->hostname;dbname=$this->databaseName;charset=$this->charset";
		// For options info, see: https://www.php.net/manual/en/pdo.setattribute.php
		$options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
		try {
			$this->pdo = new PDO($dsn, $this->username, $this->databasePassword, $options);
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage(), (int)$e->getCode());
		}
	}

	public function beginDbTransaction(): bool {
		return $this->pdo->beginTransaction();
	}

	public function rollBackTransaction(): bool {
		return $this->pdo->rollBack();
	}

	public function commitTransaction(): bool {
		return $this->pdo->commit();
	}
}
