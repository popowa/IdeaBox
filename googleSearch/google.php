#!/usr/bin/php5
<?php
## Load Zend Framework##

	date_default_timezone_set('Asia/Tokyo');
    #Zend Frameworkを指定します。
	define('FW_HOME', '/var/www/script/fw/');
	define('APP_HOME', '/var/www/script/google/');

	require_once(FW_HOME . 'boot.php');
	require_once(APP_HOME . 'Database.class.php');
	require_once(APP_HOME . 'Extract.class.php');

	$internal_encoding = mb_internal_encoding();
   if($internal_encoding != 'JIS'){
   	mb_internal_encoding('JIS');
	}

############################################
## create random string for key ###########
function getRandString($num = 10){
	$list = 'abcdefjhijklnmopqrstuvwxyzABCDEFJHIJKLNMOPQRSTUVWXYZ01234565789';
	$rs = '';
	for($i =0; $i < $num; $i++) $rs .= $list[mt_rand(0, strlen($list)-1)];
	return $rs;
}

#############################################
## Open or Get Mail ##

$source = file_get_contents("php://stdin");

############################################
if(!$source){
	mail('user@example.com', 'ERROR', 'php stdin error');
}
else{
	######################################
	$ex = new Extract($source);
	$from = $ex->getFrom();
	$subject = $ex->getSubject();

	## Get google results ###############
	$uri = 'http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q='.urlencode($subject);
	$data = Zend_Json::decode(file_get_contents($uri));
	$results = (array) $data['responseData']['results'];

	######################################

    $body = "Search <".$subject."> and find <".$data['responseData']['cursor']['estimatedResultCount']."> results\n";
    $body .= "----------\n";
	$body .= $uri."\n";
	$body .= "-----------\n";

	$db = DbManager::getConnection();
	foreach ($results as $k => $v){
	 $tmpKey = getRandString();
	 $body .= $v['titleNoFormatting']."\n";
	 $body .= "gs" . $tmpKey ."@example.com \n";
       	 $body .= $v['content']."\n";
	 $body .= $v['unescapedUrl']."\n";
	 $body .= "----------\n";
	 $db->query("INSERT INTO search VALUES(created, created_by, randkey, uri)", $from, array(AX_Date::dbDatetime(), 'gs'.$tmpKey, htmlspecialchars($v['unescapedUrl'], ENT_QUOTES)));
	}
	mb_send_mail($from, $subject, $body);
}
mb_internal_encoding($internal_encoding);
?>