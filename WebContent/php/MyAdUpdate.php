<?php
//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

//  If they are not logged in they are redirected to the login page.
// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to your Database
//  Include the db connection script from non html location
include PRIVATE_DB."dbConfig.php";

// Function used for validity of fields and re-display on return so that user does not need to re-enter data.
function show_form3($AdId="",$AdCategory="", $AdPeriod="", $AdCaption= "", $AdHeadline="",$AdURL="",$AdDesc="", $AdNoUpload="", $AdValid="")
{
	global $options;
}

// First check if session was created and currently exists.
if(isset($_SESSION['ClassAdsEmail']))
{
	$sessionEmail = $_SESSION['ClassAdsEmail'];
	$sessionPass = $_SESSION['ClassAdsPassword'];
	$logonName = $_SESSION['ClassAdsLogonName'];

	// Implement private header html code to produce page container
	// Followup with custom menu for the member view
	include $sec_html_files.'pageHeaderPrivate.html';
	include $html_files.'pageMemberMenu.html';
	
	//The routine LoadCatArray.php will select all catagories from the Catagory table and format them for loading into the $options array.
	include $php_files.'LoadCatArray.php';
	
	// If the category field is not set then we display empty form so the user can input variables.
	if (!isset($_POST['AdCategory']))
	{
		// echo('Category: '.$AdCategory);
		$msg1 = "Welcome to ".$regemailtitle." ".$first." ".$last.", ";
		$msg2 = "to update your '$priv_content_desc' please select below.";
		include $html_files.'member.html';
		// $func = 'show_form2';
		include $sec_html_files.'pageFooterPrivate.html';
		show_form3();
	}
	// Else, the user is submitting values in the form and we validate content of required fields before any DB update.
	else
	{
		$AdId = $_POST['AdId'];
		$AdCategory = $_POST['AdCategory'];
		$AdPeriod = $_POST['AdPeriod'];
		$AdCaption = $_POST['AdCaption'];
		$AdHeadline = $_POST['AdHeadline'];
		$AdNoUpload = $_POST['AdNoUpload'];
		$AdDesc = $_POST['AdDesc'];
		$AdURL = $_POST['AdURL'];
		$AdValid = $_POST['AdValid'];
		// echo('Category: '.$AdCategory.' Adperiod: '.$AdPeriod.' AdCaption: '.$AdCaption.' AdHeadline: '.$AdHeadline.' AdDesc: '.$AdDesc.'\n');

		// Validation of required fields.
		if(empty($AdCategory) or empty($AdPeriod) or empty($AdCaption) or empty($AdHeadline) or empty($AdDesc))
		{
			$msg1 = "Please provide required '*' ";
			$msg2 = "fields, and resubmit request\n";
			include $html_files.'mydetails.html';
			include $sec_html_files.'pageFooterPrivate.html';
			show_form3($AdId,$AdCategory,$AdPeriod,$AdCaption,$AdHeadline,$AdURL,$AdDesc,$AdValid);
		}
		else
		{
			// Validity check passed and we begin to initialize DB variables before insert of AD table row.
			// Allow original dtAdDate to remain intact. $AdDate = DATE(c);
			$AdUserName = $logonName;
			$AdUserEmail = $sessionEmail;
			$AdUserPassword = $sessionPass;
			$AdUserId = 0;
			$di = intval($AdPeriod);
			$nAdValid = intval($AdValid);
				
			//  This command computes expiration date using integer of AD period.
			$AdExpireDate = date("y-m-d",mktime(0, 0, 0, date(m),date(d)+$di,date(y)));
				
			// Insert into AD table with minimal error handling.
			mysqli_query($link,"update ".$tbl_name3." set vchAdCaption = '$AdCaption'
				,vchAdHeadLine = '$AdHeadline',vchAdDesc = '$AdDesc', vchAdURL = '$AdURL', dtAdExpireDate = '$AdExpireDate'
				,iAdPeriod = '$di',vchUserEmail = '$AdUserEmail', vchUserPassword = '$AdUserPassword'
				,vchAdUserName = '$AdUserName', iAdCatId = '$AdCategory', tiAdValid = '$nAdValid'
				WHERE iAdId = '$AdId'")
			or die('-MyAdUpdate.php (Update Ad Table)- '.mysqli_error().'');

			//  On successful update route back to member.html.
			$MsgTitle = $regemailtitle;
			$MsgType = "Thank you, ".$logonName.";";
			$Msg1 = "You have successfully updated your web content and extended your expiration";
			$Msg2 = "If you chose to activate your content it will now be visible in the Public Gallery.";
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
	
	//if the session does not exist, they are returned to the login screen
	//header("Location: Login.php");
	//echo ('Session does not exist: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
	$MsgTitle = "Member.php";
	$redirect = "Logout.php";
	$MsgType = "Warning:";
	$Msg1 = "User name and password sesssion lost";
	$Msg2= "Please re-establish credentials with Login.";
	$button = "Login";
	include $sec_html_files.'logonNew.html';
	include $sec_html_files.'pageFooter.html';
	unset($_POST['submit']);
	exit();

}
?>