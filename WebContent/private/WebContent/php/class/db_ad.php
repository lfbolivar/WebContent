<?php
/* Created: 10/29/2016
 * Author: LF Bolivar
 *
 * Class db_ad
 */
//  Local config allows for dynamic definition of file paths and single point for private paths
require 'dbConfig_params.php';

class db_ad extends PDO {

	private $_db			= NULL;
	private $_dbHost		= NULL;
	private $_dbUser		= NULL;
	private $_dbPass		= NULL;
	private $_dbName		= NULL;
	private $_tbAd			= NULL;
	
	PRIVATE $_SQL			= NULL;

	private $_AdId			= NULL;
	private $_AdCategory	= NULL;
	private $_AdPeriod		= NULL;
	private $_AdCaption		= NULL;
	private $_AdHeadline	= NULL;
	private $_AdNoUpload	= NULL;
	private $_AdDesc		= NULL;
	private $_AdURL			= NULL;
	private $_AdValid		= NULL;

	private $_UserEmail		= NULL;
	private $_UserPassword	= NULL;
	private $_UserName		= NULL;
	
	/*
	 * __contruct Funtion/Method to initialize database and establish connection to MySQL
	 */
	function __construct($data, $ad) {

		$this->_dbHost			=$data['host'];
		$this->_dbUser			=$data['user'];
		$this->_dbPass			=$data['pass'];
		$this->_dbName			=$data['name'];
		$this->_tbAd			=$data['table3'];

		$this->_AdCaption		=$ad['AdCaption'];
		$this->_AdHeadline		=$ad['AdHeadline'];
		$this->_AdDesc			=$ad['AdDesc'];
		$this->_AdURL			=$ad['AdURL'];
		$this->_AdExpireDate	=$ad['AdExpireDate'];
		$this->_AdPeriod		=$ad['AdPeriod'];
		$this->_AdCatId			=$ad['AdCatId'];
		$this->_AdValid			=$ad['AdValid'];
		$this->_AdId			=$ad['AdId'];

		$this->_UserEmail		=$ad['UserEmail'];
		$this->_UserPass		=$ad['UserPass'];
		$this->_UserName		=$ad['UserName'];
		
		// Connects to the Database provided
		$dsn = "mysql:host=".$this->_dbHost.";dbname=".$this->_dbName;
		$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
		$this->_db = new PDO($dsn,$this->_dbUser,$this->_dbPass,$options);
		$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
/*		$this->mysqli = new mysqli($this->_dbHost,$this->_dbUser,$this->_dbPass,$this->_dbName) 
			or die('db_category '.$this->_dbName.' Connection error: '.mysqli_connect_error().' ');
		
		$this->mysqli->select_db($this->_dbName) 
			or die('db_category '.$this->_dbName.' mysqli_select_db error: '.mysqli_error($this->mysqli).' ');

		// Internal UTF-8
		$this->mysqli->query ( "SET NAMES 'utf8'" );
		$this->mysqli->query ( 'SET character_set_connection=utf8' );
		$this->mysqli->query ( 'SET character_set_client=utf8' );
		$this->mysqli->query ( 'SET character_set_results=utf8' );
*/
	}
	/*
	 * create() Funtion/Method to create an Ad table row
	 */
	function create($data){
		
	}

	/*
	 * read() Funtion/Method to select an Ad table row
	 */
	function read(){
		
	}
	/*
	 * update() Funtion/Method to update an Ad table row
	 */
	function update(){

		$stmt = $this->_db->prepare("update ".$this->_tbAd."
				                     set vchAdCaption	=:AdCaption
				                       , vchAdHeadLine 	=:AdHeadline
				                       , vchAdDesc 		=:AdDesc
				                       , vchAdURL 		=:AdURL
				                       , dtAdExpireDate =:AdExpireDate
				                       , iAdPeriod		=:AdPeriod
				                       , vchUserEmail	=:UserEmail
			                           , vchUserPassword=:UserPass
				                       , vchAdUserName	=:UserName
				                       , iAdCatId		=:AdCatId
				                       , tiAdValid		=:AdValid
				                     WHERE iAdId		=:AdId");

		$stmt->bindParam(':AdCaption',		$this->_AdCaption,		PDO::PARAM_STR);
		$stmt->bindParam(':AdHeadline',		$this->_AdHeadline,		PDO::PARAM_STR);
		$stmt->bindParam(':AdDesc',			$this->_AdDesc,			PDO::PARAM_STR);
		$stmt->bindParam(':AdURL',			$this->_AdURL,			PDO::PARAM_STR);
		$stmt->bindParam(':AdExpireDate',	$this->_AdExpireDate,	PDO::PARAM_STR);
		$stmt->bindparam(':AdPeriod',		$this->_AdPeriod,		PDO::PARAM_INT);
		$stmt->bindParam(':UserEmail',		$this->_UserEmail,		PDO::PARAM_STR);
		$stmt->bindParam(':UserPass',		$this->_UserPass,		PDO::PARAM_STR);
		$stmt->bindParam(':UserName',		$this->_UserName,		PDO::PARAM_STR);
		$stmt->bindparam(':AdCatId',		$this->_AdCatId,		PDO::PARAM_INT);
		$stmt->bindparam(':AdValid',		$this->_AdValid,		PDO::PARAM_INT);
		$stmt->bindparam(':AdId',			$this->_AdId,			PDO::PARAM_INT);
		$stmt->execute();
		$affected_rows = $stmt->rowCount();
		return $affected_rows;
/*		
		$this->_SQL = sprintf("update %s set vchAdCaption = '%s'
				                           , vchAdHeadLine = '%s'
				                           , vchAdDesc = '%s'
				                           , vchAdURL = '%s'
				                           , dtAdExpireDate = '%s'
				                           , iAdPeriod = %d
				                           , vchUserEmail = '%s'
				                           , vchUserPassword = '%s'
				                           , vchAdUserName = '%s'
				                           , iAdCatId = %d
				                           , tiAdValid = %d
				              WHERE iAdId = %d"
				                           , $this->_tbAd
				                           , $this->_AdCaption
				                           , $this->_AdHeadline
				                           , $this->_AdDesc
				                           , $this->_AdURL
				                           , $this->_AdExpireDate
				                           , $di
				                           , $this->_AdUserEmail
				                           , $this->_AdUserPassword
				                           , $this->_AdUserName
				                           , $this->_AdCategory
				                           , $this->_nAdValid
				                           , $this->_AdId);
		$check = $this->mysqli->query($this_SQL)
		or die('class=db_ad method=update(): '.mysqli_error($this->mysqli));
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
		*/
		
	}
	/*
	 * delete() Funtion/Method to delete an Ad table row
	 */
	function delete(){
	
	}
}
