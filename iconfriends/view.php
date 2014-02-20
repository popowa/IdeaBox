<?php
$status = 0;
$twitterId = $_GET['twitterId'];
$page = $_GET['page'];
if(empty($twitterId)) {
    require('template/error.html');
    die();
}
$page = empty($page) ? 1 : $page;

	$twitterUrl = 'https://api.twitter.com/1/friends/ids.json';
    $apiUri = $twitterUrl . '?screen_name=' . $twitterId;
    $text = @file_get_contents($apiUri);
    if($text == false) {
	    require('template/error.html');
	    die();
	}
    	
    $follows = json_decode($text, true);

    $userUrl = 'http://api.twitter.com/1/users/lookup.json';
    $followsCount = count($follows['ids']);
    $pages = $followsCount/100;
    $start = $page == 1 ? 0 : $page * 100;
    
	$follow100 = implode(',', array_slice($follows['ids'], $start, 100));
	$apiUri2 = $userUrl . '?user_id=' . $follow100;
	$groupDetail = json_decode(file_get_contents($apiUri2), true); 
    require('template/list.html');
?>