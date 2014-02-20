#!/usr/bin/php5
<?php
    
    date_default_timezone_set('Asia/Tokyo');
    define('APP_HOME', '/var/www/script/book_search/');
    
    require_once(APP_HOME . 'Template.class.php');
    require_once(APP_HOME . 'Extract.class.php');	
    require_once(APP_HOME . 'Amazon.class.php');
    require_once(APP_HOME . 'config.php');
    
    $internal_encoding = mb_internal_encoding();
    if($internal_encoding != 'UTF-8'){
        mb_internal_encoding('UTF-8');
	}

#############################################
## Open or Get Mail ##

$source = file_get_contents("php://stdin");
#$fp = fopen(APP_HOME . 'mail.eml', 'r');
#$source = fread($fp, filesize('mail.eml'));


############################################
if(!$source){
	mail('book_price@example.com', 'ERROR', 'php stdin error');
}
else{
	######################################
	$ex = new Extract($source);
	$from = $ex->getFrom();

	$subject = $ex->getSubject();
    if(!$subject) {
        $searchKeyword = implode("+", $ex->getBody());    
    }
    else {
        $searchKeyword = $subject;    
    }

	$itemId = preg_replace('/\-/', '', $searchKeyword);
	if(preg_match("/isbn/i", $itemId) || is_numeric($itemId)) {	
		$data['idType'] = 'ISBN';
      $data['itemId'] = preg_replace('/isbn/i', '', $itemId);
      $data['searchIndex'] = "Books";
      $operation = 'ItemLookup';
	}
   elseif (preg_match("/asbn/i", $itemId) || strlen(preg_replace('/asbn/i', '', $itemId)) == 10) {
      $data['idType'] = 'ASIN';
      $data['itemId'] = preg_replace('/asbn/i', '', $itemId);      
      $operation = 'ItemLookup';
   }
   else {
   	$data['keywords'] = $itemId;
      $data['searchIndex'] = "Books";
      $operation = 'ItemSearch';
   }


        #### Open up amazon API ##################################
        $amazon = new Amazon($config['accessKeyId'], $config['associateTag'],  $config['secretAccessKey']);
   		$product = $amazon->itemSearch($operation, $data,  array('ItemAttributes', 'Small', 'OfferSummary'));

        ######################################

   $subject = $searchKeyword." の相場をお知らせします。";
	$body = "検索キーワード　:" .  $searchKeyword . "\n";
	$template = new Template();
	if(isset($data['keywords'])) {
		$body .= $product->Items->TotalResults ."件見つかりました\n";
			foreach($product->Items->Item as $book) {
				$body .= $template->renderPriceMail($book);
			}
	}
	else {
		$body .= $template->renderPriceMail($product->Items->Item);
	}
	mb_send_mail($from, $subject, $body);
}
mb_internal_encoding($internal_encoding);
?>