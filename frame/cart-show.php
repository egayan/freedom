<link rel="stylesheet" href="styles/cart-show.css">
<?php
if(!empty($_SESSION['movie'])){
    echo '<table border="1"  class="iti">';
    echo '<tr><th>購入商品</th><th>販売価格</th>';
    echo '<th>削除</th><th></th></tr>';
    $total=0;
    foreach($_SESSION['movie'] as $id=>$product){
        echo '<tr>';
        ?>
        <?php
         echo '<td  width="500px"><img src="image/' . $product['image'] . '" alt="' . $product['name'] . '">';
        echo '<a href="detail.php?id=',$id,'">',$product['name'],'</a></td>';
        echo '<td>',$product['price'],'</td>';
        $total+=$product['price'];
        echo '<td width="50px"><a href="cart-delete.php?id=',$id,'">削除</a></td>';
        echo '</tr>';
    }
    echo '<tr><td>合計</td> <td></td> <td></td> <td>',$total,'</td></tr>';
    echo '</table>';
    ?>
    </div>
    <form action=purchase.php method="get">
    <div class="kakutei">  <input type="submit" value="購入" class="button">
</div>
</form>
    <?php
}else{
    echo 'カートに商品がありません';
}
?>