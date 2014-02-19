<?php
$url = $_GET['url'];

if(empty($url)) {
    require('template/error.html');
    die();
}
    $urlSplit = parse_url($url);
    $eventArray = explode('/', $urlSplit['path']);
    if(empty($eventArray[2]) || !is_numeric($eventArray[2])) {
        require('template/error.html');
        die();
    }
    $eventId = $eventArray[2];
    $apiUri = 'http://api.atnd.org/events/users/?event_id=' . $eventId;
    $text = simplexml_load_file($apiUri);
	echo '<pre>';
	var_dump($text);
?>