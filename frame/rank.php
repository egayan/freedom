<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php require 'header.php'; ?>
<?php
$pdo=new PDO($connect,USER,PASS);
$stmt=$pdo->query('SELECT purchase.shohin_id,SUM(amount_spent) AS total ,image FROM purchase
                    JOIN eiga ON  purchase.shohin_id=eiga.shohin_id GROUP BY purchase.shohin_id ORDER BY total DESC LIMIT 10');
$ranking=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/rank.css" rel="stylesheet">
    <title>売上ランキング</title>
</head>
<body>
<?php require 'menu.php';?>
 <!-- 画像をクリックしたら詳細画面に飛ぶ -->
 <div class="warp">
    <h1>売上ランキング</h1>
            <div class="z"><P>順位</p></div> <div class="f"><p>商品</p></div>
        <?php foreach($ranking as $key => $rank):?>
       
            
            <p><?php echo $key+1;?>位</p>
        
            <a href="detail.php?id=<?php echo $rank['shohin_id'];?>">
            
            <image src="img/<?php echo $rank['image'];?>" alt="商品画像"class="g"></a>
    <?php endforeach;?>
  
 </div>
</body>
</html>