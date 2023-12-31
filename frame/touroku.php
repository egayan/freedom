<?php session_start(); ?>
<?php require 'db-conect.php'; ?>
<?php ob_start();?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/touroku.css" rel="stylesheet">
    <title>新規登録画面</title>
</head>
<?php
$a=array("スポーツ","アニメ","アクション","アドベンチャー","青春","ファンタジー","コメディ","ホラー","ミステリ－","ドラマ","サスペンス","ロマンス","ファミリー","ドキュメンタリー","SF");
$b=count($a);
?>
<body>
<div class="wrap">
    <form action="touroku.php" method="post">

        <div class="namae">
    名前</div>
    <input type="text" name="name" class="name">
    

    <div class="me-riadoresu">
    メールアドレス </div>
    <input type="email" name="address" class="address">

    <div class="denwabangou">
    電話番号 </div>
    <input type="tel" name="phone" class="phone">

    <div class="pasuwa-do">
    パスワード</div>
    <input type="password" name="password" class="password">
    

    <div class="seinegappi">
    生年月日 </div>
    <input type="date" name="birthday"  class="birthday"> 
 

    <div class="ganru">
    好きなジャンル</div>

    <div class="kategori">
    <?php
    for($i = 0; $i<$b ; $i++){
        echo '<div class="zyanru',$i,'">';
        echo '<input type="checkbox" name="genre[]" value="',$a[$i],'">',$a[$i],'<br>';
        echo '</div>';
    }
    ?></div>

    <div class="sousinn">
    <input type="submit" value="送信"></div>
    </form>
    <?php
    if($_SERVER["REQUEST_METHOD"]=='POST'){
        $name=$_POST['name'];
        $address=$_POST['address'];
        $phone=$_POST['phone'];
        $password=$_POST['password'];
        $birthday=$_POST['birthday'];
        if(isset($_POST['genre'])){
            $genre=$_POST['genre'];
        }else{
            $genre=[];
        }
        
    
    //<p>14から31は文字を赤でお願い</p>
    echo'<div class="red">';
    if(empty($name)){
        echo '<div class="error1">';
        echo '<p>','名前は必須項目です','</p>';  
        echo '</div>';
    }
    if(empty($address)){
        echo '<div class="error2">';
        echo '<p>','メールアドレスは必須項目です','</p>';
        echo '</div>';
    }
    if(empty($phone)){
        echo '<div class="error3">';
        echo '<p>','電話番号は必須項目です','</p>';
        echo '</div>';
    }
    if(empty($password)){
        echo '<div class="error4">';
        echo '<p>','パスワードは必須項目です','</p>';
        echo '</div>';
    }
    if(empty($birthday)){
        echo '<div class="error5">';
        echo '<p>','生年月日は必須項目です','</p>';
        echo '</div>';
    }
    if(empty($genre)){
        echo '<div class="error6">';
        echo '<p>','好きなジャンルは必須項目です','</p>';
        echo '</div>';
    }
    if(count($genre)>3){
        echo '<div class="error7">';
        echo '<p>','ジャンルは３つまでです','</p>';
        echo '</div>';
    }
    echo"<div>";
    if(!empty($name)&&!empty($address)&&!empty($phone)&&!empty($password)&&!empty($birthday)&&!empty($genre)){
        $genre=implode(',',$genre);
        $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
        $pdo=new PDO($connect,USER,PASS);
        $stmt=$pdo->prepare("INSERT INTO customer(name,address,phone,password,birthday,genre)VALUES(?,?,?,?,?,?)");
        $stmt->execute([$name,$address,$phone,$password,$birthday,$genre]);
        header('Location: login.php');
        exit;
    }
}
ob_end_flush();
?>


    <form action="login.php" method="get">
        <div class="rog">
        <button type="submit">ログイン画面へ戻る</button><div>
    </form>
</div>
    </body>
</html>