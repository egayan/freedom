<?php
session_start();
ob_start();
require 'db-conect.php';
$pdo=new PDO($connect,USER,PASS);
if($_SERVER['REQUEST_METHOD']=='POST'){
    foreach($_SESSION['movie'] as $product_id => $product){
        //クーポンの取得
        $stmt=$pdo->prepare("SELECT coupon_id FROM customer WHERE client_id=?");
        $stmt->execute([$_SESSION['customer']['client_id']]);
        $client_coupon=$stmt->fetchColumn();
        //クーポンの使用判定
        if(isset($_POST['coupon'][$product_id])){
            $coupon_id=$_POST['coupon'][$product_id];
        }else{
            $coupon_id=0;
        }
        //割引率
        $stmt=$pdo->prepare("SELECT discount_rate FROM coupon WHERE coupon_id=?");
        $stmt->execute([$coupon_id]);
        $discount_rate=$stmt->fetchColumn();
        //価格の更新
        $new_price=$product['price']*$discount_rate;
        //購入処理
        $stmt = $pdo->prepare("INSERT INTO purchase(shohin_id, client_id, amount_spent) VALUES (?, ?, ?)");
        $stmt->execute([$product_id,$_SESSION['customer']['client_id'], $new_price]);
        //クーポンの所有情報を更新
        $stmt=$pdo->prepare("UPDATE customer SET use_frag=1 WHERE client_id=?");
        $stmt->execute([$_SESSION['customer']['client_id']]);
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
$stmt = $pdo->query("SELECT coupon_id,coupon_name FROM coupon");
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
        <?php foreach($cart as $product_id=>$item):?>
        <tr>
            <td><?php echo $item['name'];?></td>
            <td>
                <select name="coupon[<?php echo $product_id; ?>]">
                    <option value="0">クーポンを使用しない</option>
                    <?php foreach($coupons as $coupon):?>
                        <option value="<?php echo $coupon['coupon_id'];?>"><?php echo $coupon['coupon_name'];?></option>
                    <?php endforeach;?>
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