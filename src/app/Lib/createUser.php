<?php
require_once __DIR__ . '/pdoInit.php';

function createUser(string $userName, string $mail, string $password): void
{
    $pdo = pdoInit();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql =
        'INSERT INTO users(name, email, password) VALUES (:name, :email, :password)';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':name', $userName, PDO::PARAM_STR);
    $statement->bindValue(':email', $mail, PDO::PARAM_STR);
    $statement->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
    $statement->execute();
}
