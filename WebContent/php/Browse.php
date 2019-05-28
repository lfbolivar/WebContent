<?php
/*
 * Created: 10/3/2016
 * Author:  LF Bolivar
 * 
 * New Browse.php script to call new Gallery class and modularize the functions associated with vewing public content.
 * 
 */
//  Local config allows for dynamic definition of file paths and single point for private paths
//  get the user class to process logon method
require_once 'setConfig.php';
require_once 'class/gallery.php';

//  Sets path for files and start session.
//  Sets path for files, start session and get session variables if they exist.
require_once 'class/session.php';
$objSess = new Session(Null);
$session_vars = $objSess->readSession();

// First check if session was created and currently exists.
$objConfig = Config::getInstance();
if(!isset($session_vars['sessionEmail'])) {
	// The $modal variable is holding the login parameters that allow jQuery code to display login form
	// Once the user login is complete this variable then stores/points to the Member.php to facilitate session use.
	$modal = '<a href="#loginmodal" class="flatbtn" id="modaltrigger">Logon</a>';
	
} else {
	$modal = '<a href="Member.php">ToolBox</a>';
}

$cat = array();
//print_r($modal);
//echo($session_vars['sessionEmail']);

$objConfig->set('modal', $modal);
	
$objGallery = new Gallery();
$objGallery->display_gallery($cat);

?>