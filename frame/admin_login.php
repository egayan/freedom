<?php require 'db-conect.php'; ?>
<?php ob_start();?>
<?php 
  if($_SERVER["REQUEST_METHOD"]=='POST'){
    $pdo=new PDO($connect,USER,PASS);
    $sql=$pdo->prepare('select * from admin where admin_name=?');
    $sql->execute([$_POST['name']]);
    $bool=false;
    foreach($sql as $row){
      if(password_verify($_POST['password'],$row['admin_password'])== true){
        $bool=true;
        break;
      }
    }
    if($bool==true){
      header('Location: admin.php');
      exit; 
    }else{
      $message='ログイン名パスワードが違います。';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/login.css" rel="stylesheet">
    <title>管理者用ログイン画面</title>
</head>
<body>
<img src="img/sinki.jpg" alt="rogo" title="rogo" width: 160px;
    height: 160px;>
<?php 
if(isset($message)){
  echo $message;
}
?>
   <form action='' method="post">  
   <div class="name1">
   管理者名<br></div>
  <input type="text" name="name"  class="name2"><br>

    <div class="pasu1">
    パスワード</div>
    <input type="password" name="password" class="pass2"><br>

    <input type="submit" value="ログイン"  class="rogu">
   </form>
</body>
</html>
<?php ob_end_flush();?>
