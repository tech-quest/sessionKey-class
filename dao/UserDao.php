<?php
require_once(__DIR__ . '/../dao/Dao.php');


final class UserDao extends Dao
{
	const TABLE_NAME = 'users';

	public function __construct()
	{
		parent::__construct();
	}

	public function create(string $userName, string $mail, string $password): void
	{
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

		$sql = sprintf(
			"INSERT INTO %s (user_name, mail, password) VALUES (:userName, :mail, :password)",
			self::TABLE_NAME
		);
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':userName', $userName, PDO::PARAM_STR);
		$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
		$statement->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
		$statement->execute();
	}

	public function findByMail(string $mail): ?array
	{
		$sql = sprintf(
			"SELECT * FROM %s WHERE mail = :mail",
			self::TABLE_NAME
		);
		$statement = $this->pdo->prepare($sql);
		$statement->bindValue(':mail', $mail, PDO::PARAM_STR);
		$statement->execute();
		$user = $statement->fetch(PDO::FETCH_ASSOC);

		return ($user) ? $user : null;
	}
}
