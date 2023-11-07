<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php require 'header.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品検索画面</title>
</head>
<body>
    <form action="search-result.php" method="get">
        商品検索
    <input type="text" name="keyword">
    <input type="submit" value="検索">
</form>

<?php
    $a=$_SESSION['customer']['genre'];
    $pdo=new PDO($connect,USER,PASS);
    $sql=$pdo->prepare('select * from eiga where genre LIKE ? ORDER BY RAND() LIMIT 4');
    $sql->execute(["%$a%"]);
    echo '<h3>あなたへのおすすめ</h3>';
    foreach($sql as $row){
        echo '<a href="detail.php?id=',$row['shohin_id'],'">',$row['shohin_mei'];
        echo '<img src="image/'.$row['image'].'" alt="'.$row['shohin_mei'].'">'.'</a>';
    }
    require 'menu.php';
?>
</body>
</html>