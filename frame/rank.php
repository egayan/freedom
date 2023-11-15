<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php require 'header.php'; ?>
<?php
$pdo=new PDO($connect,USER,PASS);
$stmt=$pdo->query('SELECT shohin_id,SUM(amount_spent) AS total FROM purchase
                    GROUP BY shohin_id ORDER BY total  LIMIT 10');
$ranking=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>売上ランキング</title>
</head>
<body>
 <!-- 画像をクリックしたら詳細画面に飛ぶ -->
    <h1>売上ランキング</h1>
    <?php foreach($ranking as $rank):?>
        <?php echo $rank['shohin_id']?><br>
    <?php endforeach;?>
   <?php require 'menu.php';?>
</body>
</html>