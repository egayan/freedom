<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php
$move_id=$_GET['id'];
$pdo=new PDO($connect,USER,PASS);
$stmt=$pdo->prepare("select * from eiga WHERE shohin_id=?");
$stmt->execute([$move_id]);
$movie = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/detail.css" rel="stylesheet">
<title><?php echo $movie['shohin_mei'] ; ?>詳細</title>
</head>
<body>
<div class="wrap">
<div class="mei"><?php echo $movie['shohin_mei']; ?></div>
        <div class="syou"><img src="image/<?php echo $movie['image']; ?>" alt="<?php echo $movie['shohin_mei']; ?>"></div>
        <div class="ryoukin"><?php echo "料金：",$movie['price'],"円"; ?> </div>
        <div class="zikan"><?php echo $movie['time']; ?> </div>	
        <div class="mozi"><?php echo $movie['explanation']; ?> </div>

        <?php
        echo '<form action="cart-insert.php" method="post">';
        echo '<input type="hidden" name="id" value="',$movie['shohin_id'],'">';
        echo '<input type="hidden" name="name" value="',$movie['shohin_mei'],'">';
        echo '<input type="hidden" name="price" value="',$movie['price'],'">';
        echo '<input type="hidden" name="image" value="',$movie['image'],'">';
        echo '<div class="kato"><p><input type="submit" value="カートに追加"></p></div>';
        echo '</form>';
        ?>
        </div>
        <form action="review" method="post">
        <input type="hidden" name="shohin_id" value="<?php echo $movie['shohin_id']; ?>">
            <input type="submit" value="レビューを見る">
        </form>
        </body>

</html>
