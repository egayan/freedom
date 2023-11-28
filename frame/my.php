<?php
session_start();
require 'db-conect.php';
ob_start();
require 'header.php';
 require 'menu.php';
$pdo = new PDO($connect, USER, PASS);
// ログアウトが押された場合
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

// フォームが送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name=$_POST['name'];
    $address=$_POST['address'];
    $phone=$_POST['phone'];
    $password=$_POST['password'];

    // アドレスのチェック
    if(isset($_SESSION['customer']['client_id'])){
        $id=$_SESSION['customer']['client_id'];
    }else{
        $id=null;
    }
    if(!preg_match("/^\d{10,11}$/", $phone)){
        echo '電話番号は10桁または11桁の数字で入力してください。';
        exit;
    }
    $stmt=$pdo->prepare('SELECT * FROM customer WHERE address = ?');
    if($id){
        $stmt=$pdo->prepare('SELECT * FROM customer WHERE client_id != ? AND address = ?');
        $stmt->execute([$id, $address]);
    }else{
        $stmt->execute([$address]);
    }
    $customer = $stmt->fetchAll();
    
    if (empty($customer)) {
        // アドレスが重複していない場合は更新
        if ($id) {
            // 更新
            if(!empty($pqwwword)){
                //空欄でないなら更新
                $stmt = $pdo->prepare('UPDATE customer SET name=?, address=?,phone=?,password=? WHERE client_id=?');
                $stmt->execute([$name, $address,$phone,password_hash($password, PASSWORD_DEFAULT), $id]);    
            }else{
                $stmt = $pdo->prepare('UPDATE customer SET name=?, address=?, phone=? WHERE client_id=?');
                $stmt->execute([$name, $address,$phone,$id]);
            }
            $_SESSION['customer'] = [
                'client_id' => $id,
                'name' => $name,
                'address' => $address,
                'phone' => $phone,
                'password' => $password,
            ];
            echo 'お客様情報を更新しました。';
        }
    }else{
        echo 'メールアドレスがすでに使用されていますので、変更してください。';
    }
}

// ユーザー情報の取得
$userinfo=$_SESSION['customer'];

// クーポン情報の取得
$sql_coupon = $pdo->prepare('SELECT c.* FROM customer cu
                             JOIN coupon c ON c.coupon_id = cu.coupon_id
                             WHERE cu.client_id = ? AND cu.use_frag = 0');
$sql_coupon->execute([$_SESSION['customer']['client_id']]);
$user_coupons = $sql_coupon->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/my.css">
    <title>マイページ</title>
    <link href="css/my.css" rel="stylesheet">
</head>
<body>
    <div class="wrap">
        <form action="" method="post">
            <table>
                <tr><td><div class="name">お名前<div></td><td><input type="text" class="nametext" name="name" value="<?php echo $userinfo['name']; ?>"></td></tr>
                <tr><td><div class="meru">メールアドレス<div></td><td><input type="email" class="merutext" name="address" value="<?php echo $userinfo['address']; ?>"></td></tr>
                <tr><td><div class="denha">電話番号<div></td><td><input type="text" class="denhatext" name="phone" value="<?php echo $userinfo['phone']; ?>"></td></tr>
                <tr><td><div class="pasu">パスワード<div></td><td><input type="password" class="pasutext" name="password" value=""></td></tr>
            </table>
            <input type="submit" class="kakusubmit" value="確定">
        </form>
        <p class="kupon">所持クーポン一覧</p>
        <?php if (!empty($user_coupons)) : ?>
            <ul>
                <?php foreach ($user_coupons as $coupon) : ?>
                    <div class="kuponlist">
                    <li><?php echo $coupon['coupon_name']; ?></li>
                    <div>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p class="kuponno">クーポンを所持していません。</p>
        <?php endif; ?>
        <p><a href="my.php?logout=1" class="rogout">ログアウト</a></p>
    </div>
    <?php ob_end_flush();?>
</body>
</html>
