<?php require 'db-conect.php'; ?>
    <?php
    $pdo=new PDO($connect, USER, PASS);
    $sql ="SELECT * FROM eiga";

    if ($_POST) {
        if (isset($_POST['update'])){
            $id = $_POST['id'];
            $stmt = $pdo->prepare('UPDATE eiga SET shohin_mei=:name,explanation=:ex,price=:price,image=:gazou,time=:time,pv=:pv
            WHERE shohin_id=:id');
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':time', $_POST['time']);
            $stmt->bindValue(':pv', $_POST['pv']);
            $stmt->bindValue(':name', $_POST['name']);
            $stmt->bindValue(':ex', $_POST['ex']);
            $stmt->bindValue(':price', $_POST['price']);
            $stmt->bindValue(':gazou', $_POST['gazou']);
            $stmt->execute();
        }else if(isset($_POST['delete'])){
            $id=$_POST['id'];
            // 商品ジャンルテーブルから削除
            $stmt_genre = $pdo->prepare('DELETE FROM shohin_genre WHERE shohin_id = :id');
            $stmt_genre->bindValue(':id', $id);
            $stmt_genre->execute();
        
            // 商品テーブルから削除
            $stmt_product = $pdo->prepare('DELETE FROM eiga WHERE shohin_id = :id');
            $stmt_product->bindValue(':id', $id);
            $stmt_product->execute();
        }elseif (isset($_POST['insert'])) {
            foreach ($_POST['genre'] as $sgenre) {
                // ジャンルIDからジャンル名を取得
                $genre=$pdo->prepare('SELECT genre_name FROM genre WHERE genre_id = :genre_id');
                $genre->bindValue(':genre_id',$sgenre);
                $genre->execute();
                $genreId=$genre->fetchColumn();
                $a[]=$genreId;
            }
                $stmt = $pdo->prepare('INSERT INTO eiga (shohin_mei, explanation, price,image,time,pv,genre) 
                VALUES (:name,:ex,:price,:image,:time,:pv,:genre)');
                $stmt->bindValue(':name', $_POST['shohin_mei']);
                $stmt->bindValue(':ex', $_POST['explanation']);
                $stmt->bindValue(':price', $_POST['price']);
                $stmt->bindValue(':image', $_POST['image']);
                $stmt->bindValue(':time', $_POST['time']);
                $stmt->bindValue(':pv', $_POST['pv']);
                $stmt->bindValue(':genre',implode(' ',$a));
                $stmt->execute();
                
            //商品ジャンルテーブル挿入
            $insert_id=$pdo->lastInsertId();
            foreach ($_POST['genre'] as $sgenre) {
                $stm = $pdo->prepare('INSERT INTO shohin_genre (shohin_id, genre_id) VALUES (:shohin_id, :genre_id)');
                $stm->bindValue(':shohin_id',$insert_id);
                $stm->bindValue(':genre_id', $sgenre);
                $stm->execute();
            }
        }
    }
    $stmt =$pdo->query($sql);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者用/商品一覧画面</title>
    <style>  
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
        <h1>商品一覧画面</h1>
        <form action="admin_product.php" method="post">
            <button type="submit">新規登録</button></form>
            <a href="login.php"  style="margin-left:1200px">ログアウト</a>
            <div class="c">
        <table border="1" >  
        <tr>
                <th>ID</th>
                <th>商品名</th>
                <th>商品説明</th>
                <th>単価</th>
                <th>画像</th>
                <th>時間</th>
                <th>ジャンル</th>
                <th>pv</th>
                <th colspan="2">操作</th>  
        </tr>

            <?php
            foreach ($stmt as $row) {
                echo '<tr>';
                echo '<td>', $row['shohin_id'], '</td>';
                echo '<td>', $row['shohin_mei'], '</td>';
                echo '<td>', $row['explanation'], '</td>';
                echo '<td>', $row['price'], '円','</td>';
                echo '<td><img src="image/'.$row['image'].'"alt="'.$row['shohin_mei'].'" width="80"></td>';
                echo '<td>', $row['time'], '</td>';
                echo '<td>', $row['genre'], '</td>';
                echo '<td>', $row['pv'], '</td>';
                echo '<td>';
                ?>
                <button onclick="change(this)">表示</button>
                <form id="disp" class=hidden action="" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['shohin_id']; ?>">
                    <input type="text" name="name" value="<?php echo $row['shohin_mei']; ?>"placeholder="商品名"><br>
                    <input type="text" name="ex" value="<?php echo $row['explanation']; ?>"placeholder="説明"><br>
                    <input type="text" name="price" value="<?php echo $row['price']; ?>"placeholder="単価"><br>
                    <input type="text" name="gazou" value="<?php echo $row['image']; ?>"placeholder="画像パス"><br>
                    <input type="text" name="time" value="<?php echo $row['time']; ?>"placeholder="時間"><br>
                    <input type="text" name="genre" value="<?php echo $row['genre']; ?>"placeholder="ジャンル"><br>
                    <input type="text" name="pv" value="<?php echo $row['pv']; ?>"placeholder="pv"><br>
                    <button type="submit" name="update">更新</button>
                </form>
            </td>
            <td>
            <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['shohin_id']; ?>">
            <button type="submit" name="delete" class="delete-button">削除</button>
            </form>
                <?php                
                echo '</td>';
                echo '</tr>'; 
                echo "\n";
            }
            ?>
                </td>
            </tr>
        </table>
    </div>
        <!-- ログアウトリンク -->
    </div>
    <script src="js/admin.js"></script>
</body>
</html>
