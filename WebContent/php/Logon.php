<?php
//  This script first checks to see if the logon information is contained in a session on the web server.
//  If it is, it tries to log them in. If this is successful they are redirected to the members area.
//  If there is no cookie, it allows them to logon.
//  If the form has been logged on, it checks it against the database and if it was successful sets a cookie and takes them to the members area.
//  If it has not been logged on, it shows them the logon form.

//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to member table of ClassAds_ClassAds Database
//  Include the db connection script from non public_html location
// Sets path for files and start session.
include PRIVATE_DB."dbConfig.php";

// First check if session was created and currently exists.
if(!isset($_SESSION['ClassAdsEmail']))
{
	$modal = '<a href="#loginmodal" class="flatbtn" id="modaltrigger">Logon</a>';
}else{
	$modal = '<a href="Member.php">Logon</a>';
}

// Check for an active session using database session handler
if(isset($_SESSION['ClassAdsEmail']))
{
	//if there is an active session, it logs you in and directs you to the members page
	$email = $_SESSION['ClassAdsEmail'];
	$pass = $_SESSION['ClassAdsPassword'];
	$check = mysqli_query($link, "SELECT M.*, U.vchFirstName, U.vchLastName FROM ".$tbl_name." as M
							left join ".$tbl_name2." as U on M.vchEmail = U.vchEmail 
							WHERE M.vchEmail = '$email'")
	or die("Logon.php mysql error -1- ".mysqli_error($link));

	while($info = mysqli_fetch_array( $check ))
	{
		$logonName = $info['vchFirstName']." ".$info['vchLastName'];
		if ($pass != $info['vchPassword'])
		{
			// Implement private header html code to produce page container
			// Followup with custom menu for the member view
			include $sec_html_files.'pageHeader2.html';
			include $html_files.'pageHeaderMenu.html';
			
			$MsgTitle = "Logon.php";
			$redirect = "Logon.php";
			$MsgType = "Warning:";
			$Msg1 = "Your session password does not match database.";
			$Msg2= "Click Back button to return to Logon";
			$button = "Back";
			include $sec_html_files.'logonNew.html';
			include $html_files.'pageFooter.html';
			unset($_POST['logon']);
			exit();
		}
		else
		{
			// Implement private header html code to produce page container
			// Followup with custom menu for the member view
			include $sec_html_files.'pageHeaderPrivate.html';
			include $html_files.'pageHeaderPrivMenu2.html';
			
			// echo ('-Logon.php- prior Session found: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
			// session_write_close();
			$MsgTitle = "LOS CABOS CLASSIFIEDS - Members Area";
			$MsgType = "Welcome back, ".$logonName.";";
			$Msg1 = "If you want to publish content on the internet";
			$Msg2= "place an advertisement or web content here for FREE!!!";
			include $sec_html_files.'member.html';
			include $html_files.'pageFooterPrivate.html';
			exit();
		}
	}
}

// When no session is found check to see if the logon form is posted
if (isset($_POST['logon']))
{

	// The form is set and contains logon credentials
	// Make sure they filled in email and password required fields
	if(!$_POST['email'] | !$_POST['pass'])
	{
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		include $sec_html_files.'pageHeader2.html';
		include $html_files.'pageHeaderMenu.html';
		
		// die('You did not fill in a required field.');
		$MsgTitle = "Logon.php";
		$redirect = "Logon.php";
		$MsgType = "Warning";
		$Msg1 = "You did not complete all of the required fields(*).";
		$Msg2= "Click Logon button to enter credentials again.";
		$button = "Back";
		include $sec_html_files.'logonNew.html';
		include $html_files.'pageFooter.html';
		unset($_POST['logon']);
		exit();
	}
	// checks it against the database
	if (!get_magic_quotes_gpc())
	{
		$_POST['email'] = addslashes($_POST['email']);
		$_POST['pass'] = addslashes($_POST['pass']);
	}
	$usercheck = $_POST['email'];
	$check = mysqli_query($link, "SELECT M.*, U.vchFirstName, U.vchLastName FROM ".$tbl_name." as M
							left join ".$tbl_name2." as U on M.vchEmail = U.vchEmail
							WHERE M.vchEmail = '$usercheck'")
	or die("Logon.php mysql error -2- ".mysqli_error());

	// Gives error if user doesn't exist
	$check2 = mysqli_affected_rows($link);
	if ($check2 == 0)
	{
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		include $sec_html_files.'pageHeader2.html';
		include $html_files.'pageHeaderMenu.html';
		
		//die('-Logon.php- That user does not exist in our database. <a href=Register.php>Click Here to Register</a>');
		$MsgTitle = "Logon.php";
		$redirect = "Register.php";
		$MsgType = "Message:";
		$Msg1 = "That user does not exist in our database.";
		$Msg2= "Click button to Register.";
		$button = "Register";
		include $sec_html_files.'logonNew.html';
		include $html_files.'pageFooter.html';
		unset($_POST['logon']);
		exit();
	}
	while($info = mysqli_fetch_array( $check ))
	{
		$_POST['pass'] = stripslashes($_POST['pass']);
		$info['vchPassword'] = stripslashes($info['vchPassword']);
		$_POST['pass'] = md5($_POST['pass']);
		$logonName = $info['vchFirstName']." ".$info['vchLastName'];

		// Gives error if the password is wrong
		if ($_POST['pass'] != $info['vchPassword'])
		{
			// Implement private header html code to produce page container
			// Followup with custom menu for the member view
			include $sec_html_files.'pageHeader2.html';
			include $html_files.'pageHeaderMenu.html';
			
			//die('pass: '.$_POST['pass'].' vchPass: '.$info['vchPassword'].' -Logon.php- Incorrect password match, please try again.');
			$MsgTitle = "LOGON";
			$redirect = "Logon.php";
			$MsgType = "Logon.php Warning:";
			$Msg1 = "Incorrect password match,";
			$Msg2= "please try again.";
			$button = "Back";
			include $sec_html_files.'logonNew.html';
			include $html_files.'pageFooter.html';
			unset($_POST['logon']);
			exit();
		}
		else
		{
			// if logon is ok then we store a or database secure session
			// $hour = time() + 3600;
			//setcookie(Key_my_site, $_POST['pass'], $hour);
			// Password is already hashed don't re hash it
			// session_start();
			$_POST['email'] = stripslashes($_POST['email']);
			$_SESSION['ClassAdsEmail'] = $_POST['email'];
			$_SESSION['ClassAdsPassword'] = $_POST['pass'];
			$_SESSION['ClassAdsLogonName'] = $logonName;
			// session_write_close();
				
			// Implement private header html code to produce page container
			// Followup with custom menu for the member view
			include $sec_html_files.'pageHeaderPrivate2.html';
			include $html_files.'pageHeaderPrivMenu2.html';
			
			//then redirect them to the members area
			// echo ('-Logon.php- Session stored: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword']."\n");
			// echo ('');
			//header("Location: Member.php");
			$MsgTitle = "Logon.php";
			$MsgType = "Welcome ".$logonName;
			$Msg1 = "If you want to publish content on the internet";
			$Msg2= "place an advertisement or web content here for FREE!!!";
			include $sec_html_files.'logonMsg.html';
			include $html_files.'pageFooterPrivate.html';
			exit();
		}
	}
}
else
{
	// Initiate, start and store a new session by including dbConfig.php at the top of this script.
	// Included in the handler override is a session_start() and concludes below with a commit of the DB session.
	// Reference details related to handler functions in SessionHandler.php';
	session_write_close();

	// Implement private header html code to produce page container
	// Followup with custom menu for the member view
	include $sec_html_files.'pageHeader2.html';
	include $html_files.'pageHeaderMenu.html';
	
	$MsgTitle = "Logon.php";
	$MsgType = "Welcome:";
	$Msg1 = "To Logon to the Member's Area and store content please click on the";
	$Msg2 = "Member's link on the left.";
	include $sec_html_files.'logonNew.html';
	include $html_files.'pageFooter.html';
	exit();
}
?>
