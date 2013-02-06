<?php

class Database{

	private $connection;
	private static $instance = NULL;

	private function __construct() {
		$this->connection = new mysqli('localhost', 'root', 'welcome1234', 'cs462');

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
		
		$result = $this->connection->query($query);
				
		if(!$result) {
			die($this->connection->error);
		}
		
		return $result;
	}
	
	public function update($query) {
		$result = $this->connection->query($query);
		
		if(!$result) {
			die($this->connection->error);
		}
		
		return $result;
	}
}
