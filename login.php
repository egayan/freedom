<?php session_start(); ?>
<?php require 'common/db-conect.php'; ?>
<?php require 'common/header.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="frame/styles/login.css" rel="stylesheet">
    <title>ログイン画面</title>
</head>
<body>
    <div class="img">
   <form action='login.php' method="GET">  
   <div class="name1">
   メールアドレスまたは電話番号</div>

   <div class="name2">
   <input type="text" name="address"><br>
    </div>

<div class="pasu1">
    パスワード</div>

    <div class="pass2">
    <input type="password" name="password"><br></div>

    <div class="rogu">
    <input type="submit" value="ログイン"></div>
   </form>
   <form action='touroku.php' method="GET">
   <div class="sinki">
   <input type="submit" value="新規登録の方はこちら"></div>
   
   <?php
        unset($_SESSION['customer']);
        $pdo=new PDO($connect,USER,PASS);
        $sql=$pdo->prepare('select * from customer where address=?');
        $sql->execute([$_GET['address']]);
        foreach($sql as $row){
            if(password_verify($_GET['password'],$row['password']) == true){
            $_SESSION['customer']=[
                'id' =>$row['client_id'],'name' =>$row['name'],
                'password'=>$row['password'],'address'=>$row['address'],
                'phone'=>$row['phone'],'birthday'=>$row['birthday'],
                'genre'=>$row['genre']];
                }
            } 
            //50~57赤文字
    if(empty($login)){
        echo '<p>','メールアドレス又は電話番号を入力してください。','</p>';
    }
    if(empty($password)){
        echo '<p>','パスワードを入力してください。','</p>';
    }
    if(empty($password && $login)){
        echo '<p>','メールアドレスとパスワードを入力してください。','</p>';
    }
    ?>
   </form>
</body>
</html>