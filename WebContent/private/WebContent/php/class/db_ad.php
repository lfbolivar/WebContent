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
		
	}
	/*
	 * create() Funtion/Method to create an Ad table row
	 */
	function create(){
		
		$stmt = $this->_db->prepare("insert into ".$this->_tbAd."
				( iAdId, vchAdCaption, vchAdHeadLine, vchAdDesc, vchAdURL, dtAdExpireDate
				, iAdPeriod, vchUserEmail, vchUserPassword, vchAdUserName, iAdCatId, tiAdValid)
				VALUES(:AdId, :AdCaption, :AdHeadline, :AdDesc, :AdURL, :AdExpireDate
				     , :AdPeriod, :UserEmail, :UserPass, :UserName, :AdCatId, :AdValid)");
		
		$stmt->bindparam(':AdId',			$this->_AdId,			PDO::PARAM_INT);
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
		$stmt->execute();
		$affected_rows = $stmt->rowCount();
		if ($affected_rows == 0){
			return 0;
		} else {
			return $this->_db->lastInsertId();
		}	
	}

	/*
	 * read() Funtion/Method to select an Ad table row
	 */
	function read(){
/*		$query = "SELECT iAdId 'Ad' FROM ".$tbl_name3." WHERE vchUserEmail = '$sessionEmail' and vchUserPassword = '$sessionPass' and $AdId = iAdId";*/
		$stmt = $this->_db->prepare("select * from ".$this->_tbAd."
				                     WHERE iAdId		=:AdId");
		
		$stmt->bindparam(':AdId',		$this->_AdId,			PDO::PARAM_INT);

		$stmt->execute();
		$result = array();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if (empty($result) ){
			return 0;
		} else {
			return $result;
		}
		
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
	}
	/*
	 * delete() Funtion/Method to delete an Ad table row
	 */
	function delete(){
		
		$stmt = $this->_db->prepare("delete from ".$this->_tbAd."
				                     WHERE iAdId		=:AdId");
		
		$stmt->bindparam(':AdId',		$this->_AdId,			PDO::PARAM_INT);
		
		$stmt->execute();
		$affected_rows = $stmt->rowCount();
		return $affected_rows;
		
	}
}
