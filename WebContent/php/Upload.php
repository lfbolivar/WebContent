<?
/*
 * Created: 12/07/2016
 * Author:  LF Bolivar
 *
 * New Upload.php script to call new image.class and modularize the functions
 * associated with updating content in the image table via the WorkBench toolbox.
 *
 */
//  Local config allows for dynamic definition of file paths and single point for private paths
require_once "setConfig.php";
require_once 'class/image.php';

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

	
	if(isset($_POST['upload'])) {

		// If the UPLOAD form is submitted initialize variables used to insert image UPLOAD row.
		$image_metadata = array();
		$image_metadata['fileName'] = $_FILES['userfile']['name'];
		$image_metadata['tmpName']  = $_FILES['userfile']['tmp_name'];
		$image_metadata['fileSize'] = $_FILES['userfile']['size'];
		$image_metadata['fileType'] = $_FILES['userfile']['type'];

		// First store the max size image.
		$obj_WB = new Thumbnail($image_metadata);
		$image_metadata['tmpName']= $obj_WB->resize_image();
		
		// Then create a thumbnail and resize for consistant display 
		$image_metadata['thmbName']= $obj_WB->crop_image();
		
		$obj_WB = new Image($image_metadata);
		$obj_WB->upload_image();
		
	} else {
		// If upload form is not set, display upload HTML form for user input.
		require $sec_html_files.'upload.html';
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
	$params['MsgTitle'] = "UPLOAD";
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