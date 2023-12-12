<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
</head>
<body>
    <img src="img/sinki.jpg">
    <p><a href=""><</a></p>
    <h1>レビュー投稿</h1>
    <div class="rect"></div>
評価<select name="a">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    </select>/10    名前<input type="text" name="name">
    <p>見出し<input type="text" name="midasi"></p>
    <p>詳細<input type="text" name="syosai"></p>
    <p><input type="button" value="レビューを投稿する"id="button"></p>
   <?php require 'menu.php';?>

</body>
</html>