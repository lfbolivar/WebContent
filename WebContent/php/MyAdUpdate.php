<?php
/*
 * Created: 10/26/2016
 * Author:  LF Bolivar
 *
 * New MyAdUpdate.php script to call new Content class and modularize the functions
 * associated with updating content in the Ad table via the WorkBench toolbox.
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

// First check if session was created and currently exists.
if(isset($session_vars['sessionEmail'])) {
	
	$sessionEmail 	= $session_vars['sessionEmail'];
	$sessionPass 	= $session_vars['sessionPass'];
	$logonName 		= $session_vars['sessionName'];

	// If the category field is not set then we display empty form so the user can input variables.
	if (isset($_POST['AdCategory'])){

		// Else, the user is submitting values in the form and we validate content of required fields before any DB update.
		$data['UserEmail']		= $sessionEmail;
		$data['UserPass']		= $sessionPass;
		$data['UserName']		= $logonName;
		
		$data['AdId']			= $_POST['AdId'];
		$data['AdCatId']		= $_POST['AdCategory'];
		$data['AdPeriod']		= $_POST['AdPeriod'];
		$data['AdCaption']		= $_POST['AdCaption'];
		$data['AdHeadline']		= $_POST['AdHeadline'];
		$data['AdNoUpload']		= $_POST['AdNoUpload'];
		$data['AdDesc']			= htmlentities($_POST['AdDesc']);
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

		$obj_WB = new Content($data);
		$obj_WB->update_content();
		
	} else {
		
		$objWB = new Gallery();
		$objWB->display_workbench($session_vars);
		
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