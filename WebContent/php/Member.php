<?php
//  This code checks our session to make sure the user is logged in, the same way the login page did.
//  If they are logged in, they are shown the members area.
//  If they are not logged in they are redirected to the login page.

//  Local config allows for dynamic definition of file paths and single point for private paths
include_once "Config.php";

// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to your Database
//  Include the db connection script from non html location
include PRIVATE_DB."dbConfig.php";

// Always check for existing DB session at the top of the script after loading non pulic path and configuration information.
if(isset($_SESSION['ClassAdsEmail']))
{
	$sessionEmail = $_SESSION['ClassAdsEmail'];
	$sessionPass = $_SESSION['ClassAdsPassword'];
	$logonName = $_SESSION['ClassAdsLogonName'];

	$check = mysqli_query($link, "SELECT * FROM ".$tbl_name." WHERE vchEmail = '$sessionEmail'")or die('-Member.php- '.mysqli_error().'');
	while($info = mysqli_fetch_array( $check ))
	{
		//if the DB session has the wrong password, they are taken to the login page
		if ($sessionPass != $info['vchPassword'])
		{
			//echo('-Member.php-  Incorrect password match, please try again, pass: '.$sessionPass.' vchPass: '.$info['vchPassword'].'');
			//echo('-Member.php- Session password did not match: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword']."");
			$redirect = "Logout.php";
			$MsgType = "Member.php Warning:";
			$Msg1 = "Incorrect password match with stored session";
			$Msg2= "Click Login button below.";
			$button = "Login";
			include $sec_html_files.'logonMsg.html';
			include $sec_html_files.'pageFooterPrivate.html';
			unset($_POST['logout']);
			exit();
		}
		//otherwise they are shown the admin or main application area/page and the DB session is stored and committed.
		else
		{
			// Implement private header html code to produce page container
			// Followup with custom menu for the member view
			include $sec_html_files.'pageHeaderPrivate.html';
			include $html_files.'pageMemberMenu.html';
			
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
			$Msg2 = "Place an ad here for FREE!!!.  Click on 'Post Content'";
			include $sec_html_files.'member.html';
			include $sec_html_files.'pageFooterPrivate.html';
			exit();
		}
	}
}
else
{
	// Implement private header html code to produce page container
	// Followup with custom menu for the member view
	include $sec_html_files.'pageHeader.html';
	include $html_files.'pageHeaderMenu.html';
	
	//if the DB session does not exist or expired, they are taken to the login screen.
	// echo ('Session does not exist: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
	$MsgTitle = "Member.php";
	$redirect = "Logon.php";
	$MsgType = "Warning:";
	$Msg1 = "User name and password sesssion lost";
	$Msg2= "Please re-establish credentials by Login in.";
	$button = "Logon";
	include $sec_html_files.'logonNew.html';
	//include $html_files.'logonNew.html';
	include $sec_html_files.'pageFooter.html';
	unset($_POST['logout']);
	exit();
}
?>
