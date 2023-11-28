<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php ob_start();?>
<?php 
  if($_SERVER["REQUEST_METHOD"]=='POST'){
    $pdo=new PDO($connect,USER,PASS);
    $sql=$pdo->prepare('select * from customer where address=?');
    $sql->execute([$_POST['login']]);
    foreach($sql as $row){
      if(password_verify($_POST['password'],$row['password'])== true){
      $_SESSION['customer']=[
          'client_id'=>$row['client_id'],'name'=>$row['name'],
          'password'=>$row['password'],'address'=>$row['address'],
          'phone'=>$row['phone'],'birthday'=>$row['birthday'],'genre'=>$row['genre']
          ];
          session_write_close();
          header('Location: search.php');
          exit; 
      }
  }
  $message='ログイン名パスワードが違います。';
  }
?>

<!DOCTYPE html>
<html lang="en">
<head> 
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/login.css" rel="stylesheet">
    <title>ログイン画面</title>
</head>
<body>
<img src="img/sinki.jpg" alt="rogo" title="rogo" width: 160px;
    height: 160px;>
<?php 
if(isset($message)){
  echo $message;
}
?>
   <form action='login.php' method="post">  
   <div class="name1">
   メールアドレス<br></div>

  <input type="text" name="login"  class="name2"><br>

    <div class="pasu1">
    パスワード</div>

    <input type="password" name="password" class="pass2"><br>

    <input type="submit" value="ログイン"  class="rogu">
   </form>
   <form action='touroku.php' method="get">

   <input type="submit" value="新規登録の方はこちら"  class="sinki">
   </form>
   <a href=admin.php>管理者の方はこちら</a>
</body>
</html>
<?php ob_end_flush();?>
