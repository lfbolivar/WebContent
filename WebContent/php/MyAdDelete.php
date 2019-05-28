<?php
/* ScriptName:	MyAdDelete.php
 * Created: 	12/07/2016
 * Modified:	07/16/2017
 * Author:  	LF Bolivar
 *
 * Enhanced MyAdDelete.php script calls new image.class and ad.class with modularized functions
 * associated with deleting content in the image and ad(content) tables via the WorkBench toolbox.
 *
 * For the purposes of making this version of the code more generic, you can associate Ad table
 * with Content class.
 */
//  Local config allows for dynamic definition of file paths and single point for private paths
require_once "setConfig.php";
require_once 'class/image.php';
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

	// Check to see whether to delete an Ad row or an Image row.
	if (isset($_POST['AdId'])) {
		// load the form values needed to do the delete
		$content = array();
		$content['AdId'] = $_POST['AdId'];
		$content['imageid'] = $_POST['ImageId'];
		$content['deltype'] = $_POST['deltype'];
		
		$obj_WB = new Content($content);
		$obj_WB->delete_content();
		
	} else {
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		include $sec_html_files.'pageHeaderPrivate.html';
		include $html_files.'pageMemberMenu.html';
				
		$msg1 = "Welcome to $regemailtitle, $logonName,";
		$msg2 = "to update your $priv_content_desc please select below.";
		include $sec_html_files.'member.html';
		include $sec_html_files.'pageFooterPrivate.html';
		exit();
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
	$params['button'] = "Logon";
	
	unset($_POST['submit']);
	
	require_once 'class/user.php';
	
	$obj_user = new User();
	$obj_user->timed_out($params);
	
}
?>