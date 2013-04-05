<?php

class DBConfig {
	
	private static $server = 'localhost';
	private static $username = 'root';
	private static $password = 'welcome1234';
	private static $db = 'cs462_store';
	
	public static function getServer() {
		return self::$server;
	}
	
	public static function getUsername() {
		return self::$username;
	}
	
	public static function getPassword() {
		return self::$password;
	}
	
	public static function getDB() {
		return self::$db;
	}
	
}
