<?php
//セッションの利用を開始
session_start();

//一連のDB操作処理をまとめた関数を読み込む
require_once 'function/dbprocess.php';

if(isset($_POST['loginButton'])) {  //ログインボタンからのアクセスの場合の処理
    //送信された「ユーザー名」と「パスワード」情報を取得
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    //userテーブルに送信されたユーザー情報が存在するか判定
    $selectSql = "select * from userinfo where user='{$user}' and password='{$pass}'";
    $selectResult = executeQuery($selectSql);

    if(!$selectResult) {  //データが取得できなかった場合
        //検索結果セットの開放
        mysqli_free_result($selectResult);

        //エラー番号12の値とともにエラーページへ遷移
        header('Location: ./error.php?errNum=12');
        exit();
    }else { //データが取得できた場合
        //検索結果セットのレコードを連想配列で取得
        $userInfo = mysqli_fetch_assoc($selectResult);
        //検索結果セットの開放
        mysqli_free_result($selectResult);

        //検索結果のデータをセッションに格納
        $_SESSION['userInfo'] = $userInfo;

        //送信された「ユーザー名」と「パスワード」情報をクッキーに登録
        setcookie('user', $user, (time() + 30 * 86400));
        setcookie('pass', $pass, (time() + 30 * 86400));

        //メニュー画面に遷移
        header("Location: ./menu.php");
        exit;
    }
} else {    //初回アクセスの場合の処理
    //前回ログインに成功した際の「ユーザー名」と「パスワード」情報があれば取得
    $user = $_COOKIE['user'];
    $pass = $_COOKIE['pass'];
}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="./css/layouts.css">
		<link rel="stylesheet" type="text/css" href="./css/menu.css">
		<title>ログイン画面</title>
	</head>
    <body>
    <header>
    	<h2 id="logo">書籍管理システムVer3.0応用</h2>
    	<hr id="blueLine1">
    	<h3 id="navSpace">　</h3>
    	<hr id="blackLine1">
    </header>
    <main>
    	<center>
    		<form action="./login.php" method="post">
            	<br><br>
            	<table>
            		<tr>
            			<th>ユーザー</th>
            			<td><input type="text" name="user" id="user" value="<?=$user?>"></td>
            		</tr>
            		<tr>
            			<th>パスワード</th>
            			<td><input type="password" name="pass" id="pass" value="<?=$pass?>"></td>
            		</tr>
            	</table>
    			<div class="err_text_user" id="err_text_user"></div>
    			<div class="err_text_pass" id="err_text_pass"></div>
        		<br><br>
        		<input type="submit" onclick="do_submit()" name="loginButton" value="ログイン">
    		</form>
    	</center>
    </main>
    <footer>
    	<br><br><br>
    	<hr id="blueLine2">
    	<p id="copyRight">Copyright (C) 20YY All Rights Reserved.</p>
    </footer>
    </body>
	<script src="./ajax/jquery-3.6.0.min.js"></script>
	<script src="./ajax/dataCheck.js"></script>
</html>