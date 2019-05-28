<?
/*
 * Created: 10/25/2016
 * Author:  LF Bolivar
 *
 * New MyCategory.php script to call new Gallery class and modularize the functions associated with vewing private content.
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
if(isset($session_vars['sessionEmail'])) {
	
	// This Category php script is used to display all open classifieds as a drill down from View My Ad script registered logged in members.
	// Detail select query by Category passed from the browseAd.html page.
	if (isset($_POST['mycatid'])) {
		//  Loading the $CatBody before include of pageHeaderPrivate.html allows the display of specific level in the left pane.
		$CatBody = $_POST['mycatdesc'];
		
		//	inner join ".$tbl_name4." I on A.iAdId = I.iFileAdId
		$session_vars['catid'] 		= $_POST['mycatid'];
		$session_vars['catdesc'] 	= $_POST['mycatdesc'];

		$objWB = new Gallery();
		$objWB->display_workbench($session_vars);
		
	} else {
		if (isset($_REQUEST['cat'])) {
			//print_r($_REQUEST);
			$session_vars['catid'] 		= $_REQUEST['cat'];
			$session_vars['catdesc'] 	= $_REQUEST['catd'];
			$objWB = new Gallery();
			$objWB->display_workbench($session_vars);
				
		} else {
			include $sec_php_files.'ViewMyAd.php';
			//echo ($_POST['cat'].'Form is not set');
			exit();
		}
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
	$params['MsgTitle'] = "MY CATEGORY";
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