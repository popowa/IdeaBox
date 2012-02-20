<?php
class DbManager {

	public static function getConnection() {
		$db = null;
		try {
		$config = new Zend_Config_Ini( APP_HOME . 'db.ini', 'database');
		$db = Zend_Db::factory($config);
		$db->query('SET CHARACTER SET utf8');
		} catch (Zend_Exception $e) {
		die($e->getMessage());
		}
	return $db;
	}
}

?>