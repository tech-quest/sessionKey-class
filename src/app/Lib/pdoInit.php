<?php

function pdoInit(): PDO
{
    $dbUserName = 'php_user';
    $dbPassword = 'pass1';
    $pdo = new PDO(
        'mysql:host=mysql; dbname=blog; charset=utf8',
        $dbUserName,
        $dbPassword
    );
    return $pdo;
}
