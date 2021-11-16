<?php
require_once(__DIR__ . '/../dao/UserDao.php');
require_once(__DIR__ . '/../utils/redirect.php');
require_once(__DIR__ . '/../utils/Session.php');
require_once(__DIR__ . '/../utils/SessionKey.php');

$mail = filter_input(INPUT_POST, 'mail');
$userName = filter_input(INPUT_POST, 'userName');
$password = filter_input(INPUT_POST, 'password');
$confirmPassword = filter_input(INPUT_POST, 'confirmPassword');

$session = Session::getInstance();
if (empty($password) || empty($confirmPassword)) $session->appendError("パスワードを入力してください");
if ($password !== $confirmPassword) $session->appendError("パスワードが一致しません");

if ($session->existsErrors()) {
  $formInputs = [
    'mail' => $mail,
    'userName' => $userName,
  ];
  $formInputsKey = new SessionKey(SessionKey::FORM_INPUTS_KEY);
  $session->set($formInputsKey, $formInputs);
  redirect('/dao-sample/user/signin.php');
}

$userDao = new UserDao();
// メールアドレスに一致するユーザーの取得
$user = $userDao->findByMail($mail);

if (!is_null($user)) $session->appendError("すでに登録済みのメールアドレスです");

if (!empty($_SESSION['errors'])) redirect('/dao-sample/user/signup.php');

// ユーザーの保存
$userDao->create($userName, $mail, $password);

$successRegistedMessage = "登録できました。";
$message = new SessionKey(SessionKey::MESSAGE_KEY);
$session->setMessage($message, $successRegistedMessage);
redirect('/dao-sample/user/signin.php');
