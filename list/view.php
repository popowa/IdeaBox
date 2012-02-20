<?php
$status = 0;
$url = $_GET['url'];
//$column = (isset($_GET['column']) && !empty($_GET['column'])) ? $_GET['column'] : '2';
$class = (isset($_GET['class']) && !empty($_GET['class'])) ? $_GET['class'] : 'simple';
//$type = (isset($_GET['type']) && !empty($_GET['type'])) ? $_GET['type'] : 'tag';
$eventImg = (isset($_GET['eventImg']) && $_GET['eventImg'] == 1 )? true: false;
$attend = (isset($_GET['attend']) && is_numeric($_GET['attend'])) ? $_GET['attend'] : '';
$afterparty = (isset($_GET['afterparty']) && ($_GET['afterparty']) == 'on') ? true : false;
$payment = (isset($_GET['payment']) && ($_GET['payment']) == 'on') ? true : false;


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
    $title = $text->events->event->title;
    $users = $text->events->event->users->user;
    $hash_tag = ($text->events->event->hash_tag) ? $text->events->event->hash_tag : '';
	$missingImg = 'http://atnd.org/images/icon/atnd_latent.png';
    if(!empty($_GET['eventImg']) && $eventImg == 1) {
    $data = file_get_contents($text->events->event->event_url);
    preg_match('/<div class="events-show-img"><img alt=\"([^\"]+)\" src=\"([^\"]+)\" \/><\/div>/', $data, $imgMatches);
    $eventImg = 'http://atnd.org' . $imgMatches[2];
    }
    require('template/list.html');
?>