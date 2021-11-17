<?php
final class UserDao
{
	const TABLE_NAME = 'users';
	private $pdo;

	public function __construct()
	{
		try {
			$this->pdo = new PDO('mysql:dbname=blog;host=localhost;charset=utf8', 'root', 'root');
		} catch (PDOException $e) {
			exit('DB接続エラー:' . $e->getMessage());
		}
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
