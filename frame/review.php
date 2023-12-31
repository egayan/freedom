<?php
session_start();
require 'db-conect.php';
$movie_id=$_POST['shohin_id'];
$pdo=new PDO($connect,USER,PASS);
//映画の詳細を取得
$stmt=$pdo->prepare('select * from eiga where shohin_id=?');
$stmt->execute([$movie_id]);
$movie=$stmt->fetch(PDO::FETCH_ASSOC);
//ページネーション機能レビューのページ数を取得しレビュー表示数、オフセットを設定
isset($_POST['page']) ? $_POST['page'] : 1;
$page=10;
$set=($page-1)*$page;
//ページネーション機能の表示
$stmt=$pdo->prepare('select * from review where shohin_id=? LIMIT ? OFFSET ?');
$stmt->bindParam(1,$movie_id,PDO::PARAM_INT);
$stmt->bindParam(2,$page,PDO::PARAM_INT);
$stmt->bindParam(3,$set,PDO::PARAM_INT);
$stmt->execute();
//ページ数の計算
$reviews=$stmt->fetchAll(PDO::FETCH_ASSOC);
$total_reviews=$pdo->prepare('select count(*) from review WHERE shohin_id=?');
$total_reviews->execute([$movie_id]);
$total_reviews=$total_reviews->fetchColumn();
$total_pages=ceil($total_reviews/$page);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $movie['shohin_mei'] ; ?>レビュー</title>
</head>
<body>
    <img src="img/rogo.jpg">
    <p><a href=""><</a></p>
 <img src="image/<?php echo $movie['image']; ?>" alt="<?php echo $movie['shohin_id']; ?>">
 <?php if(count($reviews)>0):?>
    <?php foreach($reviews as $review):?>
        <div class="review">
                <p>投稿者: <?php echo $review['name']; ?></p>
                <p>評価(☆): <?php echo $review['star']; ?></p>
                <p>レビュー: <?php echo $review['comment']; ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>この商品にはまだレビューがありません。</p>
        
    <?php endif; ?>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="review.php?id=<?php echo $movie_id; ?>&page=<?php echo ($page - 1); ?>">前のページ</a>
        <?php endif; ?>
        <?php if ($page < $total_pages): ?>
            <a href="review.php?id=<?php echo $movie_id; ?>&page=<?php echo ($page + 1); ?>">次のページ</a>
        <?php endif; ?>
        <form action="review-output.php" method="get">
            <input type="hidden" name="shohin_id" value="<?php echo $movie['shohin_id']; ?>">
            <input type="submit" value="レビューを書く">
        </form>
    </div>
<?php require 'menu.php';?>
</body>
</html>