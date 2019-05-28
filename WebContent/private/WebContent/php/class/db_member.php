<?php
/* Created: 11/27/2016
 * Author: LF Bolivar
*
* Class db_member
*/
// require_once "iCRUD.php";
//  Local config allows for dynamic definition of file paths and single point for private paths
require 'dbConfig_params.php';

class db_member extends PDO {

	private $_db			= NULL;
	private $_dbHost		= NULL;
	private $_dbUser		= NULL;
	private $_dbPass		= NULL;
	private $_dbName		= NULL;
	private $_tbMember		= NULL;

	private $_MemberEmail	= NULL;
	private $_MemberPass	= NULL;
	private $_MemberRegDate	= NULL;
	/*
	 * __contruct Funtion/Method to initialize database and establish connection to MySQL
	 */
	function __construct($data, $member) {

		$this->_dbHost			=$data['host'];
		$this->_dbUser			=$data['user'];
		$this->_dbPass			=$data['pass'];
		$this->_dbName 			=$data['name'];
		$this->_tbMember		=$data['table1'];

		$this->_MemberEmail		=$member['semail'];
		$this->_MemberPass		=$member['spass'];
		$this->_MemberRegDate	=$member['sregdate'];

		// Connects to the Database provided
		$dsn = "mysql:host=".$this->_dbHost.";dbname=".$this->_dbName;
		$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
		$this->_db = new PDO($dsn,$this->_dbUser,$this->_dbPass,$options);
		$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
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
		$stmt = $this->_db->prepare("SELECT vchEmail
				                           ,vchPassword
				                           ,dtRegistered
				                     FROM ".$this->_tbMember."
				                     WHERE vchEmail =:MemEmail");		
		$stmt->bindParam(':MemEmail',		$this->_MemberEmail,		PDO::PARAM_STR);
		$stmt->execute();
		$affected_rows = $stmt->fetchAll();
		return $affected_rows;
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