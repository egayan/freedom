<?php require 'db-conect.php';
    $pdo=new PDO($connect, USER, PASS);
    $sql =$pdo->query("SELECT genre_id,genre_name FROM genre");
    $sql=$sql->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link href="styles/adomin_product.css" rel="stylesheet">
    <title>商品登録画面</title>
</head>
<body>
    <div class="c">
        <form action="admin.php" method="post" onsubmit="return validateForm()">
            <h1>商品登録画面</h1>
            <div class="namae">商品名<br></div>
            <input type="text"  class="name" name="shohin_mei" size="50" required><br>
            <div class="me-riadoresu">商品説明<br></div>
            <input type="text" class="address" name="explanation" size="50" required><br>
            <div class="denwabangou">単価<br></div>
            <input type="text" class="phone" name="price" size="50" required><br>
            <div class="pasuwa-do">画像<br></div>
            <input type="text" class="password" name="image" size="50" required><br>
            <div class="seinegappi"> 時間<br></div>
            <input type="text" class="birthday" name="time" size="50" required><br>
            <div class="ganru">ジャンル<br><br>
            <?php
            $i=0;
            echo'<div class="kategori">';
            foreach ($sql as $genre) {
                echo '<div class="zyanru',$i,'">';
                echo '<input type="checkbox" name="genre[]" value="'.$genre['genre_id'].'">'.$genre['genre_name'].'<br>';
                echo '</div>';
                $i++;
            }
            echo '</div>';
            ?>
            <div class="pv">PV<br></div>
            <input type="text" class="pvin" name="pv" size="50" required><br>
             <div class="sousinn"><button type="submit" name="insert">登録</button></div>
            
        </form>
        <form action="admin.php" method="post">
        <div class="rog"> <button type="submit">戻る</button><div>
        </form>
    </div>
    <script src="js/admin_product.js"></script>
</body>
</html>