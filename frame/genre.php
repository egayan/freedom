<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php require 'header.php'; ?>
<?php require 'menu.php'; ?>
<?php
$pdo=new PDO($connect,USER,PASS);
$gstmt=$pdo->query("select * from genre");
$genres = $gstmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/genre.css?v=1.0.5">
<title>ジャンル一覧</title>
</head>
<body>
<?php
foreach($genres as $genre){
    $stmt=$pdo->prepare("select * from eiga JOIN shohin_genre ON eiga.shohin_id=shohin_genre.shohin_id WHERE genre_id=?");
    $stmt->execute([$genre['genre_id']]);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
    <h2><?php echo $genre['genre_name']; ?></h2>
    <div class="Container">
    <div class="Box-Container">
    <?php foreach($movies as $movie): 
        $img = $movie['image'];?>
        <a href="detail.php?id=<?php echo $movie['shohin_id']; ?>">
        <div class="Box">
        <img class="sum" src="image/<?php echo $img; ?>" alt="<?php echo $movie['shohin_mei'];?> ">
            </a>
        </div>
        <?php endforeach;?>
        </div>
    <div class="Arrow left"><</div>
    <div class="Arrow right">></div>
    </div>
        <?php
        }
        ?>    
<script src="js/genre.js"></script>
</body>
</html>
