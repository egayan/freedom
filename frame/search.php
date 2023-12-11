<?php session_start();
require 'header.php'; 
require 'menu.php';
require 'db-conect.php';
$pdo=new PDO($connect,USER,PASS);

//誕生日関連
if(!isset($_SESSION['customer']['first_login'])){
    $stmt=$pdo->prepare('SELECT MONTH(birthday) FROM customer WHERE client_id=?');
    $stmt->execute([$_SESSION['customer']['client_id']]);
    $birthday_month=$stmt->fetch(PDO::FETCH_COLUMN);
    $month=date('n');
    //最後の日付
    $stmt = $pdo->prepare('SELECT MONTH(receive_day) FROM customer WHERE client_id=?');
    $stmt->execute([$_SESSION['customer']['client_id']]);
    $lastMonth=$stmt->fetch(PDO::FETCH_COLUMN);
    if($month==$birthday_month){
        $coupon=1;
    }else{
        $coupon=2;
    }
    $last_day=date('Y-m-t H:i:s');
    $_SESSION['customer']['first_login']=true;
    if($lastMonth!=$month){
    //更新処理
    $sql=$pdo->prepare('UPDATE customer SET coupon_id=?,date_expiry=?,use_frag=0 WHERE client_id=?');
    $sql->execute([$coupon,$last_day,$_SESSION['customer']['client_id']]);
    echo '<script>';
    echo 'window.onload = function() {'; // ページの読み込み後に実行
    echo '  alert("クーポンを取得しました！");'; // アラートポップアップ表示
    echo '}';
    echo '</script>';
    }
//     // クーポン情報をデータベースから取得
// $stmt = $pdo->prepare('SELECT coupon_name FROM coupon WHERE coupon_id = ?');
// $stmt->execute([$coupon]);
// $couponInfo = $stmt->fetch(PDO::FETCH_ASSOC);
}
//履歴処理
$sql=$pdo->prepare('UPDATE customer SET receive_day=CURRENT_TIMESTAMP WHERE client_id=?');
$sql->execute([$_SESSION['customer']['client_id']]);
// ジャンル情報を取得
$sql_genre = $pdo->prepare('SELECT g.genre_name FROM customer_genre cg
                           JOIN genre g ON cg.genre_id = g.genre_id
                           WHERE cg.client_id = ?');
$sql_genre->execute([$_SESSION['customer']['client_id']]);
$customer_genre = $sql_genre->fetch(PDO::FETCH_COLUMN);
?>
<link rel="stylesheet" href="styles/search.css">
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品検索画面</title>
</head>
<body>
    <form action="search-result.php" method="get">
        <div class="name1"><font size=40><b>商品検索</b></font><div>
    <input type="text" name="keyword" class="kensaku">
    <input type="submit" value="検索" class="kennsabotan">
</form>

<?php
    // お気に入り
    $sql_search = $pdo->prepare('SELECT e.* FROM eiga e
                            JOIN shohin_genre eg ON e.shohin_id = eg.shohin_id
                            JOIN customer_genre cg ON eg.genre_id = cg.genre_id
                            WHERE cg.client_id = ? AND e.genre LIKE ?
                            ORDER BY RAND()
                            LIMIT 4');
    $sql_search->execute([$_SESSION['customer']['client_id'], "%$customer_genre%"]);
    
    $i=1;
     echo '<div class="osusume"><font size=40><b>あなたへのおすすめ</b></font><div>';
    foreach($sql_search as $row){
    $a=$_SESSION['customer']['genre'];
    $sql=$pdo->prepare('select * from eiga where genre LIKE ? ORDER BY RAND() LIMIT 4');
    $sql->execute(["%$a%"]);
   
    }
    foreach($sql as $row){
        echo '<br><a href="detail.php?id=',$row['shohin_id'],'">',$row['shohin_mei'],"<div>";
        echo '<div class="gazou',$i,'"><img src="image/'.$row['image'].'" alt="'.$row['shohin_mei'].'"class="san">'.'</a>';
        $i++; 
    }
?>
</body>
</html>