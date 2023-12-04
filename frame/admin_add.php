<?php
ob_start();
require 'db-conect.php'; // データベース接続ファイル
$pdo=new PDO($connect, USER, PASS);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // パスワードのハッシュ化
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // データベースにユーザー情報を保存
    $stmt = $pdo->prepare("INSERT INTO admin (admin_name, admin_password) VALUES (?, ?)");
    $stmt->execute([$username, $hashedPassword]);

    header('Location: login.php');
    exit;
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
</head>
<body>
    <h2>ユーザー登録</h2>
    <form method="post">
        <label for="username">ユーザー名:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="登録">
    </form>
</body>
</html>
