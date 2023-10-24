<?php session_start();?>
<?php
    const SERVER='mysql218.phy.lolipop.lan';
    const DBNAME='LAA1517813-asoateam';
    const USER='LAA1517813';
    const PASS='Pasuwado';
    $connect = 'mysql:host='.SERVER.';dbname='.DBNAME.';charset=utf8';
?>
<!DOCTYPE html>

<html lang="en">
<head> 
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/search.css" rel="stylesheet">
    <title>検索画面</title>
</head>
<body>
 <div class="wrap">
   
    <div class="img">
    <img src="img/rogo.jpg" alt="rogo" title="rogo"></div>

    
   <div class="name1">
   検索</div>
   <script>
       function enter(){
         if( window.event.keyCode == 13 ){
            document.form1.submit();
        }
        }
    </script>
    <form name="formname" action="search.php" method="post">
        <div class="kensaku">
        <input type="text" name="keyword" size="100" onkeypress="enter();"><br></div>
    </form>

    <div class="osusume">
   あなたへのおすすめ</div>
  


    <?php
        //映画画像の表示
        for($i=1;$i<=5;$i++){
            echo '<div class="gazou',$i,'">';
            echo '<a href="login.php"><img src="img/rogo.jpg" alt="商品詳細ページへ"  title="rogo"></a>';
            echo '</div>';
        }
    ?>
  
  <?php require 'menu.html';?>
</div>
</body>
</html>