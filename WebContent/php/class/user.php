<?php
/* 
 * Created: 7/11/2016
 * Author:  LF Bolivar
 * 
 * Class User
 * 
 * The class contains basic (min) attributes related to the application user table
 * 
 * The User class contains x methods:
 * - __construct()
 * - register_user_session() TBD
 * - logon_session_found()
 * - logon_session_NOTfound()
 * - logout_user()
 * - timed_out($params)
 * 
 * The Member class extends User and provides x methods:
 * - member_session_found()
 * - member_request_to_post_content()
 * 
 * The Admin class extends User and provides x methods:
 */

class User {	
	
	public $priv_class_files		= NULL;
	public $sec_html_files			= NULL;
	public $html_files				= NULL;
	public $pub_header_title		= NULL;
	public $pub_welcome_message		= NULL;
	public $pub_welcome_message2	= NULL;
	public $priv_header_title		= NULL;
	public $priv_welcome_message	= NULL;
	public $priv_welcome_message2	= NULL;
	public $modal					= NULL;

	private $user_vchPassword		= NULL;
	private $user_vchEmail			= NULL;
	private $user_dtRegistered		= NULL;
	private $params					= NULL;
	
/*
 *
 * constructor to initialize variables.
 *
 * 
 */
	function __construct($session_vchEmail, $session_vchPassword, $session_dtRegistered){
		
		$this->user_vchEmail =$session_vchEmail;
		$this->user_vchPassword =$session_vchPassword;
		$this->user_dtRegistered =$session_dtRegistered;
		
		//  Sets path for files and start session.
		$objConfig = Config::getInstance();

		$this->priv_class_files      = $objConfig->get('priv_class_files');
		$this->sec_html_files        = $objConfig->get('sec_html_files');
		$this->sec_php_files         = $objConfig->get('sec_php_files');
		$this->html_files            = $objConfig->get('html_files');
		$this->pub_header_title      = $objConfig->get('pub_header_title');
		$this->pub_welcome_message   = $objConfig->get('pub_welcome_message');
		$this->pub_welcome_message2  = $objConfig->get('pub_welcome_message2');
		$this->priv_header_title     = $objConfig->get('priv_header_title');
		$this->priv_welcome_message  = $objConfig->get('priv_welcome_message');
		$this->priv_welcome_message2 = $objConfig->get('priv_welcome_message2');
		$this->_domain               = $objConfig->get('domain');
		
		
	}

/*
 * 
 * method to register user session.
 * 
 */
	function register_user_session(){
		
	}

/* 
 * 
 * method to logon user when session is found.
 * 
 */
	function logon_session_found(){

		// New config class allows for dynamic/abstract definition of file paths and 
		// Singleton Pattern access to public and private set paths
		$domain = $this->_domain;				
		require_once $this->priv_class_files.'db_user.php';
		$data['semail']=$this->user_vchEmail;
		
		$fetch = new db_user($data);
		$u_logonName = $fetch->read();
		
		if ($this->user_vchPassword != $u_logonName['logonPass']){

			$pub_header_title = $this->pub_header_title;
			$pub_welcome_message = $this->pub_welcome_message;
			$pub_welcome_message2 = $this->pub_welcome_message2;
			
			// Implement public header html code to produce page container
			// Followup with custom menu for the member view
			require $this->sec_html_files.'pageHeader2.html';
			require $this->html_files.'pageHeaderMenu.html';
			
			$MsgTitle = "Logon.php";
			$redirect = "Logon.php";
			$MsgType = "Warning:";
			$Msg1 = "Your session password does not match database.";
			$Msg2= "Click Back button to return to Logon";
			$button = "Back";
			
			require $this->sec_html_files.'logonNew.html';
			require $this->html_files.'pageFooter.html';
			unset($_POST['logon']);
			exit();
		
		} else {

			// If I got here My Session is active and I can resume WorkBench activity;
			$priv_header_title = $this->priv_header_title;
			$priv_welcome_message = $this->priv_welcome_message;
			$priv_welcome_message2 = $this->priv_welcome_message2;
			
			// Implement private header html and CSS code to produce page container
			// Followup with custom menu for the member view
			require $this->sec_html_files.'pageHeaderPrivate2.html';
			require $this->html_files.'pageMemberMenu.html';
			//require $this->sec_html_files.'pageHeader2.html';
			//require $this->html_files.'pageHeaderMenu.html';
			
			$MsgTitle = "Members Area";
			$MsgType = "Welcome back, ".$u_logonName['logonName'].";";
			$Msg1 = "If you want to publish content on the internet";
			$Msg2= "place an advertisement or web content here for FREE++";
			
			require $this->sec_html_files.'member.html';
			require $this->html_files.'pageFooterPrivate.html';
			exit();
		}	
	}
	
/*
 *
 * method to logon user when session is NOT found.
 *
 */
	function logon_session_NOTfound() {
				
		$domain = $this->_domain;
		$pub_header_title = $this->pub_header_title;
		$pub_welcome_message = $this->pub_welcome_message;
		$pub_welcome_message2 = $this->pub_welcome_message2;
			
		// The form is set and contains logon credentials
		// Make sure they filled in email and password required fields
		if($this->user_vchEmail == null | $this->user_vchPassword == null) {

			// Implement public header html code to produce page container
			// Followup with custom menu for the public view
			require $this->sec_html_files.'pageHeader2.html';
			require $this->html_files.'pageHeaderMenu.html';
		
			// die('You did not fill in a required field.');
			$MsgTitle = "Logon.php";
			$redirect = "Logon.php";
			$MsgType = "Warning";
			$Msg1 = "You did not complete all of the required fields(*).";
			$Msg2= "Click Logon button to enter credentials again.";
			$button = "Back";
			require $this->sec_html_files.'logonNew.html';
			require $this->html_files.'pageFooter.html';
			unset($_POST['logon']);
			exit();
		}

		// check credentials against the database
		// fetch the user with the email provided
		require $this->priv_class_files.'db_user.php';
		$data['semail']=$this->user_vchEmail;
		
		$fetch = new db_user($data);
		$user_data = $fetch->read();
		
		// Gives error if user doesn't exist
		if ($user_data == 0) {

			// Implement public header html code to produce page container
			// Followup with custom menu for the public view
			require $this->sec_html_files.'pageHeader2.html';
			require $this->html_files.'pageHeaderMenu.html';
		
			$MsgTitle = "Logon.php";
			$redirect = "Register.php";
			$MsgType = "Message: ".$this->user_vchEmail;
			$Msg1 = "That user does not exist in our database.";
			$Msg2= "Click button to Register.";
			$button = "Register";
			require $this->sec_html_files.'logonNew.html';
			require $this->html_files.'pageFooter.html';
			unset($_POST['logon']);
			return;
		}

/* If we made it here, we have an array that was loaded from db_user class.
 * 
 */
		$_POST['pass'] = stripslashes($user_data['logonPass']);
		$db_pass = $user_data['logonPass'];
		$logonName = $user_data['logonName'];
		$md5_pass = md5($this->user_vchPassword);
		
		// Gives error if the password is wrong and does not match db
		if ($md5_pass != $db_pass) {

			// Implement public header html code to produce page container
			// Followup with custom menu for the public view
			require $this->sec_html_files.'pageHeader2.html';
			require $this->html_files.'pageHeaderMenu.html';
							
			$MsgTitle = "LOGON";
			$redirect = "Logon.php";
			$MsgType = "Logon.php Warning:";
			$Msg1 = "Incorrect password match,";
			$Msg2= "please try again.";
			$button = "Back";
			
			require $this->sec_html_files.'logonNew.html';
			require $this->html_files.'pageFooter.html';
			unset($_POST['logon']);
			exit();
			
		} else {

			//  Sets path for files and start session.
			//  Sets path for files, start session and get session variables if they exist.
			require_once 'session.php';
			$objSess = new Session($user_data);
			$session_vars = $objSess->addSession();
							
			// if logon is ok then we store a database secure session
			// $hour = time() + 3600;
			// setcookie(Key_my_site, $_POST['pass'], $hour);
			// Password is already hashed don't re hash it
			$_POST['email'] = stripslashes($user_data['logonEmail']);
			//$_SESSION['ClassAdsEmail'] = $_POST['email'];
			//$_SESSION['ClassAdsPassword'] = $_POST['pass'];
			//$_SESSION['ClassAdsLogonName'] = $logonName;
		
			// Implement private header html code to produce page container
			$priv_header_title = $this->priv_header_title;
			$priv_welcome_message = $this->priv_welcome_message;
			$priv_welcome_message2 = $this->priv_welcome_message2;
				
			// Followup with custom menu for the member view
			require $this->sec_html_files.'pageHeaderPrivate2.html';
			require $this->html_files.'pageHeaderPrivMenu2.html';
							
			//then redirect them to the members area
			$MsgTitle = "Logon.php";
			$MsgType = "Welcome ".$logonName;
			$Msg1 = "If you want to publish content on the internet";
			$Msg2= "place an advertisement or web content here for FREE!!!";
			
			require $this->sec_html_files.'logonMsg.html';
			require $this->html_files.'pageFooterPrivate.html';
			exit();
			
		}
	
	}  // End of logon_session_NOTfound()
	
	/*  Logout function
	 * 
	 */
	function logout_user(){
		$domain = $this->_domain;
		$pub_header_title = $this->pub_header_title;
		$pub_welcome_message = $this->pub_welcome_message;
		$pub_welcome_message2 = $this->pub_welcome_message2;

		// Since session was destroyed above allow the user to re-logon.
		$objConfig = Config::getInstance();
		$modal = '<a href="#loginmodal" class="flatbtn" id="modaltrigger">Logon</a>';
		$objConfig->set('modal', $modal);
		
		//  Sets path for files and delete session.
		//  Sets path for files, start session and get session variables if they exist.
		require 'session.php';
		$objSess = new Session(null);
		$session_vars = $objSess->delSession();
		
		
		// Implement public header html code to produce page container
		// Followup with logonMsg and allow user to submit credentials
		require $this->sec_html_files.'pageHeader2.html';
		require $this->html_files.'pageHeaderMenu.html';
		
		$MsgTitle = "Logout.php";
		$redirect = "Logon.php";
		$MsgType1 = "Logout.php";
		$MsgType2 = "Message LO-001";
		$Msg1 = "Your session was closed successfully.";
		$Msg2= "Click the Logon button in the left pane to re-establish your session";
		$button = "Logon";
		//include $html_files.'pageBodyPrivate.html';
		require $this->sec_html_files.'logonNew.html';
		require $this->html_files.'pageFooter.html';
		unset($_POST['logon']);
		exit();
		
	}
	/*
	 * The timed_out() method will allow recovery from a session reaching timeout
	 */
	function timed_out($params){
	
		$domain 				= $this->_domain;
		$pub_header_title 		= $this->pub_header_title;
		$pub_welcome_message 	= $this->pub_welcome_message;
		$pub_welcome_message2 	= $this->pub_welcome_message2;
		
		$modal 		= $params['modal'];
	
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		require $this->sec_html_files.'pageHeader2.html';
		require $this->html_files.'pageHeaderMenu.html';
	
		$MsgTitle 	= $params['MsgTitle'];
		$MsgType 	= $params['MsgType'];
		$Msg1 		= $params['Msg1'];
		$Msg2 		= $params['Msg2'];

		require $this->sec_html_files.'logonMsg.html';
		require $this->html_files.'pageFooter.html';
		exit();
	
	}
	
}
/*
 * Class Member extends User
 *
 * The class contains x methods:
 */
class Member extends User {

/*
 * Method to check open session user and redirect to ToolBox
 */
	function member_session_found(){
	
		$domain = $this->_domain;
	
		// New config class allows for dynamic/abstract definition of file paths and
		// Singleton Pattern access to public and private set paths
	
		require_once $this->priv_class_files.'db_user.php';
		$data['semail']=$this->user_vchEmail;
	
		$fetch = new db_user($data);
		$u_logonName = $fetch->read();
	
		if ($this->user_vchPassword != $u_logonName['logonPass']){
	
			$pub_header_title = $this->pub_header_title;
			$pub_welcome_message = $this->pub_welcome_message;
			$pub_welcome_message2 = $this->pub_welcome_message2;
	
			//echo('-Member.php-  Incorrect password match, please try again, pass: '.$sessionPass.' vchPass: '.$info['vchPassword'].'');
			//echo('-Member.php- Session password did not match: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword']."");
			$redirect = "Logout.php";
			$MsgType = "Member.php Warning:";
			$Msg1 = "Incorrect password match with stored session";
			$Msg2= "Click Login button below.";
			$button = "Login";
			require $this->sec_html_files.'logonMsg.html';
			require $this->sec_html_files.'pageFooterPrivate.html';
			unset($_POST['logout']);
			exit();
		}
		//otherwise they are shown the admin or main application area/page and the DB session is stored and committed.
		else {
	
			$priv_header_title = $this->priv_header_title;
			$priv_welcome_message = $this->priv_welcome_message;
			$priv_welcome_message2 = $this->priv_welcome_message2;
	
			// Implement private header html code to produce page container
			// Followup with custom menu for the member view
			require $this->sec_html_files.'pageHeaderPrivate.html';
			require $this->html_files.'pageMemberMenu.html';
	
			// session_write_close();
			// echo ('-Member.php- Session found: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
			// echo ('logonName: '.$_SESSION['ClassAdsLogonName']."\n");
			$MsgTitle = "Member.php";
			If (empty($logonName))
			{
				$MsgType = "Welcome back ".$sessionEmail;
			}
			else
			{
				$MsgType = "Welcome back ".$logonName;
			}
			$Msg1 = "If you want to publish content in the ".$localregion;
			$Msg2 = "Place an ad here for FREE!!!.  Click on 'Post'";
			require $this->sec_html_files.'member.html';
			require $this->sec_html_files.'pageFooterPrivate.html';
			exit();
		}
	} //  End member_sessio_found() method
	
	/*
	 * Method to check open session member or user when attempting to add new content.
	 */
	function member_request_to_post_content(){
		
		$domain = $this->_domain;
		
		// New config class allows for dynamic/abstract definition of file paths and
		// Singleton Pattern access to public and private set paths
		
		require_once $this->priv_class_files.'db_member.php';
		$member = array();
		$data['semail']=$this->user_vchEmail;
		$member['semail']=$this->user_vchEmail;
		
		$obj_db_member = new db_member($data, $member);
		$member = $obj_db_member->read();
		
		if ($this->user_vchPassword != $member['vchPassword']) {
			// Implement private header html code to produce page container
			// Followup with custom menu for the member view
			require $this->sec_html_files.'pageHeaderPrivate.html';
			require $this->html_files.'pageMemberMenu.html';
				
			//echo('-Member.php-  Incorrect password match, please try again, pass: '.$sessionPass.' vchPass: '.$info['vchPassword'].'');
			//header("Location: Login.php");
			//echo ('-Member.php- Session password did not match: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword']."");
			$redirect = "Logout.php";
			$MsgType = "Member.php Warning:";
			$Msg1 = "Incorrect password match with stored session";
			$Msg2= "Click Login button below.";
			$button = "Logon";
			require $this->sec_html_files.'logonNew.html';
			require $this->sec_html_files.'pageFooterPrivate.html';
			unset($_POST['logout']);
			exit();
		} else {
/*
			// Now that we found a member record let's see if we have a user and greet him/her on second page of NewAd process
			$check2 = mysqli_query($link, "SELECT * FROM ".$tbl_name2." WHERE vchEmail = '$sessionEmail'")or die('-Member.php- '.mysqli_error().'');
			//$info2 = mysqli_fetch_array( $check2 )
			while($info2 = mysqli_fetch_array( $check2 ))
			{
*/
			// otherwise they are shown the New Advertisement area
			// Now that we found a member record let's see if we have a user and greet him/her on second page of NewAd process
			//	echo (' member '.$info2['vchPassword']);
			// New config class allows for dynamic/abstract definition of file paths and
			// Singleton Pattern access to public and private set paths
			
			require_once $this->priv_class_files.'db_user.php';
			$data['semail']=$this->user_vchEmail;
			
			$obj_db_user = new db_user($data);
			$user_data = $obj_db_user->read();
				
			if ($this->user_vchPassword == $user_data['vchPassword']) {
				//load existing user information with greeting on page to of NewAd process and capture classified data
				$first = $user_data['vchFirstName'];
				$last = $user_data['vchLastName'];
				$AdUserName = $first.' '.$last;
				include $this->sec_php_files.'NewAdForm2.php';
				exit();
			}
//			}
			//echo ('-Member.php- Session found: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
			//echo ("Admin Area<p>");
			//echo ("Your Content<p>");
			//echo ("<a href=Logout.php>Logout</a>");
			$email = $this->user_vchEmail;
			$password = $this->user_vchPassword;
			include $this->sec_php_files.'NewAdForm.php';
			exit();
		}
	}	// ends check_if_member_exists() method
		
}	// ends Member class


/*
 * Class Admin extends User
 *
 * The class contains x methods:
 */
class Admin extends User {
	
}


