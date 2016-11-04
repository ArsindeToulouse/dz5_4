<?php

/**
* 
*/
class ConnectDB{
	private $pdo;
	private $opt;
	
	function __construct(){
		$this->opt = array(
		    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);
	}
	public function getPDO($host, $dbName, $user, $pass){
		$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
		$this->pdo = new PDO($dsn, $user, $pass, $this->opt);
		return $this->pdo;
	}
}