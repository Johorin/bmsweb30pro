<?php
//セッションの開始
session_start();

//ログイン認証情報を取得する関数のインポート
require_once 'function/loginAuthentication.php';

//インポートした関数でログイン中のユーザー名と権限を取得
$authInfo = authenticate();
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="./css/layouts.css">
		<title>メニュー画面</title>
	</head>
    <body>
        <header>
        	<h2 id="logo">書籍管理システムVer3.0応用</h2>
        	<div id="navSpace">
        		<hr id="blueLine1">
        		<h3 id="title">MENU</h3>
            	<div class="loginInfo">
            		<p>名前：<?=$authInfo['userName']?></p>
            		<p>権限：<?=$authInfo['authority']?></p>
            	</div>
        		<hr id="blackLine1">
        	</div>
        </header>
        <main>
        	<br>
        	<p><?=isset($_GET['updatedPass']) ? 'パスワードを更新しました。' : ''?></p>
        	<br>
        	<?php
        	if($authInfo['authority'] == '管理者') {?>
        		<center>
        			<br><br>
        			<p><a href="./list.php">【書籍一覧】</a></p>
        			<p><a href="./insert.php">【書籍登録】</a></p>
        			<p><a href="./insertIniData.php">【初期データ登録（データがない場合のみ）】</a></p>
        			<p><a href="./orderStatus.php">【購入状況確認】</a></p>
        			<p><a href="./showSalesByMonth.php">【売上げ状況】</a></p>
        			<p><a href="./insertUser.php">【ユーザー登録】</a></p>
        			<p><a href="./listUser.php">【ユーザー一覧】</a></p>
        			<p><a href="./changePassword.php">【パスワード変更】</a></p>
        			<p><a href="./logout.php">【ログアウト】</a></p>
        		</center>
    		<?php
            } elseif($authInfo['authority'] == '一般ユーザ') {?>
        		<center>
        			<br><br>
        			<p><a href="./list.php">【書籍一覧】</a></p>
        			<p><a href="./showCart.php">【カート状況確認】</a></p>
        			<p><a href="./orderHistory.php">【購入履歴】</a></p>
        			<br>
        			<p><a href="./changePassword.php">【パスワード変更】</a></p>
        			<p><a href="./logout.php">【ログアウト】</a></p>
        		</center>
    		<?php
            }?>
        </main>
        <footer>
        	<br><br><br>
        	<hr id="blueLine2">
        	<p id="copyRight">Copyright (C) 20YY All Rights Reserved.</p>
        </footer>
    </body>
</html>