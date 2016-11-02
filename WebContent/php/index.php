<?php
/*
 *		This is the main page.
 *		This page will include the configuration file,
 *		the templates, and any content-specific modules.
 */

//	Require the configuration file before any PHP code:
require_once 'setConfig.php';

//	Validate what page to show:
if (isset($_GET['p'])) {
	$p = $_GET['p'];
} elseif (isset($_POST['p'])) {
	$p = $_POST['p'];	
} else {
	$p = NULL;
}

//	Determine what page to display:
switch ($p) {
	
	case 'login':
		$page = 'Logon.php';
		$page_title = 'Logon';
		break;
		
	case 'logout':
		$page = 'Logout.php';
		$page_title = 'Logout';
		break;

	case 'search':
		$page = 'Search.php';
		$page_title = 'Search';
		break;
		
	default:
		$page = 'Browse.php';
		$page_title = 'Browse';
		break;
		
}	//	End of main switch

//	Make sure the file exists:
if(!file_exists($page)) {
	$page = 'Browse.php';
	$page_title = 'Home';
}

// Include the header file:
// require '../html/pageHeader.html';

//	Include the content-specific module:
//	$page is determined from the above switch.
require '../php/'.$page;

//	Include the footer file to complete the template:
require '../html/pageFooter.html';

?>