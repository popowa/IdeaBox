<?php
class TestClass {
　private $data;

　 function __construct( $param1 ) {
　　$this->data = $param1;
　}
　public function getData() {
　　return $this->data;
　}
}

$obj = new TestClass( "abc" );
print "プロパティ取得：" . $obj->getData() . "\n";
?>

