$(function() {
	//bindメソッド：特定のイベントが発生した時に実行する関数を紐づけるメソッド。
	//blurイベント：対象の要素がマウスなどのポインティングなどでフォーカスを失った際に発生するイベント。
	$("#user").bind("blur", function() {
		//id="textbox"のvalue値を取得
		var _textbox = $(this).val();	//"_変数名"とすることでPrivateな変数であることを表現
		//クラスメソッドcheck_loginでで入力チェックとエラーメッセージ表示処理を実行
		CheckLoginData.checkLogin(_textbox, 'user');
	});

	$("#pass").bind("blur", function() {
		//id="textbox"のvalue値を取得
		var _textbox = $(this).val();	//"_変数名"とすることでPrivateな変数であることを表現
		//クラスメソッドcheck_loginで入力チェックとエラーメッセージ表示処理を実行
		CheckLoginData.checkLogin(_textbox, 'pass');
	});
});

class CheckLoginData {
	static checkLogin(checkValue, target) {
		//id="#err_text_user"の子孫セレクタのp要素を削除（同じエラーが繰り返し表示されないように）
		$("#err_text_" + target + " p").remove();

		//検査結果をひとまずtrueに設定しておく
		var _result = true;
		//jQurey.trimメソッド：引数に与えた文字列の前後にある空白を取り除く（※途中の空白は対象外）
		//$.trim()はjQurey.trim()の省略形
		var _textbox = $.trim(checkValue);

		//matchメソッド：対象の文字列に引数の文字列（もしくは正規表現）が含まれるか判定
		//空白や改行のみの入力の場合_resultをfalseとする
		if(_textbox.match(/^[ 　\r\n\t]*$/)) {
			//appendメソッド：HTMLに要素を挿入
			if(target === 'user') {
				$("#err_text_" + target).append('<p style="color: red;">ユーザー名を入力して下さい。</p>');
			} else if(target === 'pass') {
				$("#err_text_" + target).append('<p style="color: red;">パスワードを入力して下さい。</p>');
			}
			_result = false;
		}
		//lengthメソッド：対象の文字列の長さが50文字よりも多い場合も_resultをfalseとする
		else if(_textbox.length > 50) {
			if(target === 'user') {
				$("#err_text_user" + target).append('<p style="color: red;">ユーザー名は50文字以内で入力して下さい。</p>');
			} else if(target === 'pass') {
				$("#err_text_user" + target).append('<p style="color: red;">パスワードは50文字以内で入力して下さい。</p>');
			}
			_result = false;
		}

		return _result;
	}
}
//
///*
// * 関数名：check_userValue
// * 引数：検査対象の文字列str
// * 戻り値：検査結果boolean
// * 機能：与えられた文字列に対してバリデーションチェック
// */
//function check_userValue(userValue) {
//	//id="#err_text_user"の子孫セレクタのp要素を削除（同じエラーが繰り返し表示されないように）
//	$("#err_text_user p").remove();
//
//	//検査結果をひとまずtrueに設定しておく
//	var _result = true;
//	//jQurey.trimメソッド：引数に与えた文字列の前後にある空白を取り除く（※途中の空白は対象外）
//	//$.trim()はjQurey.trim()の省略形
//	var _textbox = $.trim(userValue);
//
//	//matchメソッド：対象の文字列に引数の文字列（もしくは正規表現）が含まれるか判定
//	//空白や改行のみの入力の場合_resultをfalseとする
//	if(_textbox.match(/^[ 　\r\n\t]*$/)) {
//		//appendメソッド：HTMLに要素を挿入
//		$("#err_text_user").append('<p style="color: red;">ユーザー名を入力して下さい。</p>');
//		_result = false;
//	}
//	//lengthメソッド：対象の文字列の長さが50文字よりも多い場合も_resultをfalseとする
//	else if(_textbox.length > 50) {
//		$("#err_text_user").append('<p style="color: red;">ユーザー名は50文字以内で入力して下さい。</p>');
//		_result = false;
//	}
//
//	return _result;
//}
//
///*
// * 関数名：check_passValue
// * 引数：検査対象の文字列str
// * 戻り値：検査結果boolean
// * 機能：与えられた文字列に対してバリデーションチェック
// */
//function check_passValue(passValue) {
//	//id="#err_text_pass"の子孫セレクタのp要素を削除（同じエラーが繰り返し表示されないように）
//	$("#err_text_pass p").remove();
//
//	//検査結果をひとまずtrueに設定しておく
//	var _result = true;
//	//jQurey.trimメソッド：引数に与えた文字列の前後にある空白を取り除く（※途中の空白は対象外）
//	//$.trim()はjQurey.trim()の省略形
//	var _textbox = $.trim(passValue);
//
//	//matchメソッド：対象の文字列に引数の文字列（もしくは正規表現）が含まれるか判定
//	//空白や改行のみの入力の場合_resultをfalseとする
//	if(_textbox.match(/^[ 　\r\n\t]*$/)) {
//		//appendメソッド：HTMLに要素を挿入
//		$("#err_text_pass").append('<p style="color: red;">パスワードを入力して下さい。</p>');
//		_result = false;
//	}
//	//lengthメソッド：対象の文字列の長さが50文字よりも多い場合も_resultをfalseとする
//	else if(_textbox.length > 50) {
//		$("#err_text_pass").append('<p style="color: red;">パスワードは50文字以内で入力して下さい。</p>');
//		_result = false;
//	}
//
//	return _result;
//}