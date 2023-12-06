<?php
session_start();
require 'db-conect.php';
$movie_id=$_GET['shohin_id'];
$pdo=new PDO($connect,USER,PASS);
//映画の詳細を取得
$stmt=$pdo->prepare('select * from eiga where shohin_id=?');
$stmt->execute([$movie_id]);
$movie=$stmt->fetch(PDO::FETCH_ASSOC);
//ページネーション機能レビューのページ数を取得しレビュー表示数、オフセットを設定
$page=isset($_GET['page']) ? $_GET['page'] : 1;
$set=($page-1)*10;
//ページネーション機能の表示
$stmt=$pdo->prepare('select * from review INNER JOIN customer ON review.client_id=customer.client_id 
                    where shohin_id=? LIMIT ? OFFSET ?');
$stmt->bindParam(1,$movie_id,PDO::PARAM_INT);
$stmt->bindValue(2,10,PDO::PARAM_INT);
$stmt->bindValue(3,$set,PDO::PARAM_INT);
$stmt->execute();
//ページ数の計算
$reviews=$stmt->fetchAll(PDO::FETCH_ASSOC);
$total_reviews=$pdo->prepare('select count(*) from review WHERE shohin_id=?');
$total_reviews->execute([$movie_id]);
$total_reviews=$total_reviews->fetchColumn();
$total_pages=ceil($total_reviews/10);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../styles/review.css" rel="stylesheet">
        <title><?php echo $movie['shohin_mei'] ; ?>レビュー</title>
</head>
<body>
<div class="heder">
    <img src="../img/sinki.jpg">
    <?php require 'menu.php';?>
    <form action="detail.php" method="get">
        <div class="rog">
        <button type="submit">ひとつ前に戻る</button><div>
</div>
<div class="review1">
<h1>レビュー</h1>
</div>
 <?php if(count($reviews)>0):?>
    <?php foreach($reviews as $review):?>
        <div class="review">
                評価(☆): <?php echo $review['star']; ?>/5
                投稿者: <?php echo $review['name']; ?>
                <p>レビュー: <?php echo $review['comment']; ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>この商品にはまだレビューがありません。</p>
    <?php endif; ?>
    <div class="pagination">
        <?php if ($page>1): ?>
            <a href="review.php?shohin_id=<?php echo $movie_id; ?>&page=<?php echo ($page - 1); ?>">前のページ</a>
        <?php endif; ?>
        <?php for ($i=1;$i<=$total_pages;$i++): ?>
            <a href="review.php?shohin_id=<?php echo $movie_id; ?>&page=<?php echo $i; ?>"><?php echo $i;?></a>
        <?php endfor; ?>
        <?php if ($page<$total_pages): ?>
            <a href="review.php?shohin_id=<?php echo $movie_id; ?>&page=<?php echo ($page + 1); ?>">次のページ</a>
        <?php endif; ?>
        <form action="review-output.php" method="get">
            <input type="hidden" name="shohin_id" value="<?php echo $movie['shohin_id']; ?>">
            <div class="submit">
            <input type="submit" style="width: auto;padding:20px;font-size:20px;background: red;" value="レビューを書く"></div>
        </form>
    </div>
</body>
</html>