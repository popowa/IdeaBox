<?php
require_once('simple_facebook.php');
require_once('simple_hatena.php');
require_once('simple_twitter.php');

Class Challenger {
		private $_userId;
		private $_postData;
		private $_postCount = 0;
		private $_replacedUrl;
		private $_localUrl = '192.168.0.10/~komuro/wordpress/';
		private $_prodUrl = 'blog.serverworks.co.jp/tech/';
		private $_tweetData;

	public function __construct($userId){
		$this->_userId = $userId;
		$this->_postData = new WP_Query('author=' . $this->_userId);
	}

	public function postData(){
		return $this->_postData;
	}
	public function urlReplace($url){
		$this->_replacedUrl = str_replace($this->_localUrl, $this->_prodUrl, $url);
		return $this->_replacedUrl;
	}
	
	public function facebook(){
		$fb = new Facebook($this->_replacedUrl);
		$this->_facebookData = $fb;
		return $this->_facebookData;
	}

	public function like_count(){
		return $this->_facebookData->like_count();
	}
	public function share_count(){
		return $this->_facebookData->share_count();
	}

	public function hatena(){
		$ht = new Hatena($this->_replacedUrl);
		return $ht->bookmark_count();
	}
	public function twitter(){
		$tw = new Twitter($this->_replacedUrl);
		return $tw;
	}

	public function post_count() {
		return $this->_postData->post_count;
	}
}
?>


