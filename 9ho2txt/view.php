<?php
define('APP', '/var/www/code/9ho2txt/');
define('STORE', APP . 'store/');
define('PUB_STORE', '/9ho2txt/store/');

$month = (isset($_GET['month']) && !empty($_GET['month'])) ? $_GET['month'] : '04';
$day = (isset($_GET['day']) && !empty($_GET['day'])) ? $_GET['day'] : '21';
if(!is_numeric($month) && !is_numeric($day) || $month <= '03') {
    require('template/error.html');
    die();
}
if(date('m') < $month || ((date('m') <= $month && date('d') < $day))) {
    require('template/error.html');
    die();	
}

$originalUrl = 'http://www.city.nerima.tokyo.jp/kusei/koho/kuho/2011' . $month  . '/2011' . $month  . $day . '.files';
$opts = array(
 'http'=>array(
   'method'=>"GET",
   'header'=>"Accept-language: en\r\n" .
             "Cookie: foo=bar\r\n"
 )
);


$context = stream_context_create($opts);
$n = 1;

for($n = 1; $n <= 8; $n++) {
	if(!file_exists(STORE . '2011' . $month . $day . '_p' . $n . '.txt') || !file_exists(STORE . '2011' . $month . $day . '_p' . $n . '.html')) {
		$url = $originalUrl . '/page' . $n . '.pdf';
		$getUrls[] = $url;
		$file = file_get_contents($url, false, $context);
		$localFile = STORE . $month . $day . 'page' . $n . '.pdf';
		$fp = fopen($localFile, 'w');
		fwrite($fp, $file);
		fclose($fp);
		$html = STORE . '2011' . $month . $day . '_p' .  $n . '.html';
		$txt = STORE . '2011' . $month . $day . '_p' .  $n . '.txt';
		if(!file_exists($html)) {
			shell_exec('/usr/bin/pdftotext ' . $localFile . ' ' . $html . ' -layout');
		}
		if(!file_exists($txt)) shell_exec('/usr/bin/pdftotext  ' . $localFile . ' ' . $txt);
		unlink($localFile);
	}
}
require('template/list.html');

?>