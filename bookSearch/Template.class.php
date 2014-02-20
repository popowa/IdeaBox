<?php
class Template {


      public function renderPriceMail($book) {
      	     	      $body = "
" . $book->ItemAttributes->Title . "
". $book->ItemAttributes->Author . "
" . $book->ItemAttributes->ISBN . "
新本最安値:" . $book->OfferSummary->LowestNewPrice->FormattedPrice . "	
古本最安値:" . $book->OfferSummary->LowestUsedPrice->FormattedPrice . "
----------\n";
				return $body;
				}
				}
?>