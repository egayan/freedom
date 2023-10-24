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
    <link rel="stylesheet" href="css/search.css">
    <title>検索結果</title>
</head>
<body>
<form action = "result.php" method="post">
    <div>
        <div>検索</div>
        
    <div><input type="search" name="search" value="" placeholder="🔎"><br></div>
</form>
<div>あなたへのおすすめ</div>
<?php
foreach($movies as $movie){
    $genre[$movie['genre']][] = $movie;
}
?>

<?php foreach($genre as $key => $value){
    $split = explode(",",$value);
    if($split equals($costomer['genre'])){ ?>
    <h2><?php echo $key; ?></h2>
    <?php foreach($value as $movie);?>
        <a href="detail.php?id=<?php echo $movie['shohin_id']; ?>">
            <img src="image/<?php echo $movie['image']; ?>" alt="<?php echo $movie['shohin_mei']; ?>"></a><br>
            <?php echo $movie['shohin_mei']; };
        }; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
    </div>
</body>
<?php require 'common/menu.php'; ?>
</html>