<?php
/*
 * Author: LF Bolivar
 * Update: 8/4/2016
 * Revision 1.0
 * 
 * Script: Logon.php
 * Reduce code space and redistribute logic in an Object Oriented Design.  Simplify the edits down
 * to basic session and post checks, and initialization of central html page on startup.
 *
 *  This script first checks to see if the logon information is contained in a session on the web server.
 *     If it is, it tries to log them in. If this is successful they are redirected to the members area.
 *     - Now replaced by user.php (user class) with a call to db_user.php (db_user class) to retrieve user record.
 *       - method logon_session_found()
 * 
 *     If there is no cookie or db session, it allows them to logon, then a session is established.
 *     - Now replaced by user.php and db_user.php (user and db_user class)
 *       - method logon_session_NOTfound()
 *
 *         If the form has been logged on and a session established, it checks it against the database 
 *         and if it was successful sets a cookie and takes them to the members area.
 *
 *     If it has not been logged on and no session established, it shows them the logon html form.
 */
 
 /*
  *  Local config allows for dynamic definition of file paths and single point for private paths
  */
// get the user class to process logon method
require_once 'setConfig.php';
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
	
	$session = new User($email, $pass, null);
	$session->logon_session_found();

} else {

	// When no session is found check to see if the logon form is posted
	if (isset($_POST['logon'])){

		// The form is set and contains logon credentials
		// Make sure they filled in email and password required fields
		if(!$_POST['email'] | !$_POST['pass']){
		
			$email = null;
			$pass  = null;
		}

		// checks it against the database
		if (!get_magic_quotes_gpc()){
			//$_POST['email'] = addslashes($_POST['email']);
			//$_POST['pass'] = addslashes($_POST['pass']);

		    //if there is an active session, it logs you in and directs you to the members page
			$email = addslashes($_POST['email']);
			$pass = addslashes($_POST['pass']);

		}
		$session = new User($email, $pass, null);
		$session->logon_session_NOTfound();

	} else {

		//  Load variables to assist user in re-establishing logon credentials and access
		$params = array();
		$params['modal'] = '<a href="#loginmodal" class="flatbtn" id="modaltrigger">Logon</a>';
/*	
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		include $sec_html_files.'pageHeader2.html';
		include $html_files.'pageHeaderMenu.html';
*/	
		$params['MsgTitle'] = "Logon.php";
		$params['MsgType'] = "Welcome:";
		$params['Msg1'] = "To Logon to the Member's Area and store content please click on the";
		$params['Msg2'] = "Logon link on the left.";
/*
		include $sec_html_files.'logonNew.html';
		include $html_files.'pageFooter.html';
		exit();*/
		
		$session = new User();
		$session->timed_out($params);
		
	}
}
?>