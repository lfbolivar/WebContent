<?php
/*
 * Created: 10/26/2016
* Author:  LF Bolivar
*
* New MyAdDetail.php script to call new Gallery class and modularize the functions
* associated with vewing private workbench content.
*
*/
//  Local config allows for dynamic definition of file paths and single point for private paths
require_once "setConfig.php";
require_once 'class/content.php';

//  Sets path for files and start session.
//  Sets path for files, start session and get session variables if they exist.
require_once 'class/session.php';
$objSess = new Session(Null);
$session_vars = $objSess->readSession();
/*
// Function used for validity of fields and re-display on return so that user does not need to re-enter data.
function show_form3($AdId="",$AdCategory="", $AdPeriod="", $AdCaption= "", $AdHeadline="",$AdURL="",$AdDesc="", $AdNoUpload="", $AdValid="")
{
	global $options;
}
*/
// First check if session was created and currently exists.
if(isset($session_vars['sessionEmail'])) {
	
	$sessionEmail 	= $session_vars['sessionEmail'];
	$sessionPass 	= $session_vars['sessionPass'];
	$logonName 		= $session_vars['sessionName'];
/*
	// Implement private header html code to produce page container
	// Followup with custom menu for the member view
	include $sec_html_files.'pageHeaderPrivate.html';
	include $html_files.'pageMemberMenu.html';
	
	//The routine LoadCatArray.php will select all catagories from the Catagory table and format them for loading into the $options array.
	include $php_files.'LoadCatArray.php';
*/	
	// If the category field is not set then we display empty form so the user can input variables.
	if (isset($_POST['AdCategory'])){

		// Else, the user is submitting values in the form and we validate content of required fields before any DB update.
		$data['UserEmail']		= $sessionEmail;
		$data['UserPass']	= $sessionPass;
		$data['UserName']		= $logonName;
		
		$data['AdId']			= $_POST['AdId'];
		$data['AdCatId']		= $_POST['AdCategory'];
		$data['AdPeriod']		= $_POST['AdPeriod'];
		$data['AdCaption']		= $_POST['AdCaption'];
		$data['AdHeadline']		= $_POST['AdHeadline'];
		$data['AdNoUpload']		= $_POST['AdNoUpload'];
		$data['AdDesc']			= $_POST['AdDesc'];
		$data['AdURL']			= $_POST['AdURL'];
		$data['AdUserId']		= 0;

		// Validity check passed and we begin to initialize DB variables before insert of AD table row.
		// Allow original dtAdDate to remain intact. $AdDate = DATE(c);
		$di			= intval($_POST['AdPeriod']);
		$nAdValid	= intval($_POST['AdValid']);

		//  This command computes expiration date using integer of AD period.
		$AdExpireDate = date("y-m-d",mktime(0, 0, 0, date(m),date(d)+$di,date(y)));

		$data['AdValid']		= $nAdValid;
		$data['AdExpireDate']	= $AdExpireDate;

		$obj_WB = new Content();
		$obj_WB->update_content($data);
/*				
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
			
			try {
				$obj_ad = new db_ad($data);
				$result = $obj_ad->update();
			} catch(PDOException $ex) {
				//Something went wrong rollback!
				//$db->rollBack();
				echo $ex;
			}
/*			mysqli_query($link,"update ".$tbl_name3." set vchAdCaption = '$AdCaption'
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
*/
	} else {
		$objWB = new Gallery();
		$objWB->display_workbench($session_vars);
		
/*		
		//	No Post form variables for AdCategory result in initial empty form display.
		// echo('Category: '.$AdCategory);
		$msg1 = "Welcome to ".$regemailtitle." ".$first." ".$last.", ";
		$msg2 = "to update your '$priv_content_desc' please select below.";
		include $html_files.'member.html';
		// $func = 'show_form2';
		include $sec_html_files.'pageFooterPrivate.html';
		show_form3();
*/
	}	// End of Post logic for AdCategory form
} else {
	
	//	No session found display message and provide correct menu
	// Implement public header html code to produce page container
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