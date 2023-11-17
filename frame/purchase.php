<?php
session_start();
ob_start();
require 'db-conect.php';
$pdo=new PDO($connect,USER,PASS);
//使用状態の確認
$stmt=$pdo->prepare("SELECT use_frag FROM customer WHERE client_id=?");
$stmt->execute([$_SESSION['customer']['client_id']]);
$use_frag=$stmt->fetchColumn();
if($_SERVER['REQUEST_METHOD']=='POST'){
    foreach($_SESSION['movie'] as $product_id => $product){
        //クーポンの使用判定
        if(isset($_POST['coupon'][$product_id])){
            $coupon_id=$_POST['coupon'][$product_id];
        }else{
            $coupon_id=0;
        }
        //クーポン持っているときの処理
        if($use_frag==0&&$coupon_id!=0){
            //割引率
            $stmt=$pdo->prepare("SELECT discount_rate FROM coupon WHERE coupon_id=?");
            $stmt->execute([$coupon_id]);
            $discount_rate=$stmt->fetchColumn();
            //価格の更新
            $new_price=$product['price']*(1-$discount_rate);
            $new_price=ROUND($new_price);
            //購入処理
            $stmt = $pdo->prepare("INSERT INTO purchase(shohin_id, client_id, amount_spent) VALUES (?, ?, ?)");
            $stmt->execute([$product_id,$_SESSION['customer']['client_id'], $new_price]);
            //クーポンの所有情報を更新
            $stmt=$pdo->prepare("UPDATE customer SET use_frag=1 WHERE client_id=?");
            $stmt->execute([$_SESSION['customer']['client_id']]);
        }else{
            $stmt = $pdo->prepare("INSERT INTO purchase(shohin_id, client_id, amount_spent) VALUES (?, ?, ?)");
            $stmt->execute([$product_id,$_SESSION['customer']['client_id'], $product['price']]);
        }
    }
    unset($_SESSION['movie']);
    header('Location: my.php');
    exit;
}
$cart=$_SESSION['movie'];
$total=0;
foreach($cart as $item){
    $total+=$item['price'];
}
//購入済み一覧取得
/* $stmt = $pdo->prepare("SELECT shohin_id,shohin_mei FROM purchase INNER JOIN eiga ON purchase.shohin_id=eiga.shohin_id
                        WHERE purchase.client_id=?");
$stmt->execute([$_SESSION['customer']['client_id']]);
$items=$stmt->fetchAll(PDO::FETCH_ASSOC); */
//クーポン一覧取得
$stmt = $pdo->prepare("SELECT coupon.coupon_id,coupon_name FROM coupon  JOIN customer ON coupon.coupon_id=customer.coupon_id
WHERE customer.client_id=?");
$stmt->execute([$_SESSION['customer']['client_id']]);
$coupons=$stmt->fetchAll(PDO::FETCH_ASSOC); 
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
            <th>商品名</th><th>クーポン</th><th>金額</th>
        </tr>
        <form method="post">
        <?php foreach($cart as $product_id=>$item):?>
            <tr>
                <td><?php echo $item['name'];?></td>
                <td>
                    <!--クーポンがないとき -->
                    <?php if($use_frag==1):?>
                        <input type='hidden' name="coupon[<?php echo $product_id; ?>]" 
                        value="0" checked>クーポンなし
                    <?php else :?>
                        <!--クーポンあるとき -->
                        <?php foreach($coupons as $coupon):?>
                            <input type='radio' name="coupon[<?php echo $product_id; ?>]" 
                            value="<?php echo $coupon ['coupon_id']; ?>">
                            <?php echo $coupon['coupon_name'];?>
                        <?php endforeach;?>
                        <!-- クーポン使わないとき -->
                        <input type='radio' name="coupon[<?php echo $product_id; ?>]" 
                        value="0" checked>クーポンを使用しない
                    <?php endif;?>
                </td>
                <td><?php echo $item['price']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>合計金額：<?php echo $total; ?></p>

        <input type="submit" value="購入">
    </form>
</body>
</html>
<?php ob_end_flush();?>