<?php
session_start();
require 'db-conect.php';

// レビュー投稿処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shohin_id = $_POST['shohin_id'];
    $client_id = $_SESSION['customer']['client_id'];
    $star=$_POST['star'];
    $comment = $_POST['comment'];

    $pdo = new PDO($connect, USER, PASS);
    $stmt = $pdo->prepare('INSERT INTO review (shohin_id,client_id, star, comment) VALUES (?, ?, ?, ?)');
    $stmt->execute([$shohin_id, $client_id, $star,$comment]);

    // 投稿完了後、商品詳細ページに戻る
    header('Location: detail.php?id=' . $shohin_id);
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レビュー投稿</title>
<body>
    <img src="img/rogo.jpg">
    <p><a href=""><</a></p>
</head>
<body>
    <h1>レビュー投稿</h1>
    <form action="review-output.php" method="post">
        <input type="hidden" name="shohin_id" value="<?php echo $_GET['shohin_id']; ?>">
        <label for="star">評価（星）:</label>
        <select name="star" id="star">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <label for="content">レビュー内容:</label>
        <textarea id="comemnt" name="comment" rows="4" cols="50"></textarea>
        <input type="submit" value="投稿">
    </form>
   <?php require 'menu.php';?>
</body>
</html>