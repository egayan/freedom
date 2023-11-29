<?php require 'db-conect.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ダッシュボード</title>
</head>
<body>
    <div class="wrap">
        <h1>管理者ダッシュボード</h1>

        <!-- 顧客情報変更ページへのリンク -->
        <a href="admin_customer.php">顧客情報の変更</a>

        <!-- 商品情報変更ページへのリンク -->
        <a href="admin_product.php">商品情報の変更</a>

        <!-- ログアウトリンク -->
        <a href="admin_login.php">ログアウト</a>
    </div>
</body>
</html>
