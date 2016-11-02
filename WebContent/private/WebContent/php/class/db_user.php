<?php
/* Created: 7/11/2016
 * Author: LF Bolivar
 * 
 * Class db_user
 */
require "iCRUD.php";
//  Local config allows for dynamic definition of file paths and single point for private paths
require 'dbConfig_params.php';

class db_user implements iCRUD {
	
	private $_dbHost = NULL;
	private $_dbUser = NULL;
	private $_dbPass = NULL;
	private $_dbName = NULL;
	private $_dbTable = NULL;
	
	private $_userID = NULL;
	private $_userEmail = NULL;
/*
 * __contruct Funtion/Method to initialize database and establish connection to MySQL
 */	 
	function __construct($data) {

		$this->_dbHost =$data['host'];
		$this->_dbUser =$data['user'];
		$this->_dbPass =$data['pass'];
		$this->_dbName =$data['name'];
		$this->_dbTable=$data['table'];
		$this->_userEmail =$data['semail'];
		
		// Connects to the Database provided
		$this->mysqli = new mysqli($this->_dbHost,$this->_dbUser,$this->_dbPass,$this->_dbName) or
			die('MySQL DB '.$this->_dbName.' Connection error: '.mysqli_connect_error().' ');
		$this->mysqli->select_db($this->_dbName) or
			die('MySQL DB '.$this->_dbName.' mysqli_select_db error: '.mysqli_error($this->mysqli).' ');

		// Internal UTF-8
		$this->mysqli->query ( "SET NAMES 'utf8'" );
		$this->mysqli->query ( 'SET character_set_connection=utf8' );
		$this->mysqli->query ( 'SET character_set_client=utf8' );
		$this->mysqli->query ( 'SET character_set_results=utf8' );
		
	}

	/*
	 * Function/Method to add new user to database
	 */
	function create($data) {
		
	}

	/*
	 * Function/Method to read user row by email key passed by __construct()
	 */
	function read(){
		$check = $this->mysqli->query("SELECT * FROM ".$this->_dbTable."
											WHERE vchEmail = '$this->_userEmail'")
				or die("select user mysql error -1- : ".mysqli_error($this->mysqli));
				
				// Gives error if user doesn't exist
				//$qry_param = mysqli_affected_rows($this->link);
				if ($check->num_rows == 0){
					return 0;
				} else {
					$result = array();
					while($info = $check->fetch_array()){
						$result['logonName'] = $info['vchFirstName']." ".$info['vchLastName'];
						$result['logonPass'] = $info['vchPassword'];
						$result['logonEmail']= $info['vchEmail'];
					}
					return $result;
				}
				//return $qry_param;
	}

	/*
	 * Function/Method to update user table
	 */
	function update($data) {
		
	}

	/*
	 * Function/Method to delete user table
	 */
	function delete() {
		
	}
	
}