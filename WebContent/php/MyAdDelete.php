<?php
//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to your Database
//  Include the db connection script from non html location
include PRIVATE_DB."dbConfig.php";

// First check if session was created and currently exists.
if(isset($_SESSION['ClassAdsEmail']))
{
	$sessionEmail = $_SESSION['ClassAdsEmail'];
	$sessionPass = $_SESSION['ClassAdsPassword'];
	$logonName = $_SESSION['ClassAdsLogonName'];

	// Check to see whether to delete an Ad row or an Image row.
	if (!isset($_POST['AdId'])) {
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		include $sec_html_files.'pageHeaderPrivate.html';
		include $html_files.'pageMemberMenu.html';
				
		$msg1 = "Welcome to $regemailtitle, $first $last,";
		$msg2 = "to update your $priv_content_desc please select below.";
		include $sec_html_files.'member.html';
		include $sec_html_files.'pageFooterPrivate.html';
		exit();
	}

	// load the form values needed to do the delete
	$adid = $_POST['AdId'];
	$imageid = $_POST['ImageId'];
	$deltype = $_POST['deltype'];

	if ($deltype == "Ad") {
		// Delete Ad row from table-3.
		mysqli_query($link, "delete from ".$tbl_name3."
			WHERE '$sessionEmail' = vchUserEmail 
					and '$sessionPass' = vchUserPassword
					and $adid = iAdId") 
		or die('-MyAdDelete.php (Delete of '.$tbl_name3.' Table failed)- '.mysqli_error().'');

		// Delete Image row from table-4.
		mysqli_query($link, "delete from ".$tbl_name4."
			WHERE $adid = iFileAdId ")
		or die('-MyAdDelete.php (Delete of all '.$tbl_name4.' Table rows for '.$priv_content_desc.' #'.$adid.' failed)- '.mysqli_error().'');

		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		include $sec_html_files.'pageHeaderPrivate.html';
		include $html_files.'pageMemberMenu.html';
				
		$MsgTitle = $regemailtitle;
		$MsgType = "Thank you, $logonName";
		$Msg1 = "Your $priv_content_desc #$adid and all images were deleted successfully.";
		$Msg2= "To View and/or Post new $priv_content_desc or Update your Profile click on the link below.";
		include $sec_html_files.'member.html';
		include $sec_html_files.'pageFooterPrivate.html';
		exit();
	} else{
		// Delete Image row from table-4.
		if(empty($imageid)){
			// Implement private header html code to produce page container
			// Followup with custom menu for the member view
			include $sec_html_files.'pageHeaderPrivate.html';
			include $html_files.'pageMemberMenu.html';
						
			$MsgTitle = $regemailtitle;
			$MsgType = "Thank you, $logonName";
			$Msg1 = "There is no image to delete here! Please review your action";
			$Msg2= "To View and/or Post new $priv_content_desc or Update your Profile click on the link below.";
			include $sec_html_files.'member.html';
			include $sec_html_files.'pageFooterPrivate.html';
			exit();
		}
		mysqli_query($link, "delete from ".$tbl_name4."
			WHERE $adid = iFileAdId
					and $imageid = iFileID") 
		or die('-MyAdDelete.php (Delete of '.$tbl_name4.' Table failed)- '.mysqli_error().'');

		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		include $sec_html_files.'pageHeaderPrivate.html';
		include $html_files.'pageMemberMenu.html';
		
		$MsgTitle = $regemailtitle;
		$MsgType = "Thank you, $logonName";
		$Msg1 = "Your image Id #$imageid was deleted successfully.";
		$Msg2= "To View and/or Post new $priv_content_desc or Update your Profile click on the link below.";
		include $sec_html_files.'member.html';
		include $sec_html_files.'pageFooterPrivate.html';
		exit();

	}
}
else
{
	// Implement private header html code to produce page container
	// Followup with custom menu for the member view
	include $sec_html_files.'pageHeader2.html';
	include $html_files.'pageHeaderMenu.html';
	
	//if the session does not exist, they are returned to the login screen
	//header("Location: Login.php");
	//echo ('Session does not exist: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
	$MsgTitle = "MEMBER";
	$redirect = "Logout.php";
	$MsgType = "Member.php Warning:";
	$Msg1 = "User name and password sesssion lost";
	$Msg2= "Please re-establish credentials with Login.";
	$button = "Login";
	include $sec_html_files.'loginMsg.html';
	include $html_files.'pageFooter.html';
	unset($_POST['submit']);
	exit();

}
?>