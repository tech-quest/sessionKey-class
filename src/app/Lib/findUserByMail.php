<?php
require_once __DIR__ . '/pdoInit.php';

function findUserByMail(string $mail): ?array
{
    $pdo = pdoInit();

    $sql = 'SELECT * FROM users WHERE email = :email';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':email', $mail, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    return $user ? $user : null;
}
