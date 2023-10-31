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
    <link href="css/search2.css" rel="stylesheet">
    <title>検索画面</title>
</head>
<body>
 <div class="wrap">
   
    <div class="img">
    <img src="img/rogo.jpg" alt="rogo" title="rogo"></div>


   <script>
       function enter(){
         if( window.event.keyCode == 13 ){
            document.form1.submit();
        }
        }
    </script>
    <form name="formname" action="search.php" method="post">
        <div class="kensaku">
        <input type="text" name="keyword" size="100" placeholder="検索" onkeypress="enter();"><br></div>
    </form>

    <div class="kekka">
   結果</div>
   <div class="img2"><img src="img/rogo.jpg"></div><div class="name2">映画名</div><br>
   <?php require 'menu.php';?>
</div>
</body>
</html>