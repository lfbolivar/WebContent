<?php
/* Created: 7/11/2016
 * Author: LF Bolivar
 *
 * Class db_user
 */
require_once "iCRUD.php";
//  Local config allows for dynamic definition of file paths and single point for private paths
require 'dbConfig_params.php';

class db_category implements iCRUD {

	private $_dbHost = NULL;
	private $_dbUser = NULL;
	private $_dbPass = NULL;
	private $_dbName = NULL;
	private $_dbPort   = NULL;
	private $_dbCategory = NULL;
//	private $_dbAd = NULL;

	/*
	 * __contruct Funtion/Method to initialize database and establish connection to MySQL
	 */
	function __construct($data) {

		$this->_dbHost     =$data['host'];
		$this->_dbUser     =$data['user'];
		$this->_dbPass     =$data['pass'];
		$this->_dbName     =$data['name'];
		$this->_dbCategory =$data['table5'];
		$this->_dbPort     =$data['port'];
		

		// Connects to the Database provided
		$this->mysqli = new mysqli($this->_dbHost,$this->_dbUser,$this->_dbPass,$this->_dbName,$this->_dbPort) or
		die('db_category '.$this->_dbName.' Connection error: '.mysqli_connect_error().' ');
		$this->mysqli->select_db($this->_dbName) or
		die('db_category '.$this->_dbName.' mysqli_select_db error: '.mysqli_error($this->mysqli).' ');

		// Internal UTF-8
		$this->mysqli->query ( "SET NAMES 'utf8'" );
		$this->mysqli->query ( 'SET character_set_connection=utf8' );
		$this->mysqli->query ( 'SET character_set_client=utf8' );
		$this->mysqli->query ( 'SET character_set_results=utf8' );

	}
	function create($data){}
	
	function read(){
	
		$check = $this->mysqli->query("SELECT CatId, CatDesc FROM ".$this->_dbCategory." order by 2")
		or die('-load_category_array class- '.mysqli_error($this->mysqli).' db_category.php Error on Select of Category table.');
		if ($check->num_rows == 0){
			return 0;
		} else {
			$result = array();
		}
		while($CatRow = $check->fetch_array()) {
			// Loop and display each item detail for given category
			$result[$CatRow['CatId']] = $CatRow['CatDesc'];
		}
		return $result;
	
	}
	function update($data) {}
	
	function delete(){}
	


}