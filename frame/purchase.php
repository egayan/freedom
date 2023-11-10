<?php
session_start();
ob_start();
require 'db-conect.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    if($_POST['coupon']){
    $stmt = $pdo->prepare("UPDATE customer SET coupon=? WHERE id=?");
    $stmt->execute($_POST['coupon'],$_SESSION['customer_id']);
    }
    foreach($_SESSION['movie'] as $product_id => $product){
        $stmt = $pdo->prepare("INSERT INTO purchase(shohin_id, client_id, purchase_date, amount_spent) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['customer_id'], $product_id, date('Y-m-d H:i:s'), $product['price']]);
    }
    unset($_SESSION['movie']);
    header('Location: my.php');
    exit;
}
$cart=$_SESSION['movie'];
$total=0;
foreach($cart as $item){
    $total+= $item['price'];
}
$couponA=true;
$couponB=true;
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
            <th>商品名</th><?php if($couponA || $couponB):?><th>クーポン</th><?php endif;?><th>金額</th>
        </tr>
        <?php foreach($cart as $item):?>
        <tr>
            <td><?php echo $item['name'];?></td>
            <?php if($couponA || $couponB):?>
            <td>
                <select name="coupon">
                    <option value="0">クーポンを使用しない</option>
                    <?php if($couponA):?><option value="1">クーポンAを使用\</option><?php endif; ?>
                    <?php if($couponB):?><option value="2">クーポンBを使用\</option><?php endif; ?>
                </select>
            </td>
            <?php endif;?>
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