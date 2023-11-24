// JavaScript
function disableOtherCoupons(product_id, selectedCoupon) {
    // 全てのクーポンボタンを取得
    var couponButtons = document.querySelectorAll('input[name="coupon[' + product_id + ']"]');

    // 選択されたクーポン以外のクーポンボタンを無効にする
    couponButtons.forEach(function(button) {
        if (button.value !== selectedCoupon) {
            button.disabled = true;
        }
    });
}

// クーポンボタンがクリックされたときの処理
function handleCouponClick(product_id) {
    // 選択されたクーポンボタンの要素を取得
    var selectedCoupon = document.querySelector('input[name="coupon[' + product_id + ']"]:checked');

    // 選択されたクーポンが存在する場合、割引率を取得
    var discountRate = selectedCoupon ? parseFloat(selectedCoupon.dataset.discountRate) : 1.0;

    // 商品金額を取得
    var productPriceElement = document.querySelector('td[data-product-id="' + product_id + '"]');
    var productPrice = parseFloat(productPriceElement.innerText);

    // 選択されたクーポンが0（クーポン未選択）でない場合、商品金額を更新
    if (selectedCoupon && selectedCoupon.value !== '0') {
        productPrice = productPrice * discountRate;
    }

    // 商品金額を表示
    productPriceElement.innerText = productPrice.toFixed(2);

    // 選択されたクーポン以外のクーポンボタンを無効にする
    disableOtherCoupons(product_id, selectedCoupon ? selectedCoupon.value : '');

    // 合計金額を再計算
    recalculateTotal();
}

// クーポンボタンにイベントリスナーを追加
document.querySelectorAll('.couponSelect input[type="radio"]').forEach(function(button) {
    button.addEventListener('click', function() {
        var product_id = this.name.match(/\d+/)[0];
        handleCouponClick(product_id);
    });
});

// 合計金額を再計算する関数
function recalculateTotal() {
    var total = 0;
    document.querySelectorAll('.couponSelect td[data-product-id]').forEach(function(td) {
        total += parseFloat(td.innerText);
    });
    document.getElementById('totalAmount').innerText = total.toFixed(2);
}
