<?php

class Database{

	private $connection;
	private static $instance = NULL;

	private function __construct() {
		
		$server = DBConfig::getServer();
		$username = DBConfig::getUsername();
		$password = DBConfig::getPassword();
		$db = DBConfig::getDB();
		
		$this->connection = new mysqli($server, $username, $password, $db);

		if($this->connection->connect_errno) {
			die('Could not connect to database: ' . $this->connection->connect_error);
		}
	}
	
	public function __destruct() {
		$this->connection->close();
	}

	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new Database();
		}

		return self::$instance;
	}
	
	public function select($query) {

		$result = $this->connection->query($query);
		$rows = array();
		
		if(!$result) {
			die($this->connection->error);
		}
		
		while($row = $result->fetch_assoc()) {
			$rows[] = $row;
		}
			
		return $rows;
	}
	
	public function insert($query) {
		return $this->query($query);
	}
	
	public function update($query) {
		return $this->query($query);
	}
	
	public function query($query) {
		return $this->connection->query($query);
	}
	
	public function getLastInsertId() {
		return $this->connection->insert_id;
	}
}
