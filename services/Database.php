<?php
/*
* Mysql database class - only one connection allowed
*/
class Database {
	private $_connection;
	private static $_instance; //The single instance
	private $_host = "localhost";
	private $_username = "root";
	private $_password = "root";
	private $_database = "tictock";
	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance() {

		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	// Constructor
	private function __construct() {
		if($_SERVER['HTTP_HOST']!='tictock.local')
		{
			//mysql://b222d8833f4b8c:25ce1b5d@us-cdbr-iron-east-03.cleardb.net/heroku_af250eff4a217bc?reconnect=true
			$this->_host = "us-cdbr-iron-east-03.cleardb.net";
			$this->_username = "b222d8833f4b8c";
			$this->_password = "25ce1b5d";
			$this->_database = "heroku_af250eff4a217bc";
			
		}

		$this->_connection = new mysqli($this->_host, $this->_username, 
			$this->_password, $this->_database);
	
		// Error handling
		if(mysqli_connect_error()) {
			trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
				 E_USER_ERROR);
		}
	}
	// Magic method clone is empty to prevent duplication of connection
	private function __clone() { }
	// Get mysqli connection
	public function getConnection() {
		return $this->_connection;
	}
}

?>