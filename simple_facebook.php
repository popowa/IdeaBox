<?php
Class Facebook {
	private $_url;
	private $_link_stat;
	private $_result;

	public function __construct($url){
		$this->_url = $url;
		$ch = curl_init();
		$parse_url = 'https://api.facebook.com/method/fql.query?query=select%20%20like_count,share_count,total_count%20from%20link_stat%20where%20url="' . urlencode($this->_url) . '"';
		curl_setopt($ch, CURLOPT_URL, $parse_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$this->result = curl_exec($ch);
		curl_close($ch);
		$like_data = simplexml_load_string($this->result);
		$this->_link_stat = $like_data->link_stat;
}
	public function like_count() {
		return $this->_link_stat->like_count;
	}
	public function share_count() {
		return $this->_link_stat->share_count;
	}

	public function total_count(){
		return $this->_link_stat->total_count;
	}
}
?>
