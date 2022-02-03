<?php
require_once __DIR__ . '/../../app/Lib/redirect.php';

session_start();

$_SESSION = [];
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 4200, '/');
}
session_destroy();
redirect('./signin.php');
