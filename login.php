<?php session_start(); ?>
<?php require 'db-conect.php'; ?>>
    
<?php 
  if($_SERVER["REQUEST_METHOD"]=='POST'){
    $pdo=new PDO($connect,USER,PASS);
    $sql=-$pdo->prepare('select * from customer where address=?');
    $sql->execute([$_POST['login']]);
    foreach($sql as $row){
      if(password_verify($_POST['password'],$row['password'])== true){
      $_SESSION['movie']=[
          'client_id'=>$row['id'],'name'=>$row['name'],
          'password'=>$row['password'],'address'=>$row['address'],
          'phone'=>$row['phone'],'birthday'=>$row['birthday'],'genre'=>$row['genre']
          ];
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
  <div class="wrap">
   
    <div class="img">
    <img src="img/rogo.jpg" alt="rogo" title="rogo"></div>
<?php 
if(isset($message)){
  echo $error;
}
?>
   <form action='login.php' method="post">  
   <div class="name1">
   メールアドレス<br></div>

   <div class="name2">
  <input type="text" name="login"><br></div>

    <div class="pasu1">
    パスワード</div>

    <div class="pass2">
    <input type="password" name="password"><br></div>

    <div class="rogu">
    <input type="submit" value="ログイン"></div>
   </form>
   <form action='touroku.php' method="get">
   <div class="sinki">
   <input type="submit" value="新規登録の方はこちら"></div>
   </form>
   
</div>
</body>
</html>