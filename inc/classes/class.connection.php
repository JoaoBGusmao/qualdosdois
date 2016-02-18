<?php

	class connection extends PDO { 
	private static $instance; 
	
	public function __construct() { 
	// 
	} 
	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING); 
		}
		return self::$instance; 
	}

}