<?php
//  This code checks our session to make sure the user is logged in, the same way the login page did.
//  If they are logged in, they are shown the AdNewForm area.
//  If they are not logged in they are redirected to the login page.
//  Local config allows for dynamic definition of file paths and single point for private paths
require_once "setConfig.php";

//  If they are not logged in they are redirected to the login page.
// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to your Database
//  Include the db connection script from non html location
include PRIVATE_DB."dbConfig.php";

// Checks session to make sure user is still logged in
if(isset($_SESSION['ClassAdsEmail']))
{

	$sessionEmail = $_SESSION['ClassAdsEmail'];
	$sessionPass= $_SESSION['ClassAdsPassword'];

	$check = mysqli_query($link, "SELECT * FROM ".$tbl_name." WHERE vchEmail = '$sessionEmail'")or die('-Member.php- '.mysqli_error().'');
	while($info = mysqli_fetch_array( $check ))
	{
		//	echo (' member '.$info['vchPassword']);
		//if the cookie has the wrong password, they are taken to the login page
		if ($sessionPass != $info['vchPassword'])
		{
			// Implement private header html code to produce page container
			// Followup with custom menu for the member view
			include $sec_html_files.'pageHeaderPrivate.html';
			include $html_files.'pageMemberMenu.html';
			
			//echo('-Member.php-  Incorrect password match, please try again, pass: '.$sessionPass.' vchPass: '.$info['vchPassword'].'');
			//header("Location: Login.php");
			//echo ('-Member.php- Session password did not match: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword']."");
			$redirect = "Logout.php";
			$MsgType = "Member.php Warning:";
			$Msg1 = "Incorrect password match with stored session";
			$Msg2= "Click Login button below.";
			$button = "Logon";
			include $sec_html_files.'logonNew.html';
			include $sec_html_files.'pageFooterPrivate.html';
			unset($_POST['logout']);
			exit();
		}
		//otherwise they are shown the New Advertisement area
		else
		{
			// Now that we found a member record let's see if we have a user and greet him/her on second page of NewAd process
			$check2 = mysqli_query($link, "SELECT * FROM ".$tbl_name2." WHERE vchEmail = '$sessionEmail'")or die('-Member.php- '.mysqli_error().'');
			//$info2 = mysqli_fetch_array( $check2 )
			while($info2 = mysqli_fetch_array( $check2 ))
			{
				//	echo (' member '.$info2['vchPassword']);
				if ($sessionPass == $info2['vchPassword'])
				{
					//load existing user information with greeting on page to of NewAd process and capture classified data
					$first = $info2['vchFirstName'];
					$last = $info2['vchLastName'];
					$AdUserName = $first.' '.$last;
					include $sec_php_files.'NewAdForm2.php';
					exit();
				}
			}
			//echo ('-Member.php- Session found: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
			//echo ("Admin Area<p>");
			//echo ("Your Content<p>");
			//echo ("<a href=Logout.php>Logout</a>");
			$email = $_SESSION['ClassAdsEmail'];
			$password = $_SESSION['ClassAdsPassword'];
			include $sec_php_files.'NewAdForm.php';
			exit();
		}
	}
}
else
{
	// Implement private header html code to produce page container
	// Followup with custom menu for the member view
	include $sec_html_files.'pageHeader2.html';
	include $html_files.'pageHeaderMenu.html';
	
	//if the cookie does not exist, they are taken to the login screen
	//header("Location: Login.php");
	//echo ('Session does not exist: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
	$MsgTitle = "MEMBER";
	$redirect = "Logout.php";
	$MsgType = "Member.php Warning:";
	$Msg1 = "User name and password sesssion lost";
	$Msg2= "Please re-establish credentials by Login in.";
	$button = "Login";
	include $sec_html_files.'loginMsg.html';
	include $html_files.'pageFooter.html';
	unset($_POST['submit']);
	exit();
}
?>