<?php

class Model {
	
	private $name;
	private $database;
	
	public function __construct() {
		$this->name = strtolower(str_replace('Model', '', get_class($this)));
		$this->database = Database::getInstance();
	}
	
	public function select($params = array()) {
		
		$table = $this->getName();
		$fields = isset($params['Fields']) ? $params['Fields'] : '';
		$conditions = isset($params['Conditions']) ? $params['Conditions'] : '';
		$order = isset($params['Order']) ? $params['Order'] : '';
		$limit = isset($params['Limit']) ? $params['Limit'] : '';
		
		if(empty($fields)) {
			$fields = '*';
		}
		
		$query = "SELECT $fields FROM $table";
		
		if(!empty($conditions)) {
			$query .= " WHERE $conditions";
		}
		
		if(!empty($order)) {
			$query .= " ORDER BY $order";
		}
		
		if(!empty($limit)) {
			$query .= " LIMIT $limit";
		}
		
		return $this->database->select($query);
	}
	
	public function insert($data) {
		
		$table = $this->getName();
		
		$query = "INSERT INTO $table";
		
		$query .= " (" . implode(", ", array_keys($data)) . ")";
		
		$query .= " VALUES ('" . implode("', '", $data) . "');";
		
		return $this->database->insert($query);
		
	}
	
	public function update($data) {
		
		$id = $data['id'];
		
		if(empty($id)) {
			return 0;
		}
		
		$table = $this->getName();
		
		$query = "UPDATE $table SET";
		
		foreach($data as $key => $value) {
			$query .= " $key='$value',";
		}
		
		$query = rtrim($query, ',');
		
		$query .= " WHERE $table.id='$id';";
		
		error_log("query: " . $query);
		
		return $this->database->update($query);
	}
	
	public function delete($id) {
		$table = $this->getName();
		
		$query = "DELETE FROM $table WHERE id = '$id'";
		
		return $this->database->query($query);
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getLastInsertId() {
		return $this->database->getLastInsertId();
	}
	
}
