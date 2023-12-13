<?php
session_start();
ob_start();
require 'db-conect.php';
require 'header.php'; 
$pdo=new PDO($connect,USER,PASS);
//使用状態の確認
$stmt=$pdo->prepare("SELECT use_frag FROM customer WHERE client_id=?");
$stmt->execute([$_SESSION['customer']['client_id']]);
$use_frag=$stmt->fetchColumn();
if($_SERVER['REQUEST_METHOD']=='POST'){
    foreach($_SESSION['movie'] as $product_id => $product){
        //所持状態の確認
        $stmt=$pdo->prepare("SELECT use_frag FROM customer WHERE client_id=?");
        $stmt->execute([$_SESSION['customer']['client_id']]);
        $use_frag=$stmt->fetchColumn(); 
        //クーポンの使用判定
        if(isset($_POST['coupon'][$product_id])){
            $coupon_id=$_POST['coupon'][$product_id];
        }else{
            $coupon_id=0;
        }
        //クーポン有の処理
        if($use_frag==0&&$coupon_id!=0){
            //割引率
            $stmt=$pdo->prepare("SELECT discount_rate FROM coupon WHERE coupon_id=?");
            $stmt->execute([$coupon_id]);
            $discount_rate=$stmt->fetchColumn();
            //価格の更新
            $new_price=$product['price']*(1-$discount_rate);
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
    header('Location: library.php');
    exit;
}
$cart=$_SESSION['movie'];
$total=0;
foreach($cart as $item){
    $total+=$item['price'];
}

//クーポン一覧取得
$stmt = $pdo->prepare("SELECT coupon.coupon_id,coupon_name,discount_rate FROM coupon  JOIN customer ON coupon.coupon_id=customer.coupon_id
WHERE customer.client_id=?");
$stmt->execute([$_SESSION['customer']['client_id']]);
$coupons=$stmt->fetchAll(PDO::FETCH_ASSOC); 
?>

<!DOCTYPE html>
<html lang="ja">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="style/p.css" rel="stylesheet"> -->
    <title>購入画面</title>
</head>
<body>
    <div class="warp">
    <table>
    <form action="cart-insert.php" method="get">
        <div class="rog">
        <button type="submit">ひとつ前に戻る</button><div>
        <tr>
            <th>商品名</th><th>クーポン</th><th>金額</th>
        </tr>
        <form method="post">
        <?php foreach($cart as $product_id=>$item):?>
            <tr>
                <td><?php echo $item['name'];?></td>
                <td>
                    <?php if($use_frag==1):?>
                        <input type='hidden' name="coupon[<?php echo $product_id; ?>]" 
                        value="0" checked>クーポンなし
                    <?php else :?>
                        <div class="coupon-options" id="couponOptions<?php echo $product_id; ?>">
                        <?php foreach($coupons as $coupon):?>
                            <input type='radio' name="coupon[<?php echo $product_id; ?>]" 
                            value="<?php echo $coupon['coupon_id']; ?>" data-discount-rate="<?php echo $coupon['discount_rate']; ?>"
                            onclick="handleCouponClick(<?php echo $product_id; ?>,1)">
                            <?php echo $coupon['coupon_name'];?>
                        <?php endforeach;?>
                        <input type='radio' name="coupon[<?php echo $product_id; ?>]" 
                        value="0" onclick="handleCouponClick(<?php echo $product_id; ?>,'0')"
                        checked>クーポンを使用しない
                        </div>
                    <?php endif;?>
                </td>
                <td id="totalAmountCell<?php echo $product_id; ?>"><?php echo $item['price']; ?></td>
            </tr>
        <?php endforeach; ?>
        <td class="none"></td>
        <td class="a" >合計金額</td>
        <td id="totalAmount" ><?php echo $total; ?></td>
        </tr>
        </table>
        </div>
        <div class="kounyuu">
        <input type="submit" value="購入">
    </form>
    </div>
    <script src="js/purchase.js"></script>
    <script>
        var originalPrices = {};
        <?php foreach($cart as $product_id => $item): ?>
        originalPrices[<?php echo $product_id;?>] = <?php echo $item['price']; ?>;
        <?php endforeach; ?>
    </script>
</body>
</html>
<?php ob_end_flush();?>