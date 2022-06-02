<?php
//セッションの利用を開始
session_start();

//ログイン認証情報を取得する関数のインポート
require_once './function/loginAuthentication.php';

//インポートした関数でログイン中のユーザー名と権限を取得
$authInfo = authenticate();

/* 表示する書籍一覧を取得 */
require_once './function/dbprocess.php';

$selectSql = "SELECT * FROM bookinfo ORDER BY isbn ASC";
$selectResult = executeQuery($selectSql);

$bookLists = array();

while($bookList = mysqli_fetch_assoc($selectResult)) {
    $bookLists[] = $bookList;
}
mysqli_free_result($selectResult);
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="./css/layouts.css">
		<link rel="stylesheet" type="text/css" href="./css/list.css">
		<title>書籍一覧画面</title>
	</head>
    <body>
    	<header>
        	<h2 id="title">書籍管理システムVer3.0応用</h2>
        	<div id="navSpace">
        		<hr id="blueLine1">
            	<div class="float-left">
            		<a href="./menu.php" class="nav">[メニュー]</a>
            		<a href="./insert.php" class="nav">[書籍登録]</a>
            	</div>
        		<h3 id="title">書籍一覧</h3>
            	<div class="loginInfo">
            		<p>名前：<?=$authInfo['userName']?></p>
            		<p>権限：<?=$authInfo['authority']?></p>
            	</div>
        		<hr id="blackLine1">
        	</div>
        </header>
        <main>
        	<br><br>
        	<?php
        	//管理者でログインしている時の画面表示
        	if($authInfo['authority'] == '管理者') {?>
            	<!-- フォーム部分 -->
            	<div class="forms">
                	<form action="./search.php" method="post">
                		　ISBN<input type="text" name="isbn">
                		　TITLE<input type="text" name="title">
                		　価格<input type="text" name="price">
                		　<input type="submit" name="listButton" value="検索">
                	</form>
                	<form action="./list.php" method="get">
                		　<input type="submit" value="全件表示">
                	</form>
            	</div>
            	<br><br>
            	<!-- テーブル部分 -->
            	<table id="adminTable">
            		<tr>
            			<th>ISBN</th>
            			<th>TITLE</th>
            			<th>価格</th>
            			<th></th>
            		</tr>
            		<?php
                	foreach($bookLists as $record) {?>
                		<tr>
                			<td><a href="./detail.php?isbn=<?=$record['isbn']?>"><?=$record['isbn']?></a></td>
                			<td><?=$record['title']?></td>
                			<td><?=$record['price']?>円</td>
                			<td>
                				<a href="./update.php?updateIsbn=<?=$record['isbn']?>" style="margin-right: 20px">変更</a>
                				<a href="./delete.php?deleteIsbn=<?=$record['isbn']?>" style="margin-right: 20px">削除</a>
                			</td>
                		</tr>
            		<?php
            		}?>
            	</table>
        	<?php
        	//一般ユーザでログインしている時の画面表示
        	} elseif($authInfo['authority'] == '一般ユーザ') {?>
            	<!-- フォーム部分 -->
            	<div class="forms">
                	<form action="./search.php" method="post">
                		　ISBN<input type="text" name="isbn">
                		　TITLE<input type="text" name="title">
                		　価格<input type="text" name="price">
                		　<input type="submit" name="listButton" value="検索">
                	</form>
                	<form action="./list.php" method="get">
                		　<input type="submit" value="全件表示">
                	</form>
            	</div>
            	<br><br>
                <!-- テーブル部分 -->
            	<table id="ordinalUserTable">
            		<tr>
            			<th>ISBN</th>
            			<th>TITLE</th>
            			<th>価格</th>
            			<th>購入数</th>
            			<th></th>
            		</tr>
            		<?php
            		foreach($bookLists as $record) {?>
                		<tr>
                			<td><a href="./detail.php?isbn=<?=$record['isbn']?>"><?=$record['isbn']?></a></td>
                			<td><?=$record['title']?></td>
                			<td><?=$record['price']?>円</td>
            				<form action="./insertIntoCart.php" method="post">
                    			<td><input type="number" name="quantity"></td>
                    			<td>
                    				<input type="hidden" name="insertIsbn" value="<?=$record['isbn']?>">
                    				<input type="submit" name="intoCartButton" value="カートに入れる">
                    			</td>
                    		</form>
                		</tr>
            		<?php
            		}?>
            	</table>
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