<?
/*
 * Created: 10/16/2016
 * Author:  LF Bolivar
 *
 * New Category.php script to call new Gallery class and modularize the functions associated with vewing public content.
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
if(!isset($session_vars['sessionEmail'])){
	$modal = '<a href="#loginmodal" class="flatbtn" id="modaltrigger">Logon</a>';
} else {
	$modal = '<a href="Member.php">ToolBox</a>';
}
$cat = array();
// This Category php script is used to display all open (un-expired) classifieds as a drill down 
// from Browse script without a login or registration.
// Detail select query by Category passed from the browseAd.html page.
if (isset($_POST['catid'])){
	$cat['catdesc'] = $_POST['catdesc'];
	$cat['catid'] = $_POST['catid'];
	
	// New Class gallery calls method display_category()	
	$objGallery = new Gallery();
	$objGallery->display_gallery($cat);
} else {
	if (isset($_REQUEST['cat'])) {
		//print_r($_REQUEST);
		$cat['catid'] 		= $_REQUEST['cat'];
		$cat['catdesc'] 	= $_REQUEST['catd'];
		$objGallery = new Gallery();
		$objGallery->display_gallery($cat);
		
	} else {
	//require $url_php.'index.php?p=Browse.php';
	//echo ($_POST['cat'].'Form is not set');
	//exit();
		$objGallery = new Gallery();
		$objGallery->display_gallery(null);
		
	}
}
?>