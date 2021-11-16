<?php


abstract class Dao
{
	const DB_USER = 'root';
	const DB_PASSWORD = 'root';
	const DB_HOST = 'localhost';
	const DB_NAME = 'blog';

	protected $pdo;

	protected function __construct()
	{
		$pdoSetting = sprintf(
			"mysql:host=%s; dbname=%s; charset=utf8mb4",
			self::DB_HOST,
			self::DB_NAME
		);
		$this->pdo = new PDO($pdoSetting, self::DB_USER, self::DB_PASSWORD);
	}
}
