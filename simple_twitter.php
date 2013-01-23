<?php

Class Twitter {
		private $_url;
		private $_resultData;
		private $_searchUrl = 'http://search.twitter.com/search.json?lang=ja&q=';

		public function __construct($url){
			$this->_url = $url;
			$this->_resultData = json_decode(file_get_contents($this->_searchUrl . urlencode($this->_url)));
		}

		public function tweets(){
			return $this->_resultData->results;
		}
		public function tweet_count() {
				return count($this->_resultData->results);
		}

}
?>
