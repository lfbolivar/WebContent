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
if(!isset($session_vars['sessionEmail']))
{
	$modal = '<a href="#loginmodal" class="flatbtn" id="modaltrigger">Member</a>';
}else{
	$modal = '<a href="Member.php">Member</a>';
}

// Include Cascading Style Sheet definition
// include $html_files.'pageHeader.html';
$cat = array();
// Load the category for the body with public content description.
$cat['catdesc'] = $pub_content_desc.' #'.$_POST['Ad'];
//include $html_files.'pageBody.html';

// This Category php script is used to display all open (un-expired) classifieds as a drill down from Browse Ad script without a login or registration.
// Detail select query by Category passed from the browseAd.html page.
if (isset($_POST['Ad']))
{
	$cat['ad'] = $_POST['Ad'];
	if (empty($_POST['AdNbr'])){
		$FileId = 0;
	}else{
		$FileId = $_POST['AdNbr'];		
	}
	$cat['FileId'] = $FileId;
	// New Class gallery calls method display_category()
	$objGallery = new Gallery();
	$objGallery->display_gallery($cat);
}
else
{
	include $php_files.'index.php?p=Browse.php';
	//echo ($_POST['cat'].'Form is not set');
	exit();
}
?>