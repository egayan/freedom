<?php
session_start();
ob_start();
require 'db-conect.php';

if($_SERVER['REQUEST_METHOD']=='POST'){


    unset($_SESSION['movie']);
    header('Location: my.php');
    exit;
}
$cart=$_SESSION['movie'];
$total=0;
foreach($cart as $item){
    $total+= $item['price'];
}
?>
<!DOCTYPE html>
<html lang="ja">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/login.css" rel="stylesheet">
    <title>購入画面</title>
</head>
<body>
    <h1>購入画面</h1>
    <table>
        <tr>
            <th>商品名</th><th>支払方法</th><th>金額</th>
        </tr>
        <?php foreach($cart as $item):?>
        <tr>
            <td><?php echo $item['name'];?></td>
            <td>
                <select name="pay">
                    <option value="cash">現金</option>
                    <option value="card">カード払い</option>
                    <option value="coupon">クーポンを使用</option>
                </select>
            </td>
            <td><?php echo $item['price']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p>合計金額：　<?php echo $total; ?></p>
    <form method="post">
        <input type="submit" value="購入">
    </form>
</body>
</html>
<?php ob_end_flush();?>