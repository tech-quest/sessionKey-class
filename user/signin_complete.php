<?php
require_once(__DIR__ . '/../dao/UserDao.php');
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/Session.php');
require_once(__DIR__ . '/../utils/SessionKey.php');

$mail = filter_input(INPUT_POST, 'mail');
$password = filter_input(INPUT_POST, 'password');

$session = Session::getInstance();
if (empty($mail) || empty($password)) {
    $session->appendError("パスワードとメールアドレスを入力してください");
    redirect("./user/signin.php");
}

$userDao = new UserDao();
$member = $userDao->findByMail($mail);

if (!password_verify($password, $member["password"])) {
    $session->appendError("メールアドレスまたは<br />パスワードが違います");
    redirect("./signin.php");
}

$formInputs = [
    'userId' => $member['id'],
    'userName' => $member['user_name']
];
$formInputsKey = new SessionKey(SessionKey::FORM_INPUTS_KEY);
$session->set($formInputsKey, $formInputs);
redirect("../index.php");
