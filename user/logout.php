<?php
require_once(__DIR__ . '/../utils/redirect.php');

session_start();

$_SESSION = [];
if (isset($_COOKIE[session_name()])) setcookie(session_name(), '', time() - 4200, '/');
session_destroy();
redirect('/sessionKey-class/user/signin.php');
