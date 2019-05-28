<?php
/*
 * Created: 11/27/2016
 * Author:  LF Bolivar
 *
 * New NewAd.php script to call new Content class and modularize the functions
 * associated with updating content in the Ad table via the WorkBench toolbox.
 *
 */
//  Local config allows for dynamic definition of file paths and single point for private paths
require_once "setConfig.php";
require $class_files.'user.php';

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

	// New content class allows for dynamic/abstract definition of file paths and
	// Singleton Pattern access to public and private set paths
	// if there is an active session, it it displays and empty content form
	// Member extends User class and provides validation of existing login user
	// Before displaying the Content Entry form in the Workbench window.
	
	$obj_member = new Member($sessionEmail, $sessionPass, null);
	$obj_member->member_request_to_post_content();

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
	$params['button'] = "Logon";
	
	unset($_POST['submit']);
	
	require_once 'class/user.php';
	
	$obj_user = new User();
	$obj_user->timed_out($params);
	
}
?>