<?php

class Model {
	
	private $name;
	private $database;
	
	public function __construct() {
		$this->name = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', str_replace('Model', '', get_class($this))));
		$this->database = Database::getInstance();
	}
	
	public function select($params = array()) {
		
		$table = $this->getName();
		$fields = isset($params['Fields']) ? $params['Fields'] : '';
		$conditions = isset($params['Conditions']) ? $params['Conditions'] : '';
		$order = isset($params['Order']) ? $params['Order'] : '';
		$limit = isset($params['Limit']) ? $params['Limit'] : '';
		$join = isset($params['Join']) ? $params['Join'] : '';
		
		if(empty($fields)) {
			$fields = '*';
		}
		
		$query = "SELECT $fields FROM $table";
		
		if(!empty($join)) {
			$query .= " $join";
		}
		
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
		
		return $this->database->update($query);
	}
	
	public function delete($id) {
		$table = $this->getName();
		
		$query = "DELETE FROM $table WHERE id = '$id'";
		
		return $this->database->query($query);
	}
	
	public function query($query) {
		return $this->database->query($query);
	}
	
	public function getById($id) {
		return $this->getByField('id', $id);
	}
	
	public function getByField($field, $value) {
		$data = $this->select(array(
			'Conditions' => "$field = '$value'",
			'Limit' => 1
		));
		
		if(empty($data) || empty($data[0])) {
			return false;
		} else {
			return $data[0];
		}
	}
	
	public function getValueByField($field, $value, $col) {
		$data = $this->getByField($field, $value);
		
		if($data === false) {
			return false;
		}
		
		return $data[$col];
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getLastInsertId() {
		return $this->database->getLastInsertId();
	}
	
}
