<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php require 'header.php'; ?>
<?php
$pdo=new PDO($connect,USER,PASS);
// 週間売り上げの取得
$weeklyStmt = $pdo->prepare('SELECT purchase.shohin_id, SUM(amount_spent) AS total, image
                             FROM purchase
                             JOIN eiga ON purchase.shohin_id = eiga.shohin_id
                             WHERE purchase.purchase_date >= CURDATE() - INTERVAL 1 WEEK
                             GROUP BY purchase.shohin_id
                             ORDER BY total DESC
                             LIMIT 10');
$weeklyStmt->execute();
$weeklyRanking = $weeklyStmt->fetchAll(PDO::FETCH_ASSOC);

// 全体売り上げの取得
$totalStmt = $pdo->prepare('SELECT purchase.shohin_id, SUM(amount_spent) AS total, image
                            FROM purchase
                            JOIN eiga ON purchase.shohin_id = eiga.shohin_id
                            GROUP BY purchase.shohin_id
                            ORDER BY total DESC
                            LIMIT 10');
$totalStmt->execute();
$totalRanking = $totalStmt->fetchAll(PDO::FETCH_ASSOC);
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
    <button id="toggleButton" onclick="toggleRanking()">切り替え</button>
    <h1 id="rankingTitle">週間売上ランキング</h1>
    <table id="rankingList">
        <tr>
            <th>順位</th><th>商品</th>
        </tr>
        <!-- 週間ランキングの内容をここに追加 -->
        <?php foreach($weeklyRanking as $key => $rank):?>
        <tr>
            <td><?php echo $key+1;?>位</td>
            <td><a href="detail.php?id=<?php echo $rank['shohin_id'];?>">
            <image src="img/<?php echo $rank['image'];?>" alt="商品画像"></a></td>
        </tr>
        <?php endforeach;?>
    </table>
    <!-- 総合ランキングの内容も同様に追加 -->
    <table id="totalRankingList" style="display:none;">
        <tr>
            <th>順位</th><th>商品</th>
        </tr>
        <?php foreach($totalRanking as $key => $rank):?>
        <tr>
            <td><?php echo $key+1;?>位</td>
            <td><a href="detail.php?id=<?php echo $rank['shohin_id'];?>">
            <image src="img/<?php echo $rank['image'];?>" alt="商品画像"></a></td>
        </tr>
        <?php endforeach;?>
    </table>
    <?php require 'menu.php';?>
   <script>
        let isWeekly=true;
        document.getElementById('toggleButton').addEventListener('click', toggleRanking);

        function toggleRanking(){
            console.log('Button clicked');
            isWeekly = !isWeekly;
            showRanking();
        }

        function showRanking(){
            const weeklyElement = document.getElementById('rankingList');
            const totalElement = document.getElementById('totalRankingList');
            const titleElement = document.getElementById('rankingTitle');
            if(isWeekly){
                weeklyElement.style.display = 'table';
                totalElement.style.display = 'none';
                titleElement.innerHTML = '週間ランキング';
            }else{
                weeklyElement.style.display = 'none';
                totalElement.style.display = 'table';
                titleElement.innerHTML = '総合ランキング';
            }
        }
        // 最初に週間売上を表示
        showRanking();
    </script>
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