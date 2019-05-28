<?php
/*
 * Created: 11/27/2016
 * Author:  LF Bolivar
 *
 * New NewAdForm2.php script to call new Content class and modularize the functions
 * associated with inserting content into the Ad table via the WorkBench toolbox.
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

	if (isset($_POST['AdCategory'])){

		// If the user is submitting values in the form, then we validate content of required fields before any DB update.
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
		
		// Load the image meta data when present
		if (isset($_POST['AdNoUpload'])){
			$data['fileName'] = $_FILES['userfile']['name'];
			$data['tmpName']  = $_FILES['userfile']['tmp_name'];
			$data['fileSize'] = $_FILES['userfile']['size'];
			$data['fileType'] = $_FILES['userfile']['type'];
			// print_r($data);
			}
		
		// Validity check passed and we begin to initialize DB variables before insert of AD table row.
		// Allow original dtAdDate to remain intact. $AdDate = DATE(c);
		$di			= intval($_POST['AdPeriod']);
		$nAdValid	= intval($_POST['AdValid']);
		
		//  This command computes expiration date using integer of AD period.
		$AdExpireDate = date("y-m-d",mktime(0, 0, 0, date(m),date(d)+$di,date(y)));
		
		$data['AdValid']		= $nAdValid;
		$data['AdExpireDate']	= $AdExpireDate;
		
		$obj_content = new Content($data);
		$obj_content->insert_content();
		
	} else {
	
		// If the category field is not set then we display empty form so the user can input variables.
		$obj_content = new Content(null);
		$obj_content->display_content_form();
	}

} else {
	/*
	 * Implement public header html code to produce page container
	 * Followup with logonMsg and allow user to submit credentials
	 */
	$params = array();
	$params['modal'] = '<a href="#loginmodal" class="flatbtn" id="modaltrigger">Logon</a>';
	
	//header("Location: Login.php");
	//echo ('Session does not exist: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
	$params['MsgTitle'] = "MEMBER";
	$params['redirect'] = "Logout.php";
	$params['MsgType'] = "Member.php Warning:";
	$params['Msg1'] = "User name and password sesssion lost";
	$params['Msg2']= "Please re-establish credentials with Logon.";
	$params['button'] = "Login";
	
	unset($_POST['submit']);
	
	require_once 'class/user.php';
	
	$obj_user = new User(NULL, NUll, NUll);
	$obj_user->timed_out($params);
	
}
?>