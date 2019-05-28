<?php
/*
 * Created: 10/29/2016
 * Author:  LF Bolivar
 *
 * Class Profile
 *
 * The class contains basic (min) attributes related to the application User table
 * - __construct()
 *
 * The class contains x methods:
 * - update_content()
 * - insert_content()
 * - display_content_form()
 */

class Profile {

	public $sec_html_files				=NULL;
	public $html_files					=NULL;
	public $php_files					=NULL;
	public $pub_header_title			=NULL;
	public $pub_welcome_message			=NULL;
	public $pub_welcome_message2		=NULL;
	public $modal						=NULL;
	public $options						=NULL;

	protected $priv_class_files			=NULL;
	protected $priv_header_title		=NULL;
	protected $priv_welcome_message		=NULL;
	protected $priv_welcome_message2	=NULL;

	protected $_user					=array();
	protected $_UserId					=NULL;
	protected $_FirstName				=NULL;
	protected $_LastName				=NULL;
	protected $_Address1				=NULL;
	protected $_Address2				=NULL;
	protected $_Address3				=NULL;
	protected $_City 					=NULL;
	protected $_State					=NULL;
	protected $_Phone					=NULL;
	protected $_Country					=NULL;
	protected $_Hide_mail				=NULL;
	protected $_Zip						=NULL;
	Protected $_Num_ads					=NULL;
	Protected $_Pass					=NULL;
	Protected $_RegModified				=NULL;
	
	protected $_UserEmail				=NULL;
	protected $_UserPass				=NULL;
	protected $_UserName				=NULL;

	protected $_regemailtitle			=Null;
	protected $_regemailaddr			=Null;
	protected $_localregion				=Null;

	/*
	 *
	 * constructor to initialize variables.
	 *
	 *
	 */
	function __construct($user){

		//  Sets path for files and start session.
		$objConfig = Config::getInstance();

		$this->priv_class_files			= $objConfig->get('priv_class_files');
		$this->sec_html_files			= $objConfig->get('sec_html_files');
		$this->html_files				= $objConfig->get('html_files');
		$this->php_files				= $objConfig->get('php_files');
		$this->pub_header_title			= $objConfig->get('pub_header_title');
		$this->pub_welcome_message		= $objConfig->get('pub_welcome_message');
		$this->pub_welcome_message2		= $objConfig->get('pub_welcome_message2');
		$this->priv_header_title		= $objConfig->get('priv_header_title');
		$this->priv_welcome_message		= $objConfig->get('priv_welcome_message');
		$this->priv_welcome_message2	= $objConfig->get('priv_welcome_message2');
		$this->_domain					= $objConfig->get('domain');
		$this->_regemailtitle			= $objConfig->get('regemailtitle');
		$this->_regemailaddr			= $objConfig->get('regemailaddr');
		$this->_localregion				= $objConfig->get('localregion');

		$this->_user					= $user;
		$this->_FirstName 				= $user['FirstName'];
		$this->_LastName 				= $user['LastName'];
		$this->_Address1 				= $user['Address1'];
		$this->_Address2 				= $user['Address2'];
		$this->_Address3 				= $user['Address3'];
		$this->_City 					= $user['City'];
		$this->_State 					= $user['State'];
		$this->_Phone 					= $user['Phone'];
		$this->_Country 				= $user['Country'];
		$this->_Hide_mail 				= $user['Hide_mail'];
		$this->_Zip 					= $user['Zip'];
		
		$this->_UserEmail				= $user['sessionEmail'];
		$this->_UserPass				= $user['sessionPass'];
		$this->_UserName				= $user['sessionName'];
		
		self::show_profile();
		

	}
	function show_profile(	$first="", 
							$last="", 
							$addr1= "",
							$addr2= "",
							$addr3= "",
							$city= "", 
							$state="",
							$phone="",
							$country= "",
							$hide_mail="",
							$zip="",
							$changedEmail="",
							$changedPass=""){

	}
	function display_profile(){
		
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		$priv_header_title=$this->priv_header_title;
		$priv_welcome_message=$this->priv_welcome_message;
		$priv_welcome_message2=$this->priv_welcome_message2;
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		require $this->sec_html_files.'pageHeaderPrivate.html';
		require $this->html_files.'pageMemberMenu.html';
		
		try {
			require_once $this->priv_class_files.'db_user_pdo.php';
			
			$usr = array();
			$usr['UserEmail'] = $this->_UserEmail;
			$usr['UserPass'] = $this->_UserPass;
		
			$obj_usr = new db_user_pdo($data, $usr);
			$result = $obj_usr->read();

			if ($result==0){
				
				try {
					
					$usr = array();
					$usr['UserEmail'] = $this->_UserEmail;
					$usr['UserPass'] = $this->_UserPass;
					
					$obj_usr = new db_user_pdo($data, $usr);
					$result = $obj_usr->create();
						
					if ($result==0){
						$msg1 = "If this is your first time in your Profile please update your personal information";
					} else {
						//print_r($result);
						//  On un-successful update route back to member.html.
						$MsgTitle = $this->_regemailtitle;
						$MsgType = "Thank you ".$this->UserEmail.";";
						$Msg1 = "No update(s) or change(s) to existing data were made in your request.";
						$Msg2 = "You can continue processing your content via the WorkBench tool.";
						include $this->sec_html_files.'member.html';
						include $this->sec_html_files.'pageFooterPrivate.html';
						exit();
					}
				} catch(PDOException $ex) {
					//Something went wrong rollback!
					//$db->rollBack();
					// echo $ex;
					print_r($result);
					$MsgTitle = $this->_regemailtitle;
					$MsgType = "Thank you, ".$this->UserName.";";
					$Msg1 = "PDO call to db_ad::create() failed with error:";
					$Msg2 = $ex;
					require $this->sec_html_files.'member.html';
					require $this->sec_html_files.'pageFooterPrivate.html';
					exit();
				}
				
			
			} else {
				$msg1 = "To change information in your Profile please update any field";
			}
				

			
		} catch(PDOException $ex) {
			//Something went wrong rollback!
			//$db->rollBack();
			// echo $ex;
			print_r($result);
			$MsgTitle = $this->_regemailtitle;
			$MsgType = "Thank you, ".$this->UserName.";";
			$Msg1 = "PDO call to db_ad::create() failed with error:";
			$Msg2 = $ex;
			require $this->sec_html_files.'member.html';
			require $this->sec_html_files.'pageFooterPrivate.html';
			exit();
		}
		$first		= $result['vchFirstName'];
		$last 		= $result['vchLastName'];
		$addr1		= $result['vchAddress1'];
		$addr2		= $result['vchAddress2'];
		$addr3		= $result['vchAddress3'];
		$city		= $result['vchCity'];
		$state		= $result['vchState'];
		$phone		= $result['vchPhone'];
		$zip		= $result['vchZip'];
		$country	= $result['vchCountry'];
		$hide_mail	= $result['tiHide_mail'];
		$changedEmail= $this->_UserEmail;
		$changedPass= $this->_UserPass;		
		
		$MsgTitle = "MY PROFILE UPDATE";
		$MsgType = "Welcome back ".$first." ";
		$msg2= "and click the Update button below.";
		
		self::show_profile(	$first,
						$last,
						$addr1,
						$addr2,
						$addr3,
						$city,
						$state,
						$phone,
						$country,
						$hide_mail,
						$zip,
						$changedEmail,
						$changedPass);

		require $this->sec_html_files.'myprofile.html';
		require $this->sec_html_files.'pageFooterPrivate.html';
		
		
/*		
		$MyProfile = mysqli_query($link, "SELECT * FROM ".$tbl_name2."
				WHERE '$sessionEmail' = vchEmail and '$sessionPass' = vchPassword") or die('-MyProfile.php (slelect)- '.mysqli_error().'');
		//Gives error if user doesn't exist
		$check3 = mysqli_affected_rows($link);
		if ($check3 == 0)
		{
			if(!mysqli_query($link,"insert into ".$tbl_name2." values
					(0,'$sessionEmail','$first','$last','$addr1','$addr2','$addr3','$city','$state','$phone','$sessionPass','',0,'$country',0,'$zip','','','','','','')"))
			{
				if (mysqli_errno() == 1062)
				{
					echo mysqli_errno().": duplicate key error returned from MySQL";
				}
				else
				{
					echo mysqli_errno().": error returned from MySQL";
				}
			}
			$Msg1 = "If this is your first time in your Profile please update your personal information,";
		}
		else
		{
			while($Updates = mysqli_fetch_array( $MyProfile ))
			{
				// Loop and display each item detail for given session user
				$first      = $Updates['vchFirstName'];
				$last 		= $Updates['vchLastName'];
				$addr1 		= $Updates['vchAddress1'];
				$addr2 		= $Updates['vchAddress2'];
				$addr3 		= $Updates['vchAddress3'];
				$city 		= $Updates['vchCity'];
				$state 		= $Updates['vchState'];
				$phone 		= $Updates['vchPhone'];
				$country 	= $Updates['vchCountry'];
				$citystphone= $Updates['tiHide_email'];
				$zip        = $Updates['vchZip'];
			}
			$logonName = $first." ".$last;
			$_SESSION['ClassAdsName'] = $logonName;
			$msg1 = "To change information in your Profile please update any field below,";
		}
		$changedPass	= $sessionPass;
		$changedEmail 	= $sessionEmail;
		$MsgTitle = "MY PROFILE UPDATE";
		$MsgType = "Welcome back, ".$logonName.";";
		$msg2= "and click the Update Contact button below.";
		include $sec_html_files.'myprofile.html';
		include $sec_html_files.'pageFooterPrivate.html';
		show_profile($first,$last,$addr1,$addr2,$addr3,$city,$state,$phone,$country,$citystphone,$zip,$changedEmail,$changedPass);
*/		
		
	}
	function update_profile(){
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		$priv_header_title=$this->priv_header_title;
		$priv_welcome_message=$this->priv_welcome_message;
		$priv_welcome_message2=$this->priv_welcome_message2;
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		require $this->sec_html_files.'pageHeaderPrivate.html';
		require $this->html_files.'pageMemberMenu.html';

/*		mysqli_query($link,"update ".$tbl_name2." set vchEmail = '$sessionEmail', vchFirstName = '$first', vchLastName = '$last',
				vchAddress1 = '$addr1', vchAddress2 = '$addr2', vchAddress3 = '$addr3',	vchCity = '$city', vchState = '$state', vchZip = '$zip',
				vchPhone = '$phone', vchPassword = '$sessionPass', vchCountry = '$country', tiHide_email = $citystphone
				WHERE '$sessionEmail' = vchEmail and '$sessionPass' = vchPassword") or die('-MyProfile.php (Update User Table)-'.mysqli_error().'');
*/
		try {
			require_once $this->priv_class_files.'db_user_pdo.php';
				
			$usr = array();
			$usr['UserEmail']	= $this->_UserEmail;
			$usr['UserPass']	= $this->_UserPass;
			$usr['FirstName']	= $this->_FirstName;
			$usr['LastName']	= $this->_LastName;
			$usr['Address1']	= $this->_Address1;
			$usr['Address2']	= $this->_Address2;
			$usr['Address3']	= $this->_Address3;
			$usr['City']		= $this->_City;
			$usr['State']		= $this->_State;
			$usr['Phone']		= $this->_Phone;
			$usr['Country']		= $this->_Country;
			$usr['Hide_mail']	= $this->_Hide_mail;
			$usr['Zip']			= $this->_Zip;
				
			$obj_usr = new db_user_pdo($data, $usr);
			$result = $obj_usr->update();
		} 
		catch(PDOException $ex) {
			//Something went wrong rollback!
			//$db->rollBack();
			echo $ex;
			print_r($result);
			print_r($usr);
				
		}
		$MsgTitle = $regemailtitle;
		// $redirect = "Login.php";
		$MsgType = "Thank you, ".$logonName.";";
		$Msg1 = "Your personal information was updated successfully,";
		$Msg2= "To View your Ad, Post your Ad or Update your Profile click on the link below.";
		require $this->sec_html_files.'member.html';
		require $this->sec_html_files.'pageFooterPrivate.html';
		exit();
		
		
		
	}
	function create_profile(){
		
	}
	
}