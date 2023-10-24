<link href="styles/cart-show.css" rel="stylesheet">

<?php
 echo '<div class="iti ">';
if(!empty($_SESSION['movie'])){
    echo '<table border="1">';
    echo '<tr><th>商品画像</th><th>購入商品</th><th>販売価格</th>';
    echo '<th>削除</th></tr>';
    $total=0;
    foreach($_SESSION['movie'] as $id=>$product){
        echo '<tr>';
        ?>
        <td><?php echo'<img src="image/', $product['image']; ?>" alt="<?php echo $product['name']; ?>"></td>
        <?php
        echo '<td><a href="detail.php?id=',$id,'">',$product['name'],'</a></td>';
        echo '<td>',$product['price'],'</td>';
        $total+=$product['price'];
        echo '<td><a href="cart-delete.php?id=',$id,'">削除</a></td>';
        echo '</tr>';
    }
    echo '<tr><td>合計</td><td></td><td></td><td>',$total,'</td></tr>';
    echo '</table>';
    echo "</div>";
    echo"<form action='.php' method='get'>";
    echo'<div class="kakutei">';
    echo'<input type="submit" value="購入"></div>';
    echo"</form>";



}else{
    echo 'カートに商品がありません';
}
?>
