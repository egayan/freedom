<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php
$move_id=$_GET['id'];
$customer_id = $_SESSION['customer']['client_id'];
$pdo=new PDO($connect,USER,PASS);
$stmt=$pdo->prepare("select * from eiga WHERE shohin_id=?");
$stmt->execute([$move_id]);
$movie = $stmt->fetch(PDO::FETCH_ASSOC);
// 購入済みかどうかの判定
$stmt = $pdo->prepare("SELECT COUNT(*) FROM purchase WHERE shohin_id = ? AND client_id = ?");
$stmt->execute([$move_id, $customer_id]);
$purchase = $stmt->fetchColumn();

// レビュー済みかどうかの判定
$stm=$pdo->prepare("SELECT COUNT(*) FROM review WHERE shohin_id = ?");
$stm->execute([$move_id]);
$rankcount = $stm->fetchColumn();
$avgrank=0;
if($rankcount>0){
//平均評価
$avg=$pdo->prepare("SELECT AVG(star) as average FROM review WHERE shohin_id = ?");
$avg->execute([$move_id]);
$avg=$avg->fetch(PDO::FETCH_ASSOC)['average'];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/detail.css">
<title><?php echo $movie['shohin_mei'] ; ?>詳細</title>
</head>
<body>
<div class="wrap">
<div class="mei"><?php echo $movie['shohin_mei']; ?></div>
        <div class="syou"><img src="image/<?php echo $movie['image']; ?>" alt="<?php echo $movie['shohin_mei']; ?>"></div>
        <div class="ryoukin"><?php echo "料金：",$movie['price'],"円"; ?> </div>
        <div class="zikan"><?php echo $movie['time']; ?> </div>	
        <div class="mozi"><?php echo $movie['explanation']; ?> </div>

        <?php if($rankcount>0):?>
        <p>平均評価: <?php echo number_format($avg, 1); ?> / 5</p>
        <?php else: ?>
            <p>レビューはまだありません</p>
        <?php endif;?>
        <?php
        if($purchase===0){
            echo '<form action="cart-insert.php" method="post">';
            echo '<input type="hidden" name="id" value="',$movie['shohin_id'],'">';
            echo '<input type="hidden" name="name" value="',$movie['shohin_mei'],'">';
            echo '<input type="hidden" name="price" value="',$movie['price'],'">';
            echo '<input type="hidden" name="image" value="',$movie['image'],'">';
            echo '<div class="kato"><p><input type="submit" value="カートに追加"></p></div>';
            echo '</form>';
        }else{
            echo '購入済みです';
        }
        echo '<form action="review" method="get">'; // レビュー
        echo '<div class="review"><p>';
        echo '<input type="hidden" name="shohin_id" value="' . $movie['shohin_id'] . '">';
        echo '<input type="submit" value="レビューを見る">';
        echo '</p></div>';
        echo '</form>';
        ?>
        </body>
</html>
