<?php
//セッションの利用を開始
session_start();

//ログイン認証情報を取得する関数のインポート
require_once './function/loginAuthentication.php';

//インポートした関数でログイン中のユーザー名と権限を取得
$authInfo = authenticate();

/* ルーティング処理 */
if(isset($_GET['updateIsbn']) || isset($_POST['updateButton'])) {    //list.phpやdetail.phpからの遷移もしくは自分自身からの遷移の場合実行
    //一連のDB処理操作をまとめた関数のインポート
    require_once './function/dbprocess.php';

    //遷移元によって設定する変数を変更
    if(isset($_GET['updateIsbn'])) {     //list.phpもしくはdetail.phpからの遷移の場合に実行
        //GET送信で送られてきた更新対象の書籍のisbnを変数に格納
        $isbn = $_GET['updateIsbn'];
    } elseif(isset($_POST['updateButton'])) {   //自分自身からの遷移の場合に実行
        //POSTで受け取った更新対象の各データをそれぞれ変数に格納
        $isbn = $_POST['isbn'];
        $newTitle = $_POST['newTitle'];
        $newPrice = (int)$_POST['newPrice'];

        //POSTで受け取った更新前の各データをそれぞれ変数に格納
        $oldTitle = $_POST['oldTitle'];
        $oldPrice = $_POST['oldPrice'];

//         /* エラー判定１ */
//         if($newTitle == "") {
//             header('Location: ./error.php?errNum=7');
//             exit;
//         }
//         if($newPrice == "") {
//             header('Location: ./error.php?errNum=8');
//             exit;
//         }
//         if(!is_numeric($newPrice)) {
//             header('Location: ./error.php?errNum=9');
//             exit;
//         }
    }

    /* エラー判定２ */
    //検索用のクエリの設定
    $selectSql = "SELECT * FROM bookinfo WHERE isbn = '{$isbn}'";
    //検索用クエリの発行
    $selectResult = executeQuery($selectSql);

    if(!$selectResult) {    //更新対象のデータが存在しなかった場合の処理
        header('Location: ./error.php?errNum=10');
        exit;
    } else {               //更新対象のデータが見つかった場合の処理
        //更新対象のレコードを配列として取得
        $record = mysqli_fetch_array($selectResult);
        //検索結果セットの開放
        mysqli_free_result($selectResult);

        //自分自身からの遷移の場合に実行
        if(isset($_POST['updateButton'])) {
            //更新用クエリの設定
            $updateSql = "UPDATE bookinfo SET title = '{$newTitle}', price = {$newPrice} WHERE isbn = '{$isbn}'";
            //更新用クエリの発行
            executeQuery($updateSql);
        }
    }
} else {                             //上記以外からの遷移の場合に実行
    //list.phpにリダイレクト
    header('Location: ./list.php');
    exit;
}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="./css/layouts.css">
		<link rel="stylesheet" type="text/css" href="./css/update.css">
		<title>書籍更新画面</title>
	</head>
    <body>
    	<header>
        	<h2 id="title">書籍管理システムVer3.0応用</h2>
        	<div id="navSpace">
        		<hr id="blueLine1">
            	<div class="float-left">
            		<a href="./menu.php" class="nav">[メニュー]</a>
            		<a href="./insert.php" class="nav">[書籍登録]</a>
            		<a href="./list.php" class="nav">[書籍一覧]</a>
            	</div>
        		<h3 id="title">書籍変更</h3>
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
        	//初期画面の表示
        	if(!isset($_POST['updateButton'])) {?>
        	<center>
            	<form action="./update.php" method="post">
                	<table id="initialTable">
                		<tr>
                			<th></th>
                			<th>&lt;&lt;変更前情報&gt;&gt;</th>
                			<th>&lt;&lt;変更後情報&gt;&gt;</th>
                		</tr>
                		<tr>
                			<th>ISBN</th>
                			<td class="updateBefore" style="background-color: aqua;"><?=$record['isbn']?></td>
                			<td><?=$record['isbn']?></td>
                		</tr>
                		<tr>
                			<th>TITLE</th>
                			<td class="updateBefore" style="background-color: aqua;"><?=$record['title']?></td>
                			<td><input type="text" name="newTitle" id="newTitle"></td>
                		</tr>
                		<tr>
                			<th>価格</th>
                			<td class="updateBefore" style="background-color: aqua;"><?=$record['price']?>円</td>
                			<td><input type="text" name="newPrice" id="newPrice">円</td>
                		</tr>
                	</table>
        			<div class="err_text_title" id="err_text_title"></div>
        			<div class="err_text_price" id="err_text_price"></div>
        			<div class="err_text_priceNum" id="err_text_priceNum"></div>
                	<br><br><br><br>
                	<input type="hidden" name="isbn" value="<?=$record['isbn']?>">
                	<input type="hidden" name="oldTitle" value="<?=$record['title']?>">
                	<input type="hidden" name="oldPrice" value="<?=$record['price']?>">
                	<input type="submit" name="updateButton" onclick="return do_submit('update');" value="変更完了">
            	</form>
        	</center>
        	<?php
        	//自分自身からの遷移の場合の表示
        	} else {?>
        	<center>
            	<table id="updatedTable">
            		<tr>
            			<th></th>
            			<th>&lt;&lt;変更前情報&gt;&gt;</th>
            			<th>&lt;&lt;変更後情報&gt;&gt;</th>
            		</tr>
            		<tr>
            			<th>ISBN</th>
            			<td class="updateBefore"><?=$isbn?></td>
            			<td><?=$isbn?></td>
            		</tr>
            		<tr>
            			<th>TITLE</th>
            			<td class="updateBefore"><?=$oldTitle?></td>
            			<td><?=$newTitle?></td>
            		</tr>
            		<tr>
            			<th>価格</th>
            			<td class="updateBefore"><?=$oldPrice?>円</td>
            			<td><?=$newPrice?>円</td>
            		</tr>
            	</table>
            	<br><br>
            	<p>上記内容でデータを更新しました。</p>
            	<br><br>
            	<a href="./list.php">書籍一覧へ戻る</a>
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
	<script src="./ajax/jquery-3.6.0.min.js"></script>
	<script src="./ajax/dataCheck.js"></script>
</html>