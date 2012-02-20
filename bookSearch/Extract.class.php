<?php
class Extract {
	private $_source;

	public function __construct($source){
		$this->_source = $source;
	}

	public function getFrom() {
		preg_match("/From:.*/", $this->_source, $fromline);
		preg_match("/[-\+\w](\\.?[-\+\w])*@[-\+\w]+(\.[-\+\w]+)*(\.[a-zA-Z]{2,4})/", $fromline[0], $from);
		return $from[0];
	}


     public function getSubject(){
	      if(strpos($this->_source, 'Missing Subject')) {
		      return false;
	     }
	     else {
	             preg_match("/Subject:\s.*\n/", $this->_source, $subjectline);
	         $subject = substr($subjectline[0], 9);
	             $subject = mb_decode_mimeheader($subject);
	             return $subject;        
	     }
	 }
     public function getBody(){
         $split = explode("\n\n", $this->_source);
         return preg_split("/[\s,]+/", mb_convert_kana(rtrim($split[1]), "s"));
     }
    

}
?>