<?php

class UsersModel extends Model {
	
	public function addUser($data) {
		
		$username = $data['username'];
		$password = $data['password'];
		$firstname = $data['firstname'];
		$lastname = $data['lastname'];

		$query = "INSERT INTO users (username, password, firstname, lastname) VALUES ('$username', '$password', '$firstname', '$lastname');";

		if(!mysql_query($query)) {
			die("Failed to save: " . mysql_error());
		}
		
		return true;
	}
	
	public function getUsers() {
		$query = "SELECT * FROM users";
		
		$result = mysql_query($query);
		
		if(!$result) {
			die("Failed to get users: " . mysql_error());
		}
		
		$users = array();
		
		while($row = mysql_fetch_array($result)) {
			$users[] = $row;
		}
		
		return $users;
	}
}
