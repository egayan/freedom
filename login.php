
    

<!DOCTYPE html>
<html lang="en">
<head> 
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/login.css" rel="stylesheet">
    <title>ログイン画面</title>
</head>
<body>
 <div class="wrap">
   
    <div class="img">
    <img src="img/rogo.jpg" alt="rogo" title="rogo"></div>

   <form action='search.php' method="post">  
   <div class="name1">
   メールアドレス<br>または<br>電話番号</div>

   <div class="name2">
  <input type="text" name="login"><br></div>

    <div class="pasu1">
    パスワード</div>

    <div class="pass2">
    <input type="password" name="password"><br></div>

    <div class="rogu">
    <input type="submit" value="ログイン"></div>
   </form>
   <form action='touroku.php' method="get">
   <div class="sinki">
   <input type="submit" value="新規登録の方はこちら"></div>
   </form>
   
</div>
</body>
</html>