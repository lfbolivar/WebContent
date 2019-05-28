<?php
/* Created: 07/15/2017
 * Author: LF Bolivar
*
* Class db_image
*/
//  Local config allows for dynamic definition of file paths and single point for private paths
require 'dbConfig_params.php';

class db_image extends PDO {

	private $_db			= NULL;
	private $_dbHost		= NULL;
	private $_dbUser		= NULL;
	private $_dbPass		= NULL;
	private $_dbName		= NULL;
	private $_tbImage		= NULL;

	PRIVATE $_SQL			= NULL;

	private $_iFileID		= NULL;
	private $_iFileAdId		= NULL;
	private $_vchFileName	= NULL;
	private $_vch_FileType	= NULL;
	private $_iFileSize		= NULL;
	private $_bFileContent	= NULL;
	private $_bThumbnail	= Null;

	private $_UserEmail		= NULL;
	private $_UserPassword	= NULL;
	private $_UserName		= NULL;

	/*
	 * __contruct Funtion/Method to initialize database and establish connection to MySQL
	 */
	function __construct($data, $img) {

		$this->_dbHost			=$data['host'];
		$this->_dbUser			=$data['user'];
		$this->_dbPass			=$data['pass'];
		$this->_dbName			=$data['name'];
		$this->_tbImage			=$data['table4'];


		$this->_iFileID			=$img['iFileID'];
		$this->_iFileAdId		=$img['iFileAdId'];
		$this->_vchFileName		=$img['vchFileName'];
		$this->_vchFileType		=$img['vchFileType'];
		$this->_iFileSize		=$img['iFileSize'];
		$this->_bFileContent	=$img['bFileContent'];
		$this->_bThumbnail		=$img['bThumbnail'];
		
		$this->_UserEmail		=$img['UserEmail'];
		$this->_UserPass		=$img['UserPass'];
		$this->_UserName		=$img['UserName'];
		
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
				
		$stmt = $this->_db->prepare("insert into ".$this->_tbImage."
			( iFileID, iFileAdId, vchFileName, vchFileType, iFileSize, bFileContent, bThumbnail)
			VALUES(:iFileID, :iFileAdId, :vchFileName, :vchFileType, :iFileSize, :bFileContent, :bThumbnail)");
		
		$stmt->bindparam(':iFileID',		$this->_iFileID,		PDO::PARAM_INT);
		$stmt->bindParam(':iFileAdId',		$this->_iFileAdId,		PDO::PARAM_INT);
		$stmt->bindParam(':vchFileName',	$this->_vchFileName,	PDO::PARAM_STR);
		$stmt->bindParam(':vchFileType',	$this->_vchFileType,	PDO::PARAM_STR);
		$stmt->bindParam(':iFileSize',		$this->_iFileSize,		PDO::PARAM_INT);
		$stmt->bindParam(':bFileContent',	$this->_bFileContent,	PDO::PARAM_LOB);
		$stmt->bindParam(':bThumbnail'	,	$this->_bThumbnail	,	PDO::PARAM_LOB);
		
		$stmt->execute();
		$affected_rows = $stmt->rowCount();
		return $affected_rows;
		
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
							set	  vchAdCaption		=:AdCaption
								, vchAdHeadLine	 	=:AdHeadline
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
		
		}
	}
		