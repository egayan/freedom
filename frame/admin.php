<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php ob_start();?>
<?php
    $adminUsername='admin';
    $adminPassword='admin_paddword_hash';
  if($_SERVER["REQUEST_METHOD"]=='POST'){
    $username=$_POST['username'];
    $userpassword=$_POST['userpassword'];
    // 入力されたユーザー名とパスワードが正しいか検証
    if ($username == $adminUsername && password_verify($password, $adminPassword)) {
        $_SESSION['admin_logged_in'] = true;
          header('Location: admin_login.php');
          exit; 
      }else{
        $message='ログイン名パスワードが違います。';
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head> 
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/login.css" rel="stylesheet">
    <title>管理者ログイン画面</title>
</head>
<body>
<div class="wrap">
        <form action="admin_login.php" method="post">
            <div class="username">ユーザー名</div>
            <input type="text" name="username" class="username_input">

            <div class="password">パスワード</div>
            <input type="password" name="password" class="password_input">

            <div class="login_button">
                <input type="submit" value="ログイン">
            </div>
        </form>
    </div>
</body>
</html>
<?php ob_end_flush(); ?>