<?php session_start();?>
<?php require 'db-conect.php'; ?>
<?php require 'header.php'; ?>
<?php require 'menu.php';?>
<!DOCTYPE html>

<html lang="en">
<head> 
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/search2.css" rel="stylesheet">
    <title>検索画面</title>
</head>
<body>
 <div class="wrap">
    
   <div class="name1">
   検索</div>
   <script>
       function enter(){
         if( window.event.keyCode == 13 ){
            document.form1.submit();
        }
        }
    </script>
    <form name="formname" action="search-result.php" method="get">
        <div class="kensaku">
        <input type="text" name="keyword" size="100" onkeypress="enter();"><br></div>
    </form>

    <?php
        $keyword=$_GET['keyword'];
        $pdo=new PDO($connect,USER,PASS);
        $sql=$pdo->prepare('select * from eiga where shohin_mei LIKE ?');
        $sql->execute(["%$keyword%"]);

        echo '<h3>検索結果</h3>';
        if($sql->rowCount()>0){
            //映画画像の表示
            foreach($sql as $row){
                echo '<div class="gazou1">';
                echo '<a href="detail.php?id=',$row['shohin_id'],'">';
                echo '<img src="image/'.$row['image'].'" alt="'.$row['shohin_mei'].'"></a>';
                echo '</div>';
                echo '<div class="name2">';
                echo '<a href="detail.php?id=',$row['shohin_id'],'">',$row['shohin_mei'];
                echo '</div>';
            }
        }else{
            echo '<p>お探しの商品はございません</p>';
        }
            /* for($i=1;$i<=5;$i++){
            echo '<div class="gazou',$i,'">';
            echo '<a href="login.php"><img src="img/rogo.jpg" alt="商品詳細ページへ"  title="rogo"></a>';
            echo '</div>';
        } */
    ?>
  
 
</div>
</body>
</html>