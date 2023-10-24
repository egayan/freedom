<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php require 'header.php'; ?>
<?php
$pdo=new PDO($connect,USER,PASS);
$stmt=$pdo->query("select * from eiga");
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
foreach($movies as $movie){
    $genre[$movie['genre']][] = $movie;
}
?>
<?php foreach($genre as $key => $value): ?>
    <h2><?php echo $key; ?></h2>
    <?php foreach($value as $movie): ?>
        <a href="detail.php?id=<?php echo $movie['shohin_id']; ?>">
           <div class="sum"> <img src="image/<?php echo $movie['image']; ?>" alt="<?php echo $movie['shohin_mei']; ?>"></div>
        </a><br><?php echo $movie['shohin_mei']; ?>

        <?php endforeach; ?>
    <?php endforeach; ?>
</body>
<?php require 'menu.php'; ?>
</html>
