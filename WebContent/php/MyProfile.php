<?PHP
/*
 * Created: 07/30/2017
 * Author:  LF Bolivar
 *
 * New MyProfile.php script to call new Profile class and modularize the functions
 * associated with updating Profile information in the User table via the WorkBench toolbox.
 *
 */
//  Local config allows for dynamic definition of file paths and single point for private paths
require_once "setConfig.php";
require_once 'class/profile.php';

//  Sets path for files and start session.
//  Sets path for files, start session and get session variables if they exist.
require_once 'class/session.php';
$objSess = new Session(Null);
$session_vars = $objSess->readSession();

// First check if session was created and currently exists.
if(isset($session_vars['sessionEmail'])) {

	$sessionEmail 	= $session_vars['sessionEmail'];
	$sessionPass 	= $session_vars['sessionPass'];
	$logonName 		= $session_vars['sessionName'];

	// Implement private header html code to produce page container
	// Followup with custom menu for the member view
	//include $sec_html_files.'pageHeaderPrivate.html';
	//include $html_files.'pageMemberMenu.html';
	
	// This MyProfile php script is used to update all contact information for the user that is logged in to this session.
	// Detail select query by email and password and display data on myprofile.html page with the intent to update profile.
	if (isset($_POST['myProfile']))
	{
		// Load values from myProfile form for updates to user table
		$session_vars['FirstName']	= $_POST['first'];
		$session_vars['LastName']	= $_POST['last'];
		$session_vars['Address1']	= $_POST['addr1'];
		$session_vars['Address2']	= $_POST['addr2'];
		$session_vars['Address3']	= $_POST['addr3'];
		$session_vars['City']		= $_POST['city'];
		$session_vars['State']		= $_POST['state'];
		$session_vars['Phone']		= $_POST['phone'];
		$session_vars['Country']	= $_POST['country'];
		$session_vars['Hide_mail']	= $_POST['hide_mail'];
		$session_vars['Zip']		= $_POST['zip'];

		// Check if user has changed email or password
		if ($sessionPass!= md5($_POST['pass']) or $sessionEmail != $_POST['email']){
			print_r($sessionPass); print_r($_POST['pass']);
			print_r($sessionEmail); print_r($_POST['email']);
			if ($sessionPass!= $_POST['pass']){
				$_POST['pass'] = stripslashes($_POST['pass']);
				$_POST['pass'] = md5($_POST['pass']);
			}
			$changedPass = $_POST['pass'];
			$changedEmail = $_POST['email'];
/*			mysqli_query($link,"update ".$tbl_name2." set vchEmail = '$changedEmail', vchFirstName = '$first', vchLastName = '$last',
					vchAddress1 = '$addr1', vchAddress2 = '$addr2', vchAddress3 = '$addr3',	vchCity = '$city', vchState = '$state', vchZip = '$zip',
					vchPhone = '$phone', vchPassword = '$changedPass', vchCountry = '$country', tiHide_email = $citystphone
					WHERE '$sessionEmail' = vchEmail and '$sessionPass' = vchPassword") or die('-MyProfile.php (Update User Table)-'.mysqli_error().'');

			// Update all existing ADs that belong to this email and user.
			mysqli_query($link,"update ".$tbl_name3." set vchUserEmail = '$changedEmail', vchUserPassword = '$changedPass'
					WHERE '$sessionEmail' = vchUserEmail and '$sessionPass' = vchUserPassword") or die('-MyProfile.php (update Ad table)-'.mysqli_error().'');

			// Delete and re-insert new email member key.
			mysqli_query($link, "delete from ".$tbl_name." WHERE '$sessionEmail' = vchEmail and '$sessionPass' = vchPassword") or die('-MyProfile.php (Delete Member Table)-'.mysqli_error().'');
			$today = DATE(c);
			mysqli_query($link, "INSERT INTO ".$tbl_name." (vchEmail, vchPassword, dtRegistered) VALUES ('$changedEmail', '$changedPass', '$today')") or die('-MyProfile.php (Insert Member Table)-'.mysqli_error().'');
*/
			$_SESSION['ClassAdsPassword'] = $_POST['pass'];
			$_SESSION['ClassAdsEmail'] = $_POST['email'];
			$logonName = $first." ".$last;
			$_SESSION['ClassAdsName'] = $logonName;
		} else {

			$objWB = new Profile($session_vars);
			$objWB->update_profile();
				
		}
	} else {
		
		$objWB = new Profile($session_vars);
		$objWB->display_profile();

	}
}
else
{
	//if the session does not exist, you are taken to the login screen
	//header("Location: Login.php");
	//echo ('Session does not exist: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
	$MsgTitle = "MY PROFILE UPDATE";
	$redirect = "Logout.php";
	$MsgType = "MyProfile.php Warning:";
	$Msg1 = "User sesssion expired";
	$Msg2= "Please re-establish credentials with Login.";
	$button = "Login";
	include $sec_html_files.'logonMsg.html';
	include $sec_html_files.'pageFooterPrivate.html';
	unset($_POST['submit']);
	exit();
}
?>