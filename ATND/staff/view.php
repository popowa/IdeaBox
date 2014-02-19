<?php
$status = 0;
$users = $_GET['users'];
$print = (isset($_GET['print']) && !empty($_GET['print'])) ? $_GET['print'] : 'full';

if(empty($users)) {
    require('template/error.html');
    die();
}
$usersInfo = array();
    $userArray = explode(',', $users);
	foreach($userArray as $k => $user) {
		//$apiUri = 'http://api.twitter.com/1/users/show.xml?screen_name=' . $user;
	    $apiUri = 'http://api.twitter.com/1/users/show/' . $user . '.xml';
	    $text = simplexml_load_file($apiUri);
	    $usersInfo[] = $text;
	}
   require('template/list.html');
?>