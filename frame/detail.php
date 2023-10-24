<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php require 'header.php'; ?>
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
<title><?php echo $movie['shohin_mei'] ; ?>詳細</title>
</head>
<body>
<?php echo $movie['shohin_mei']; ?>
        <img src="image/<?php echo $movie['image']; ?>" alt="<?php echo $movie['shohin_mei']; ?>">
        <?php
        echo '<form action="cart-insert.php" method="post">';
        echo '<input type="hidden" name="id" value="',$movie['shohin_id'],'">';
        echo '<input type="hidden" name="name" value="',$movie['shohin_mei'],'">';
        echo '<input type="hidden" name="price" value="',$movie['price'],'">';
        echo '<input type="hidden" name="image" value="',$movie['image'],'">';
        echo '<p><input type="submit" value="カートに追加"></p>';
        echo '</form>';
        ?>
        </body>
<?php require 'menu.php'; ?>
</html>
