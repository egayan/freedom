<?php require 'db-conect.php';
    $pdo=new PDO($connect, USER, PASS);
    $sql =$pdo->query("SELECT genre_id,genre_name FROM genre");
    $sql=$sql->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品登録画面</title>
</head>
<body>
    <div class="c">
        <form action="admin.php" method="post" onsubmit="return validateForm()">
            <h1>商品登録画面</h1>
            商品名<br>
            <input type="text"  name="shohin_mei" size="50" required><br>
            商品説明<br>
            <input type="text"  name="explanation" size="50" required><br>
            単価<br>
            <input type="text"  name="price" size="50" required><br>
            画像<br>
            <input type="text"  name="image" size="50" required><br>
            時間<br>
            <input type="text"  name="time" size="50" required><br>
            ジャンル<br>
            <?php
            foreach ($sql as $genre) {
                echo '<input type="checkbox" name="genre[]" value="'.$genre['genre_id'].'">'.$genre['genre_name'].'<br>';
            }
            ?>
            PV<br>
            <input type="text"  name="pv" size="50" required><br>
            <button type="submit" name="insert">登録</button>
            
        </form>
        <form action="admin.php" method="post">
            <button type="submit">戻る</button>
        </form>
    </div>
    <script src="js/admin_product.js"></script>
</body>
</html>