<?php
class Extract {
	private $_source;

	public function __construct($source){
		$this->_source = $source;
	}

	public function getFrom() {
	    preg_match("/From\s.[-\+\w](\\.?[-\+\w])*@[-\+\w]+(\.[-\+\w]+)*(\.[a-zA-Z]{2,4})/", $this->_source, $fromline);
    	    preg_match("/[-\+\w](\\.?[-\+\w])*@[-\+\w]+(\.[-\+\w]+)*(\.[a-zA-Z]{2,4})/", $fromline[0], $from);
	    return $from[0];
	}

	public function getSubject(){
		preg_match("/Subject:\s.*/", $this->_source, $subjectline);
                $subject = substr($subjectline[0], 9);
		$subject = mb_decode_mimeheader($subject);
		return $subject;
	}

    public function getCritialItem(){
		preg_match("/Subject:\s.*/", $this->_source, $subjectline);
		preg_match("/\//", subjectline, $itemline);
        $item = substr($itemline[0], 5);
		$item = mb_decode_mimeheader($item);
		return $item;
    }

	public function getUrl(){
        preg_match("/-\s.*\//", $this->_source, $urlline);
        $url = substr($urlline[0], 2);
		$url = mb_decode_mimeheader($url);
		return $url;
	}


}
?>