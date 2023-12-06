<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php require 'header.php'; ?>
<?php
$pdo=new PDO($connect,USER,PASS);
// データベースから購入履歴を取得
$stmt = $pdo->prepare('SELECT pur.shohin_id, c.client_id, c.name, e.image, e.shohin_mei, e.pv FROM purchase pur
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
    <link href="style/libraly.css" rel="stylesheet">
    <title>購入映画</title>
</head>
<body>
    <div class="warp">
    <?php require 'menu.php';?>
    <h1>ライブラリ</h1>
    <?php
    echo '<table>';
    echo '<tbody>';
    echo '<tr>';
    $i=1;
   
// 購入した商品の情報を元に画像を表示し、画像をクリックすると動画のURLに遷移する
foreach ($purchase as $item) {
    echo '<td>';
    echo '<div class="a">';
    echo '<li>';
    echo '<img src=image/'.$item['image'].' alt="'.$item['shohin_mei'].'">';
    echo '<p>動画名: '.$item['shohin_mei'].'</p>';
    // 画像にリンクを設定する
    echo '<a href="'.$item['pv'].'"target="_blank">動画を見る</a>';
    echo '<form action="review" method="get">'; // レビュー
    echo '<div class="review"><p>';
    echo '<input type="hidden" name="shohin_id" value="' . $item['shohin_id'] . '">';
    echo '<input type="submit" value="レビューを見る">';
    echo '</p></div>';
    echo '</form>';
    echo '</li>';
    echo '</ul>';
    echo '</div>';
    echo '</td>';
   
    if($i%3==0){
          echo '</tr>';
          echo '<tr>';
          $i=$i+1;
    }else{
        $i=$i+1;
    }
}
echo '</tr>';
echo '</tbody>';
echo '</table>';
?>
  
</div>
</body>
</html>