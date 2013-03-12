<?php

class SettingsModel extends Model {
	
	public function getValue($name, $default = null) {
		$results = $this->select(array(
			'Conditions' => "name = '$name'",
			'Limit' => 1
		));
		
		if(empty($results) || empty($results[0]) || empty($results[0]['value'])) {
			return $default;
		}
		
		return $results[0]['value'];
	}
	
	public function setValue($name, $value) {
		$results = $this->query("REPLACE INTO " . $this->getName() . " SET name = '" . $name . "', value = '" . $value . "'");
		
		return $results;
	}
}
