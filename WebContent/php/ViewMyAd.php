<?php
/*
 * Created: 10/24/2016
 * Author:  LF Bolivar
 *
 * New ViewNyAd.php script to call new Gallery class and modularize the functions associated with vewing private content.
 *
 */
//  Local config allows for dynamic definition of file paths and single point for private paths
require_once "setConfig.php";
require_once 'class/gallery.php';

//  Sets path for files and start session.
//  Sets path for files, start session and get session variables if they exist.
require_once 'class/session.php';
$objSess = new Session(Null);
$session_vars = $objSess->readSession();

// First check if session was created and currently exists.
if(isset($session_vars['sessionEmail'])){

	$objWB = new Gallery();
	$objWB->display_workbench($session_vars);
}
else
{
	/*
	 * Implement public header html code to produce page container
	 * Followup with logonMsg and allow user to submit credentials
	 */
	$params = array();
	$params['modal'] = '<a href="#loginmodal" class="flatbtn" id="modaltrigger">Logon</a>';
	
	//header("Location: Login.php");
	//echo ('Session does not exist: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
	$params['MsgTitle'] = "VIEW MY AD";
	$params['redirect'] = "Logon.php";
	$params['MsgType'] = "Member.php Warning:";
	$params['Msg1'] = "User name and password sesssion lost";
	$params['Msg2']= "Please re-establish credentials with Logon.";
	$params['button'] = "Login";
	
	unset($_POST['submit']);
	
	require_once 'class/user.php';
	
	$obj_user = new User(null, null, null);
	$obj_user->timed_out($params);
}
?>