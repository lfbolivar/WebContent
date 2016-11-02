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
	// Implement public header html code to produce page container
	// Followup with logonMsg and allow user to submit credentials
	include $sec_html_files.'pageHeader.html';
	include $html_files.'pageHeaderMenu.html';
	
	//if the session does not exist, you are taken to the login screen
	//header("Location: Login.php");
	//echo ('Session does not exist: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
	$MsgTitle = "VIEW MY AD";
	$redirect = "Logon.php";
	$MsgType = "Member.php Warning:";
	$Msg1 = "User name and password sesssion lost";
	$Msg2= "Please re-establish credentials with Login.";
	$button = "Logon";
	include $sec_html_files.'logonMsg.html';
	include $sec_html_files.'pageFooter.html';
	unset($_POST['submit']);
	exit();
}
?>