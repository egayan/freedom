var totalAmounts = {}; // 商品ごとの合計金額を格納するオブジェクト

function calculateTotalAmount(productId, discountRate) {
    var originalPrice = originalPrices[productId]; 
    var discountedAmount = originalPrice * discountRate;
    var totalAmount = originalPrice - discountedAmount;
    var roundedTotalAmount = Math.floor(totalAmount);
    return roundedTotalAmount;
}

function handleCouponClick(productId, selectedCouponId) {
    var discountRate = 0;
    totalAmounts = {};
    // クーポンが選択されている場合、割引率を取得
    if (selectedCouponId !== '0') {
        discountRate = parseFloat(document.querySelector('input[name="coupon[' + productId + ']"]:checked').getAttribute('data-discount-rate'));
    }
    
    // 金額を計算
    var newTotalAmount = calculateTotalAmount(productId, discountRate);
    //各商品の価格
    document.getElementById('totalAmountCell' + productId).innerText = newTotalAmount;
    // 変更後の価格を足し合わせて合計金額を更新
    document.getElementById('totalAmount').innerText = updateTotalAmount(productId, addOriginalAndNewPrice(productId, newTotalAmount));
    
    // クーポンオプションの表示制御
    handleCouponOptions(productId, selectedCouponId);
    
    console.log("newTotalAmount:", newTotalAmount);
    console.log("totalAmounts:", totalAmounts);
}


function updateTotalAmount(productId, newAmount) {
    // 商品ごとに合計金額を更新
    totalAmounts[productId] = newAmount;
    // 合計金額を再計算
    var total = 0;
    console.log("totalAmount", totalAmount);
    for (var key in totalAmounts) {
        total += totalAmounts[key];
        console.log("total", total);
    }
    return total;
}

function handleCouponOptions(productId, selectedCouponId) {
    var allCouponOptions = document.querySelectorAll('.coupon-options');
    // クーポンを使用しないが選択された場合
    if (selectedCouponId == 0) {
        // 他のクーポンオプションを表示する
        for (var i = 0; i < allCouponOptions.length; i++) {
            allCouponOptions[i].style.display = 'block';
        }
    } else {
        // クーポンを使用するが選択された場合
        // すべてのクーポンオプションを非表示にし、選択されたクーポンオプションだけを表示する
        for (var i = 0; i < allCouponOptions.length; i++) {
            allCouponOptions[i].style.display = 'none';
        }
        var selectedCouponOption = document.getElementById('couponOptions' + productId);
        selectedCouponOption.style.display = 'block';
    }
}
// 新しい関数：元の価格と変更後の価格を足し合わせる
function addOriginalAndNewPrice(productId, newPrice) {


    // productId以外の商品IDに対応する元の価格を取得
    var otherProductOriginalPrices = getOtherProductOriginalPrices(productId);
    // 新しい価格だけを足し合わせる
    var totalPrice = Object.values(otherProductOriginalPrices).reduce(function (sum, price) {
        return sum + price;
    }, 0) + newPrice;
    return totalPrice;
}


function getOtherProductOriginalPrices(currentProductId) {
    var otherProductOriginalPrices = {};

    // ループを回してcurrentProductId以外の商品IDの元の価格を取得
    for (var productId in originalPrices) {
        if (productId != currentProductId) {
            otherProductOriginalPrices[productId] = originalPrices[productId];
        }
    }
    return otherProductOriginalPrices;
}
