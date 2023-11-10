<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php require 'header.php'; ?>
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
    <link rel="stylesheet" href="styles/genre.css">
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
    <?php foreach($movies as $movie): ?>
        <a href="detail.php?id=<?php echo $movie['shohin_id']; ?>">
           <div class="sum"> <img src="image/<?php echo $movie['image']; ?>" alt="<?php echo $movie['shohin_mei']; ?>"></div>
        </a><br><?php echo $movie['shohin_mei']; ?>
        <?php endforeach; 
        }
    ?>
</body>
<?php require 'menu.php'; ?>
</html>
