<?php session_start(); ?>
<?php require 'common/db-conect.php'; ?>
<?php ob_start();?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/login.css" rel="stylesheet">
    <title>新規登録画面</title>
</head>
<?php
$a=array("スポーツ","アニメ","アクション","アドベンチャー","青春","ファンタジー","コメディ","ホラー","ミステリ－","ドラマ","サスペンス","ロマンス","ファミリー","ドキュメンタリー","SF");
$b=count($a);
?>
<body>
    <form action="touroku.php" method="post">
    名前
    <input type="text" name="name">
    メールアドレス
    <input type="email" name="address">
    電話番号
    <input type="tel" name="phone">
    パスワード
    <input type="password" name="password">
    生年月日
    <input type="date" name="birthday" value='2000-01-01'> 
    好きなジャンル
    <?php
    for($i = 0; $i<$b ; $i++){
        echo '<input type="checkbox" name="genre[]" value="',$a[$i],'">',$a[$i],'<br>';
    }
    ?>
    <input type="submit" value="送信">
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
    if(empty($name)){
        echo '<p>','名前は必須項目です','</p>';
    }
    if(empty($address)){
        echo '<p>','メールアドレスは必須項目です','</p>';
    }
    if(empty($phone)){
        echo '<p>','電話番号は必須項目です','</p>';
    }
    if(empty($password)){
        echo '<p>','パスワードは必須項目です','</p>';
    }
    if(empty($birthday)){
        echo '<p>','生年月日は必須項目です','</p>';
    }
    if(empty($genre)){
        echo '<p>','好きなジャンルは必須項目です','</p>';
    }
    if(count($genre)>3){
        echo '<p>','ジャンルは３つまでです','</p>';
    }

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
    <form action="login.php" method="post">
        <button type="submit">ログイン画面へ戻る</button>
    </form>

    </body>
</html>