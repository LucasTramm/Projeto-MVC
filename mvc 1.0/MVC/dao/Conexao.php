<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Conexao {

	public static $instance;

	public static function getInstance() {

		if (!isset(self::$instance)) {
			self::$instance = new PDO('mysql:host=localhost;dbname=projeto-mvc', 'root', '');
			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
		}

		return self::$instance;
	}
}

?>