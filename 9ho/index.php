<?php
echo '<html><head><title>区報変換</title>
<meta http-equiv="Content-Type" content="text/html charset=utf-8" />
<link rel=stylesheet type="text/css" href="./style.css">  
</head>
<body>
<div id="main">
	<div id="header">
		文字変換ツール
	</div>
';
if($_POST['sc']) {
	$data = $_POST['data'];
	if(!empty($data)) {
		$convertAll = file('./convert.txt', FILE_IGNORE_NEW_LINES);
		foreach($convertAll as $k => $v) {
			$convert = explode(':', $v);
			$original[$k] = $convert[0];
			$replace[$k] = $convert[1];
			}	
		$converted = str_replace($original, $replace, $data);
		if(isset($_POST['removebr'])) {
			$converted = ereg_replace("\r|\n","",$converted);
		}
		if(isset($_POST['eiji'])) {
		$converted = mb_convert_kana($converted, $_POST['eiji']);			
		}
		if(isset($_POST['kana'])) {
		$converted = mb_convert_kana($converted, $_POST['kana']);			
		}

		echo htmlspecialchars($converted);
	}
	else {
		echo '変換するデータがありませんでした. (´・ω・`) ショボーン';
	}
}
else {
	echo 'なにかがおかしいです(・_・")?';
	}
echo '
	<div id="footer">
	<a href="./config.php">変換表の作成</a> | <a href="./index.html">トップページ</a>
	ご利用はみなさんの責任でお願いします。
	</div>
    <hr />
</div>
';
?>

