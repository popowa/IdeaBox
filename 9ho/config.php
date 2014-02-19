<?php
echo '
<html><head><title>区報変換</title>
<meta http-equiv="Content-Type" content="text/html charset=utf-8" />
<link rel=stylesheet type="text/css" href="./style.css">  
</head>
<body>
<div id="main">
	<div id="header">
		文字変換ツール
	</div>
';
	if(isset($_POST['sc'])) {
		$fp = fopen('./convert.txt', 'w');
		$convertAll = $_POST['string'];
		foreach($convertAll as $k => $convert) {
			if(!empty($convert["o"])) {
				fwrite($fp, htmlspecialchars($convert["o"]) .':'. htmlspecialchars($convert["r"]) ."\n");
			}
		}
echo '保存しました（・∀・）
	<div id="footer">
	<a href="./config.php">変換表の作成</a> | <a href="./index.html">トップページ</a>
	ご利用はみなさんの責任でお願いします。
	</div>
</div>
</body></html>';		
		die();
	}



echo '
変換前の文字  => 変換後の文字
<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
	$convertAll = file('./convert.txt', FILE_IGNORE_NEW_LINES);
	foreach($convertAll as $k => $v) {
		$convert = explode(':', $v);
		echo '<p><input type="text" name="string[' . $k . '][o]" value="' . htmlspecialchars($convert[0]) . '">=>';
		echo '<input type="text" name="string[' . $k . '][r]" value="' . htmlspecialchars($convert[1]) . '"></p>';
		$num = $k;
		}
	echo '
	<p><input type="text"  name="string[998][o]" value="">=><input type="text" name="string[998][r]" value=""></p>
	<p><input type="text"  name="string[999][o]" value="">=><input type="text" name="string[999][r]" value=""></p>

	<input type="hidden" name="sc" value="testtesttest">
<input type="submit" value="変換！">
<br />削除したい場合は、枠内を空にすると削除対象になります。
	';

echo '
	<div id="footer">
	<a href="./config.php">変換表の作成</a> | <a href="./index.html">トップページ</a>
	ご利用はみなさんの責任でお願いします。
	</div>
    <hr />
</div>
</body></html>';
?>

