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
    <title>売上ランキング</title>
</head>
<body>
 <!-- 画像をクリックしたら詳細画面に飛ぶ -->
    <h1>売上ランキング</h1>
    <table>
        <tr>
            <th>順位</th><th>商品</th>
        </tr>
        <?php foreach($ranking as $key => $rank):?>
        <tr>
            <td><?php echo $key+1;?>位</td>
            <td><a href="detail.php?id=<?php echo $rank['shohin_id'];?>">
            <image src="img/<?php echo $rank['image'];?>" alt="商品画像"></a></td>
        </tr>
    </table>
    <?php endforeach;?>
   <?php require 'menu.php';?>
</body>
</html>