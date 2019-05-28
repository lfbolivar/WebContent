<?php
/* Created: 7/30/2017
 * Author: LF Bolivar
*
* Class db_user_pdo
*/
// require_once "iCRUD.php";
//  Local config allows for dynamic definition of file paths and single point for private paths
require 'dbConfig_params.php';

class db_user_pdo extends PDO {

	private $_db			= NULL;
	private $_dbHost		= NULL;
	private $_dbUser		= NULL;
	private $_dbPass		= NULL;
	private $_dbName		= NULL;
	private $_tbMember		= NULL;

	private $_MemberEmail	= NULL;
	private $_MemberPass	= NULL;
	private $_MemberRegDate	= NULL;
	
	private $_UserId		= NULL; 
	private $_UserEmail 	= NULL; 
	private $_FirstName 	= NULL;
	private $_LastName 		= NULL;
	private $_Address1 		= NULL;
	private $_Address2 		= NULL;
	private $_Address3 		= NULL;
	private $_City 			= NULL;
	private $_State 		= NULL; 
	private $_Phone 		= NULL; 
	private $_Pass 			= NULL;
	private $_RegModified 	= NULL;
	private $_Num_ads 		= NULL;
	private $_Country 		= NULL;  
	private $_Hide_mail 	= NULL;
	private $_Zip 			= NULL;
	private $_Usr_1 		= NULL;
	private $_Usr_2 		= NULL;
	private $_Usr_3 		= NULL;
	private $_Usr_4 		= NULL;
	private $_Usr_5 		= NULL;
	private $_Usr_6 		= NULL;
	private $_Registered 	= NULL;
	/*
	 * __contruct Funtion/Method to initialize database and establish connection to MySQL
	 */
	function __construct($data, $member) {

		$this->_dbHost			=$data['host'];
		$this->_dbUser			=$data['user'];
		$this->_dbPass			=$data['pass'];
		$this->_dbName 			=$data['name'];
		$this->_tbUser			=$data['table2'];

		$this->_MemberEmail		=$member['semail'];
		$this->_MemberPass		=$member['spass'];
		$this->_MemberRegDate	=$member['sregdate'];
		
		$this->_UserId			= $member['UserId'];
		$this->_UserEmail 		= $member['UserEmail'];
		$this->_FirstName 		= $member['FirstName'];
		$this->_LastName 		= $member['LastName'];
		$this->_Address1 		= $member['Address1'];
		$this->_Address2 		= $member['Address2'];
		$this->_Address3 		= $member['Address3'];
		$this->_City 			= $member['City'];
		$this->_State 			= $member['State'];
		$this->_Phone 			= $member['Phone'];
		$this->_UserPass 		= $member['UserPass'];
		$this->_RegModified 	= $member['RegModified'];
		$this->_Num_ads 		= $member['Num_ads'];
		$this->_Country 		= $member['Country'];
		$this->_Hide_mail 		= $member['Hide_mail'];
		$this->_Zip 			= $member['Zip'];
		$this->_Usr_1 			= $member['Usr_1'];
		$this->_Usr_2 			= $member['Usr_2'];
		$this->_Usr_3 			= $member['Usr_3'];
		$this->_Usr_4 			= $member['Usr_4'];
		$this->_Usr_5 			= $member['Usr_5'];
		$this->_Usr_6 			= $member['Usr_6'];
		$this->_Registered 		= $member['Registered'];

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
	function create() {
		$stmt = $this->_db->prepare("insert into ".$this->_tbUser."
				(	iUserId, 
					vchEmail, 
					vchFirstName,
					vchLastName,
					vchAddress1,
					vchAddress2,
					vchAddress3,
					vchCity,
					vchState, 
					vchPhone, 
					vchPassword,
					tsRegModified,
					iNum_ads,
					vchCountry,  
					tiHide_mail,
					vchZip,
					vchUsr_1,vchUsr_2,vchUsr_3,vchUsr_4,vchUsr_5,vchUsr_6,
					dtRegistered)
				VALUES(	0, 
					:UserEmail, 
					:FirstName,
					:LastName,
					:Address1,
					:Address2,
					:Address3,
					:City,
					:State, 
					:Phone, 
					:UserPass,
					:RegModified,
					:Num_ads,
					:Country,  
					:Hide_mail,
					:Zip,
					:Usr_1,:Usr_2,:Usr_3,:Usr_4,:Usr_5,:Usr_6,
					:Registered)");
		
		$stmt->bindParam(':UserEmail',		$this->_UserEmail,		PDO::PARAM_STR);
		$stmt->bindParam(':FirstName',		$this->_FirstName,		PDO::PARAM_STR);
		$stmt->bindParam(':LastName',		$this->_LastName,		PDO::PARAM_STR);
		$stmt->bindParam(':Address1',		$this->_Address1,		PDO::PARAM_STR);
		$stmt->bindParam(':Address2',		$this->_Address2,		PDO::PARAM_STR);
		$stmt->bindParam(':Address3',		$this->_Address3,		PDO::PARAM_STR);
		$stmt->bindParam(':City',			$this->_City,			PDO::PARAM_STR);
		$stmt->bindparam(':State',			$this->_State,			PDO::PARAM_STR);
		$stmt->bindParam(':Phone',			$this->_Phone,			PDO::PARAM_STR);
		$stmt->bindParam(':UserPass',		$this->_UserPass,		PDO::PARAM_STR);
		$stmt->bindParam(':RegModified',	$this->_RegModified,	PDO::PARAM_INT);
		$stmt->bindparam(':Num_ads',		$this->_Num_ads,		PDO::PARAM_INT);
		$stmt->bindParam(':Country',		$this->_Country,		PDO::PARAM_STR);
		$stmt->bindparam(':Hide_mail',		$this->_Hide_mail,		PDO::PARAM_INT);
		$stmt->bindParam(':Zip',			$this->_Zip,			PDO::PARAM_STR);
		$stmt->bindParam(':Usr_1',			$this->_Usr_1,			PDO::PARAM_STR);
		$stmt->bindParam(':Usr_2',			$this->_Usr_2,			PDO::PARAM_STR);
		$stmt->bindParam(':Usr_3',			$this->_Usr_3,			PDO::PARAM_STR);
		$stmt->bindParam(':Usr_4',			$this->_Usr_4,			PDO::PARAM_STR);
		$stmt->bindParam(':Usr_5',			$this->_Usr_5,			PDO::PARAM_STR);
		$stmt->bindParam(':Usr_6',			$this->_Usr_6,			PDO::PARAM_STR);
		$stmt->bindParam(':Registered',		$this->_Registered,		PDO::PARAM_STR);
		$stmt->execute();
		$affected_rows = $stmt->rowCount();
		return $affected_rows;
	}

	/*
	 * Function/Method to read user row by email key passed by __construct()
	 */
	function read(){
		$stmt = $this->_db->prepare("SELECT 
					iUserId, 
					vchEmail, 
					vchFirstName,
					vchLastName,
					vchAddress1,
					vchAddress2,
					vchAddress3,
					vchCity,
					vchState, 
					vchPhone, 
					vchPassword,
					tsRegModified,
					iNum_ads,
					vchCountry,  
					tiHide_mail,
					vchZip,
					vchUsr_1,vchUsr_2,vchUsr_3,vchUsr_4,vchUsr_5,vchUsr_6,
					dtRegistered
				    FROM ".$this->_tbUser."
				    WHERE 	vchEmail =:UserEmail and
							vchPassword = :UserPass");
		
		$stmt->bindParam(':UserEmail',			$this->_UserEmail,		PDO::PARAM_STR);
		$stmt->bindParam(':UserPass',			$this->_UserPass,		PDO::PARAM_STR);

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
	 * Function/Method to update user table
	 */
	function update() {
		$stmt = $this->_db->prepare("update ".$this->_tbUser." set 
						 vchFirstName 		= :FirstName
						,vchLastName 		= :LastName
						,vchAddress1		= :Address1
						,vchAddress2		= :Address2
						,vchAddress3		= :Address3
						,vchCity			= :City
						,vchState			= :State
						,vchPhone			= :Phone
						,tsRegModified		= :RegModified
						,iNum_ads			= :Num_ads
						,vchCountry			= :Country
						,tiHide_mail		= :Hide_mail
						,vchZip				= :Zip
						,vchUsr_1			= :Usr_1
						,vchUsr_2			= :Usr_2
						,vchUsr_3			= :Usr_3
						,vchUsr_4			= :Usr_4
						,vchUsr_5			= :Usr_5
						,vchUsr_6			= :Usr_6
						,dtRegistered		= :Registered
				    WHERE vchEmail =:UserEmail and
							vchPassword = :UserPass");
		$stmt->bindParam(':UserEmail',		$this->_UserEmail,		PDO::PARAM_STR);
		$stmt->bindParam(':FirstName',		$this->_FirstName,		PDO::PARAM_STR);
		$stmt->bindParam(':LastName',		$this->_LastName,		PDO::PARAM_STR);
		$stmt->bindParam(':Address1',		$this->_Address1,		PDO::PARAM_STR);
		$stmt->bindParam(':Address2',		$this->_Address2,		PDO::PARAM_STR);
		$stmt->bindParam(':Address3',		$this->_Address3,		PDO::PARAM_STR);
		$stmt->bindParam(':City',			$this->_City,			PDO::PARAM_STR);
		$stmt->bindparam(':State',			$this->_State,			PDO::PARAM_STR);
		$stmt->bindParam(':Phone',			$this->_Phone,			PDO::PARAM_STR);
		$stmt->bindParam(':UserPass',		$this->_UserPass,		PDO::PARAM_STR);
		$stmt->bindParam(':RegModified',	$this->_RegModified,	PDO::PARAM_INT);
		$stmt->bindparam(':Num_ads',		$this->_Num_ads,		PDO::PARAM_INT);
		$stmt->bindParam(':Country',		$this->_Country,		PDO::PARAM_STR);
		$stmt->bindparam(':Hide_mail',		$this->_Hide_mail,		PDO::PARAM_INT);
		$stmt->bindParam(':Zip',			$this->_Zip,			PDO::PARAM_STR);
		$stmt->bindParam(':Usr_1',			$this->_Usr_1,			PDO::PARAM_STR);
		$stmt->bindParam(':Usr_2',			$this->_Usr_2,			PDO::PARAM_STR);
		$stmt->bindParam(':Usr_3',			$this->_Usr_3,			PDO::PARAM_STR);
		$stmt->bindParam(':Usr_4',			$this->_Usr_4,			PDO::PARAM_STR);
		$stmt->bindParam(':Usr_5',			$this->_Usr_5,			PDO::PARAM_STR);
		$stmt->bindParam(':Usr_6',			$this->_Usr_6,			PDO::PARAM_STR);
		$stmt->bindParam(':Registered',		$this->_Registered,		PDO::PARAM_STR);
		$stmt->execute();
		$affected_rows = $stmt->rowCount();
		return $affected_rows;

	}

	/*
	 * Function/Method to delete user table
	 */
	function delete() {

	}

}