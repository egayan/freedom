<?php
if(!empty($_SESSION['movie'])){
    echo '<table>';
    echo '<tr><th>購入商品</th><th>販売価格</th>';
    echo '<th>削除</th><th></th><th></th><th></th></tr>';
    $total=0;
    foreach($_SESSION['movie'] as $id=>$product){
        echo '<tr>';
        ?>
        <img src="image/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
        <?php
        echo '<td><a href="detail.php?id=',$id,'">',$product['name'],'</a></td>';
        echo '<td>',$product['price'],'</td>';
        $total+=$product['price'];
        echo '<td><a href="cart-delete.php?id=',$id,'">削除</a></td>';
        echo '</tr>';
    }
    echo '<tr><td>合計</td><td></td><td></td><td>',$total,'</td><td></td></tr>';
    echo '</table>';
    ?>
    <form action=purchase.php method="get">
        <input type="submit" value="購入">
    </form>
    <?php
}else{
    echo 'カートに商品がありません';
}
?>