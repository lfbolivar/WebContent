<?php
//  This code checks our session to make sure the user is logged in, the same way the login page did.
//  If they are logged in, they are shown the members area.
//  If they are not logged in they are redirected to the login page.

//  Local config allows for dynamic definition of file paths and single point for private paths
require_once "setConfig.php";
require $class_files.'user.php';

//  Sets path for files and start session.
//  Sets path for files, start session and get session variables if they exist.
require_once 'class/session.php';
$objSess = new Session(Null);
$session_vars = $objSess->readSession();

// First check if session was created and currently exists.
// Check for an active session using database session handler
if ($session_vars != FALSE) {

	//if there is an active session, it logs you in and directs you to the members page
	$email = $session_vars['sessionEmail'];
	$pass = $session_vars['sessionPass'];

	$session = new Member($email, $pass, null);
	$session->member_session_found();

} else {
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