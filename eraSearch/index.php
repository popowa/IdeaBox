<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"> 
<html lang="ja"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<meta http-equiv="Pragma" content="no-cache"> 
<meta http-equiv="Content-Style-Type" content="text/css">
<link rev="made" href="mailto:ayakomuro@gmail.com"> 
<title>My Era</title> 
</head> 
<body>

使い方は<br />
index.php?keyword=1980<br />
でリクエストすると、その年代に紐づくイベントを取ってきます。<br />
それだけです。<br />


<?php
$url = 'http://search.yahooapis.jp/PremiumWebSearchService/V1/webSearch';
$key = 'X7GjTNuxg679rwHFM_wJEq_yU.HPawK_1dEJPnORpOoaIIAW1OFP37hL2l54nkpflvhLx7Y-';
$kizUrl = 'http://kizasi.jp/kizapi.py?type=kwic';
$atndUrl = 'http://api.atnd.org/events/';


class Yahoo {
	
	private $URL;
	private $KEY;
	
	public function __construct($url, $key) {
		$this->URL = $url;
		$this->KEY = $key;
	}
	
	public function url($keyword) {
		return 	$this->URL . '?appid=' . $this->KEY . '&query=' . urlencode($keyword);
	}
	
	public function search($keyword) {
		if($keyword == null) return false;
		return simplexml_load_file(self::url($keyword));
	}
}

class Atnd {
	private $URL;
	
	public function __construct($url) {
		$this->URL = $url;	
	}
	public function url($keyword) {
		$searchQuery = (strstr($keyword, ',')) ? 'keyword_or' : 'keyword';
		return 	$this->URL . '?' . $searchQuery . '=' . urlencode($keyword);
	}
	
	public function search($keyword) {
		if($keyword == null) return false;
		return simplexml_load_file(self::url($keyword));
	}
		
}

class kiz {
	
	private $URL;
	
	public function __construct($url) {
		$this->URL = $url;
	}
	
	public function url($keyword) {
		return 	$this->URL . '&kw_expr=' . $keyword;
	}
	
	public function search($keyword) {
		if($keyword == null) return false;
		return simplexml_load_file(self::url($keyword));
	}
}



$keyword = $_GET['keyword'] ? $_GET['keyword'] : '1980';




echo '<h1>' . $keyword . '</h1>';
echo '<pre>';


$yahoo = new Yahoo($url, $key);
$atnd = new Atnd($atndUrl);

$result = $yahoo->search($keyword);
echo '<h2>ネットで探してみた年代数は：' . $result["totalResultsAvailable"] . '</h2>';


echo '<div style="padding: 10px; border: 10px solid orange;"><ul>';
if($result["totalResultsAvailable"]  > 0) {
	foreach($result->Result as $seachEach) {
		echo '<li>' . $seachEach->Title . '<br />' . $seachEach->Summary . '>>詳細を見る</li>';
	}
}

echo '</ul></div>';


$kiz = new kiz($kizUrl);
$kizResult = $kiz->search($keyword);


echo '<div style="padding: 10px; border: 10px solid red;"><ul>';
if(count($kizResult->channel->item)> 0) {
	foreach($kizResult->channel->item as $kizEach) {
		echo '<li>' . $kizEach->title . '>>詳細を見る</li>';
	}
}

echo '</ul></div>';



$event = $atnd->search($keyword);
echo '<div style="padding: 10px; border: 10px solid pink;"><ul>';
if($event->results_returned > 0) {
	foreach($event->events->event as $each) {
		echo '<li>' . substr($each->started_at, 0, 9) . ' : '. $each->title . '<br />' . $each->catch . '>>詳細を見る</li>';
	}
}
echo '</ul></div>';






?>