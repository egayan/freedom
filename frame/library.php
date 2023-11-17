<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php require 'header.php'; ?>
<?php
$pdo=new PDO($connect,USER,PASS);
// データベースから購入履歴を取得
$stmt = $pdo->prepare('SELECT c.client_id, c.name, e.image, e.shohin_mei, e.pv FROM purchase pur
                      JOIN customer c ON pur.client_id = c.client_id
                      JOIN eiga e ON pur.shohin_id = e.shohin_id
                      WHERE pur.client_id = ?');
$stmt->execute([$_SESSION['customer']['client_id']]);
$purchase = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入映画</title>
</head>
<body>
    <p><a href=""><</a></p>
    <h1>ライブラリ</h1>
    <?php
// 購入した商品の情報を元に画像を表示し、画像をクリックすると動画のURLに遷移する
foreach ($purchase as $item) {
    echo '<div>';
    echo '<img src=image/'.$item['image'].' alt="'.$item['shohin_mei'].'">';
    echo '<p>動画名: '.$item['shohin_mei'].'</p>';
    // 画像にリンクを設定する
    echo '<a href="'.$item['pv'].'"target="_blank">動画を見る</a>';
    echo '</div>';
}
?>
   <?php require 'menu.php';?>
</body>
</html>