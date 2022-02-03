<?php
require_once __DIR__ . '/../../app/Lib/pdoInit.php';
require_once __DIR__ . '/../../app/Lib/findUserByMail.php';
require_once __DIR__ . '/../../app/Lib/redirect.php';
require_once __DIR__ . '/../../app/Lib/Session.php';
require_once(__DIR__ . '/../../app/Lib/SessionKey.php');

$mail = filter_input(INPUT_POST, 'mail');
$password = filter_input(INPUT_POST, 'password');

$session = Session::getInstance();
if (empty($mail) || empty($password)) {
    $session->appendError("パスワードとメールアドレスを入力してください");
    redirect("./user/signin.php");
}


$user = findUserByMail($mail);
if (!password_verify($password, $user["password"])) {
    $session->appendError("メールアドレスまたは<br />パスワードが違います");
    redirect("./signin.php");
}

$formInputs = [
    'userId' => $user['id'],
    'userName' => $user['user_name']
];
$formInputsKey = new SessionKey(SessionKey::FORM_INPUTS_KEY);
$session->setFormInputs($formInputsKey, $formInputs);
redirect("../index.php");
