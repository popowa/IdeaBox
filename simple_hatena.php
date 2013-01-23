<?php
Class Hatena {
	private $_url;
	private $_result;
	
	public function __construct($url){
		$this->_url = $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://api.b.st-hatena.com/entry.count?url=' . urlencode($this->_url));
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$this->_result = curl_exec($ch);
		curl_close($ch);
	}

	public function link(){
		return $this->_url;
	}


	public function bookmark_count(){
		return $this->_result;
	}
}
?>
