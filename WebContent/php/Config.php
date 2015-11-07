<?php
###############################################################
/* This section contains the registration email variables */
###############################################################
$regemailtitle = 'Bolitech.com  Web Classified Advertisements (ClassAds)';
$regemailaddr = 'webmaster@bolitech.com';
$localregion = "World Wide Web";

// Variables to establish Public and Private Header text values and fonts.
$pub_header_title = "Free Web Classified Advertisements";  // Value displays in pageHeader.html
$pub_header_font = 'Calibri,Arial,"Times New Roman",Times,serif'; //font-family for public (Gallery) displays in pageHeader.html
$pub_welcome_message = 'Welcome to Free Web Classified Advertisements!';  // Custom welcome message for public (gallery) displays in pageHeader.html
$pub_welcome_message2 = 'Once your membership is validated via email you can activate and view your content in the Public Gallery! To Register, Login or upload content click on the Member link below';  // Custom welcome message for public (gallery) displays in pageHeader.html
$pub_content_desc = "Content";  // description of content displayed in AdDetail.php and browsedetails.html
$pub_header_color = "blue";  // Background color on header frame.
$pub_container_color = "solid gray";  //  Container color
$pub_header_type_color = "white";  //  lettering/font color

$priv_content_desc = "Item";  // description of content displayed in MyAdDetail.php and mydetails.html
$priv_header_title = "Web Class Ad (Member Portal)";  // Value displays in pageHeaderPrivate.html
$priv_header_font = 'Arial,"Times New Roman",Times,Calibri,serif'; //font-family for public (Gallery) displays in pageHeader.html
$priv_body_font = 'Calibri,Arial,"Times New Roman",Times,serif'; //font-family for private displays in private *.html
$priv_welcome_message = 'Congratulations you have registered successfully.  Welcome to Web ClassAds personal Advertisement Entry Tool!';  // Custom welcome message for public (gallery) displays in pageHeader.html
$priv_welcome_message2 = 'To view or modify your Ad select your ';  // Custom welcome message for public (gallery) displays in pageHeader.html
$priv_header_color = "orange";  // Background color on header frame.
$priv_menu_color = "purple";
$priv_container_color = "white";

// Public Gallery image configuration variables.
$pub_browseAd_bg_image = "../images/lightyellow.PNG";  // image displayed as background on main page.

// Private area image configuration variables.
$priv_logonMsg_bg_image = "../images/fishingboat.jpg";  // image displayed as background on logonMsg.html page.
$priv_logonMsg_form_image = "../images/myboat.jpg";  // image displayed on form of logonMsg.html page.
$priv_logon_bg_image = "../images/fishingboat.jpg";  // image displayed as background on logon.html page.
$priv_logon_form_image = "../images/myboat.jpg";  // image displayed aon form of logon.html page.
$priv_member_bg_image = "../images/fishingboat.jpg";  // image displayed as background on member.html page.
$priv_member_form_image = "../images/myboat.jpg";  // image displayed on form of member.html page.
$priv_register_bg_image = "../images/fishingboat.jpg";  // image displayed as background on register.html page.
$priv_register_form_image = "../images/myboat.jpg";  // image displayed on form of register.html page.
$priv_profile_bg_image = "../images/fishingboat.jpg";  // image displayed as background on myprofile.html page.
$priv_profile_form_image = "../images/myboat.jpg";  // image displayed on form of myprofile.html page.
$priv_newad_bg_image = "../images/fishingboat.jpg";  // image displayed as background on myprofile.html page.
$priv_newad_form_image = "../images/myboat.jpg";  // image displayed on form of myprofile.html page.
$priv_upload_bg_image = "../images/fishingboat.jpg";  // image displayed as background on myprofile.html page.
$priv_upload_form_image = "../images/myboat.jpg";  // image displayed on form of myprofile.html page.
$priv_newadmsg_bg_image = "../images/fishingboat.jpg";  // image displayed as background on myprofile.html page.
$priv_newadmsg_form_image = "../images/myboat.jpg";  // image displayed on form of myprofile.html page.
$priv_myAd_bg_image = "../images/14-ball.PNG";  // image displayed as background on main page.
$priv_background_image = "adbackground2.jpg";  // set your background image on all private *.html pages

// set path for location of files on the server
$css_files = "/home/bolitest/public_html/ClassAds/css/";
$html_files = "/home/bolitest/public_html/ClassAds/html/";
$php_files  = "/home/bolitest/public_html/ClassAds/php/";
$images_files  = "/home/bolitest/public_html/ClassAds/images/";
$home_files = "/home/bolitest/public_html/ClassAds/";

$sec_css_files = "/home/bolitest/public_html/ClassAds/css/";
$sec_html_files = "/home/bolitest/public_html/ClassAds/html/";
$sec_php_files  = "/home/bolitest/public_html/ClassAds/php/";
$sec_images_files  = "/home/bolitest/public_html/ClassAds/images/";

$url_css = "http://www.bolitech.com/~bolitest/ClassAds/css/";
$url_images = "http://www.bolitech.com/~bolitest/ClassAds/images/";
$url_home = "http://www.bolitech.com/~bolitest/ClassAds/";
$url_php = "http://www.bolitech.com/~bolitest/ClassAds/php/";
$url = "http://www.bolitech.com/~bolitest/";
$sec_url_images = "http://www.bolitech.com/~bolitest/ClassAds/images/";
$sec_url_php = "http//www.bolitech.com/~bolitest/ClassAds/php/";

#######################################################
/* optional configuration options */
#######################################################

# table settings for images display
define('ROWS', 3);
define('COLS', 5);

# thumbnail demensions
define('THMBWIDTH', 120);
define('THMBHEIGHT',100);

# gallery title
define('TITLE', "Web Class Ad");

# watermark your images, ie,
# define('WATERMARK', "This is a watermark");
define('WATERMARK', $_SERVER['HTTP_HOST']);

#######################################################
/* advanced configuration options */
#######################################################
# for extra security, store your images in a folder outside
# of the public webtree and define the path, ie,
define('PRIVATE_SESSION', '/home/bolitest/php/');
define('PRIVATE_DB', '/home/bolitest/php/ClassAds/');
# NOTE: there is no ending slash
//define('PROTECTED', str_replace('\\', '/', getcwd()));

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
$max = (60 * 5);

