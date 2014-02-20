<?php
$internal_encoding = mb_internal_encoding();
if($internal_encoding != 'JIS'){
	mb_internal_encoding('JIS');
}

$to = 'username@exmple-mobile.com';
$subject = '[Nagios]Status checked : ';
#############################################
## Open or Get Mail ##
$source = file_get_contents("php://stdin");
#$fp = fopen('mail.eml', 'r');
#$source = fread($fp, filesize('mail.eml'));

############################################
if(!$source){
$body = "I can't open and read mail..sorry.";
}
else{
######################################
	preg_match("/Subject:\s.*/", $source, $subjectline);
	preg_match("/\/.*\s/", $subjectline[0], $typeline);
	$type = substr($typeline[0], 1, 4);


	preg_match("/-\s.*\//", $source, $urlline);
	$url = substr($urlline[0], 2);

    switch($type) {
        case 'LOAD':
					$body = "It's LOAD. Do not worry\n";
            break;
        case 'DISK':
					$body = "It's DISK. I can't do anything";
            break;
        case 'HTTP':

				$handle =  fopen('http://'.$url, 'r');
				if($handle == false){
						$subject .= 'OMG';
						$body = "Hey, it's like troble happening.";
				}else{
						$subject .= 'relax..';
						$body = 'Nagios made mistake AGAIN!';
				}
            break;
        default:
            break;
    }

}
$body .= "\n------\n";
$body .= $subjectline[0]."\n";
mb_send_mail($to, $subject, $body);
#	echo $body;
#	echo $subject.$type;
#fclose($fp);
mb_internal_encoding($internal_encoding);

?>