<?php
#######################################################
/*
 *  File Name: setConfig.php
 *  Created by: LF Bolivar
 *  Contact: lfbolivar@bolitec.org, bolitec.org
 *  Last Modified: Nov 8 2015
 *                 May 9 2016
 *  
 *  Configuration does the following things:
 *  - Has site settings in one location
 *  - Stores URLs and URIs as constants
 *  - Advanced configuration and security options 
 *
 */
require'class/Config.php';

#  *************************************************** #
#  *****************   SETTINGS   ******************** #
$objConfig = Config::getInstance();

//  Errors are emailed here:
$developer_email = "webmaster@bolitec.org";

//  Determine whether we are working on a local or production server
$host = substr($_SERVER[HTTP_HOST], 0, 5);
if (in_array($host, array('local', '127.0', '192.1'))){
	$local = TRUE;
} ELSE {
	$local = FALSE;
}

// Determine location of files and the URL of the site:
// Allow development on different servers.
if ($local){
	
	// Always debug when running locally:
	$debug = TRUE;
	
    //  Save the domain and app name for loading system variables and master pages
    //  Test system variables
    $domain = 'bolitec.org';
    $sec_domain = 'http://localhost:8888/WebContent/WebContent/';
	$app_name = 'WebContent/';
    $pub_path = '/Users/Fernando/Documents/2015/Projects/WebContent/WebContent/';
    $priv_path = '/Users/Fernando/Documents/2015/Projects/WebContent/WebContent/private/';
    
} else {
	
	// Production system Variables
    $domain = 'bolitec.org';
    $sec_domain = 'https://secure.bolitec.org/';
	$app_name = 'WebContent/';
    $pub_path = '/home/bolitec/public_html/secure/';
    $priv_path = '/home/bolitec/WebContent/';
	
//  $base_uri = "".$app_name."/";
//	$base_url = "https://secure.bolitec.org/".$app_name."/";
	
	// For extra security, store your files in a folder outside
	// of the public webtree and define the path, ie,
//	define('PRIVATE_SESSION', '/home/lbolivar/php/');
//	define('PRIVATE_DB', '/home/lbolivar/php/ClassAds/');
	
}
//  Set local or production variables
$objConfig->set('domain', $domain);


// Define the constants:
$base_uri = $pub_path;
$base_url = $sec_domain;

// The $modal variable is holding the login parameters that allow jQuery code to display login form
// Once the user login is complete this variable then stores/points to the Member.php to facilitate session use.
//$modal = '<a href="#loginmodal" class="flatbtn" id="modaltrigger">Logon</a>';
//$objConfig->set('modal', $modal);

// Set path for location of files on the server
$css_files = $base_uri."css/";
$objConfig->set('css_files', $base_uri."css/");

$html_files = $base_uri."html/";
$objConfig->set('html_files', $base_uri."html/");

$php_files  = $base_uri."php/";
$objConfig->set('php_files', $base_uri."php/");

$images_files  = $base_uri."images/";
$objConfig->set('images_files', $base_uri."images/");

$class_files = $base_uri."php/class/";
$objConfig->set('class_files', $base_uri."php/class/");

$home_files = $base_uri;
$objConfig->set('home_files', $base_uri);


// https secured path location on server
$sec_css_files = $base_uri."css/";
$objConfig->set('sec_css_files', $base_uri."css/");

$sec_html_files = $base_uri."html/";
$objConfig->set('sec_html_files', $base_uri."html/");

$sec_php_files  = $base_uri."php/";
$objConfig->set('sec_php_files', $base_uri."php/");

$sec_images_files  = $base_uri."images/";
$objConfig->set('sec_images_files', $base_uri."images/");


// url path locations on server
$url_css = $base_url."css/";
$objConfig->set('url_css', $base_url."css/");

$url_images = $base_url."images/";
$objConfig->set('url_images', $base_url."images/");

$url_home = $base_url;
$objConfig->set('url_home', $base_url);

$url_php = $base_url."php/";
$objConfig->set('url_php', $base_url."php/");

$url = $base_url;
$objConfig->set('url', $base_url);

$sec_url_images = $base_url."images/";
$objConfig->set('sec_url_images', $base_url."images/");

$sec_url_php = $base_url."php/";
$objConfig->set('sec_url_php', $base_url."php/");


//  Private path location on server or workspace if development environment
$priv_app_files = $priv_path.$app_name;
$objConfig->set('priv_app_files', $priv_path.$app_name);

$priv_php_files = $priv_path.$app_name."php/";
$objConfig->set('priv_php_files', $priv_path.$app_name."php/");

$priv_class_files  = $priv_php_files."class/";
$objConfig->set('priv_class_files', $priv_php_files."class/");

// For extra security, store your files in a folder outside
// of the public webtree and define the path, ie,
define('PRIVATE_SESSION', $priv_path);
$objConfig->set('PRIVATE_SESSION', $priv_path);


$objConfig->set('PRIVATE_DB', $priv_php_files);
define('PRIVATE_DB', $priv_php_files);

###############################################################
/* This section contains the registration email variables */
###############################################################
$regemailtitle = 'WebContent';
$regemailaddr = 'webmaster@bolitec.org';
$localregion = "World Wide Web";

// Variables to establish Public and Private Header text values and fonts.
$pub_header_title = "WebContentTest";  // Value displays in pageHeader.html
$objConfig->set('pub_header_title', $pub_header_title);

$pub_header_font = 'Calibri,Arial,"Times New Roman",Times,serif'; //font-family for public (Gallery) displays in pageHeader.html

$pub_welcome_message = 'Welcome to the Web Content App!';  // Custom welcome message for public (gallery) displays in pageHeader.html
$objConfig->set('pub_welcome_message', $pub_welcome_message);

$pub_welcome_message2 = 'Once your membership is validated via email you can activate and view your content in the Public Gallery! To Register, Login or upload content click on the Member link below';  // Custom welcome message for public (gallery) displays in pageHeader.html
$objConfig->set('pub_welcome_message2', $pub_welcome_message2);

$pub_content_desc = "Content";  // description of content displayed in AdDetail.php and browsedetails.html
$objConfig->set('pub_content_desc', $pub_content_desc);

$pub_header_color = "blue";  // Background color on header frame.
$pub_container_color = "solid gray";  //  Container color
$pub_header_type_color = "white";  //  lettering/font color

$priv_content_desc = "Content";  // description of content displayed in MyAdDetail.php and mydetails.html
$objConfig->set('priv_content_desc', $priv_content_desc);

$priv_header_title = "WorkBench";  // Value displays in pageHeaderPrivate.html
$objConfig->set('priv_header_title', 'WorkBench');

$priv_header_font = 'Arial,"Times New Roman",Times,Calibri,serif'; //font-family for public (Gallery) displays in pageHeader.html
$priv_body_font = 'Calibri,Arial,"Times New Roman",Times,serif'; //font-family for private displays in private *.html

$priv_welcome_message = 'Congratulations you have registered successfully.  Welcome to Web WebContent personal Advertisement Entry Tool!';  // Custom welcome message for public (gallery) displays in pageHeader.html
$objConfig->set('priv_welcome_message', $priv_welcome_message);

$priv_welcome_message2 = 'To view or modify your Ad select your ';  // Custom welcome message for public (gallery) displays in pageHeader.html
$objConfig->set('priv_welcome_message2', $priv_welcome_message2);

$priv_header_color = "orange";  // Background color on header frame.
$priv_menu_color = "purple";
$priv_container_color = "white";

// Public Gallery image configuration variables.
$pub_browseAd_bg_image = "../WebContent/images/shopping.jpg";  // image displayed as background on main page.

// Private area image configuration variables.
$priv_logonMsg_bg_image = "/images/fishingboat.jpg";  // image displayed as background on logonMsg.html page.
$priv_logonMsg_form_image = "/images/myboat.jpg";  // image displayed on form of logonMsg.html page.
$priv_logon_bg_image = "/images/fishingboat.jpg";  // image displayed as background on logon.html page.
$priv_logon_form_image = "/images/myboat.jpg";  // image displayed aon form of logon.html page.
$priv_member_bg_image = "../images/fishingboat.jpg";  // image displayed as background on member.html page.
$priv_member_form_image = "../images/myboat.jpg";  // image displayed on form of member.html page.
$priv_register_bg_image = "../".$app_name."/images/fishingboat.jpg";  // image displayed as background on register.html page.
$priv_register_form_image = "../".$app_name."/images/myboat.jpg";  // image displayed on form of register.html page.
$priv_profile_bg_image = "../".$app_name."/images/fishingboat.jpg";  // image displayed as background on myprofile.html page.
$priv_profile_form_image = "../".$app_name."/images/myboat.jpg";  // image displayed on form of myprofile.html page.
$priv_newad_bg_image = "../".$app_name."/images/fishingboat.jpg";  // image displayed as background on myprofile.html page.
$priv_newad_form_image = "../".$app_name."/images/myboat.jpg";  // image displayed on form of myprofile.html page.
$priv_upload_bg_image = "../".$app_name."/images/fishingboat.jpg";  // image displayed as background on myprofile.html page.
$priv_upload_form_image = "../".$app_name."/images/myboat.jpg";  // image displayed on form of myprofile.html page.
$priv_newadmsg_bg_image = "../".$app_name."/images/fishingboat.jpg";  // image displayed as background on myprofile.html page.
$priv_newadmsg_form_image = "../".$app_name."/images/myboat.jpg";  // image displayed on form of myprofile.html page.
$priv_myAd_bg_image = "../".$app_name."/images/14-ball.PNG";  // image displayed as background on main page.
$priv_background_image = "../".$app_name."/images/adbackground2.jpg";  // set your background image on all private *.html pages

#######################################################
/* optional configuration options */
#######################################################

# table settings for images display
define('ROWS', 3);
define('COLS', 4);

# thumbnail demensions
define('THMBWIDTH', 80);
define('THMBHEIGHT',80);

# gallery title
define('TITLE', "WebContentApp");

# watermark your images, ie,
# define('WATERMARK', "This is a watermark");
define('WATERMARK', $_SERVER['HTTP_HOST']);

# location to self
define('SELF', $_SERVER['PHP_SELF']);

# allowed image MIME types
define('TYPE', serialize(array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png')));

# check for GD library
if(!function_exists('imagegif')) {
	die("<html>\r\n<body>\r\n<b>ERROR:</b> You either do not have the GD library installed, or you are using an outdated version of the library that does not support GIF images. If you are not concerned about GIF images, then you may remove this check from the configuration file. Otherwise, you will need to install or upgrade the GD library before you are able to use this gallery. Please visit <a href=\"http://www.php.net/gd\">http://www.php.net/gd</a> for more information.\r\n</body>\r\n</html>");
}

// Set max variable with number of minutes to time out the session
// The computation is (secs * mins)
$max = (60 * 1);

#  *****************   SETTINGS   ******************** #
#  *************************************************** #
/*
 * Most Important setting!
 * The $debug variable is used to set error management.
 * To debug a specific page, add this to the index.php page:
 * if ($p == 'thismodule') {
 *    $debug - TRUE;
 *    require($sec_php_files.'setConfig.php');
 * }
 *    
 * To debug the entire site, do
 * $debug = TRUE;
 * 
 * before this next conditional
 */
 
 //  Assume debugging is off
if (!isset($debug)) {
	$debug = FALSE;
} 

require_once'class/err_handler.php';
$err = new errHandler();
$err->myErrorHandler($e_number, $e_message, $e_file, $e_line, $e_vars);
