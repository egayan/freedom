<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php ob_start();?>
<?php
    $adminUsername='admin';
    $adminPassword='admin_paddword_hash';
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