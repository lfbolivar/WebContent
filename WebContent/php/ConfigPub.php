<?php
###############################################################
/* This section contains the registration email variables */
###############################################################
$regemailtitle = 'Bolitech.com  Web Classified Advertisements (ClassAds)';
$regemailaddr = 'webmaster@bolitech.com';
$localregion = "World Wide Web";

###############################################################
/* This section contains the public application variables */
###############################################################
// Variables to establish Public and Private Header text values and fonts.
$pub_header_title = "Web Classified Advertisements (Non-Secured Test App Public)";  // Value displays in pageHeader.html
$pub_header_font = 'Calibri,Arial,"Times New Roman",Times,serif'; //font-family for public (Gallery) displays in pageHeader.html
$pub_welcome_message = 'Welcome to Web ClassAds!';  // Custom welcome message for public (gallery) displays in pageHeader.html
$pub_welcome_message2 = 'Once an Ad is validated via email it is viewable here in the Public Gallery! To Create an Ad click on the Member link below';  // Custom welcome message for public (gallery) displays in pageHeader.html
$pub_content_desc = "Content";  // description of content displayed in AdDetail.php and browsedetails.html
$pub_header_color = "blue";  // Background color on header frame.
$pub_container_color = "solid gray";  //  Container color
$pub_header_type_color = "white";  //  lettering/font color

// Public Gallery image configuration variables.
$pub_browseAd_bg_image = "../images/14-ball.PNG";  // image displayed as background on main page.

// set path for location of files on the server
$url_css = "http://www.bolitech.com/~bolitest/ClassAds/css/";
$url_images = "http://www.bolitech.com/~bolitest/ClassAds/images/";
$url_home = "http://www.bolitech.com/~bolitest/ClassAds/";
$url_php = "http://www.bolitech.com/~bolitest/ClassAds/php/";
$url = "http://www.bolitech.com/~bolitest/";
$sec_url_images = "http://www.bolitech.com/~bolitest/ClassAds/images/";
$sec_url_php = "http://www.bolitech.com/~bolitest/ClassAds/php/";

$css_files = "/home/bolitest/public_html/ClassAds/css/";
$html_files = "/home/bolitest/public_html/ClassAds/html/";
$php_files  = "/home/bolitest/public_html/ClassAds/php/";
$images_files  = "/home/bolitest/public_html/ClassAds/images/";

$sec_css_files = "/home/bolitest/public_html/ClassAds/css/";
$sec_html_files = "/home/bolitest/public_html/ClassAds/html/";
$sec_php_files  = "/home/bolitest/public_html/ClassAds/php/";
$sec_images_files  = "/home/bolitest/public_html/ClassAds/images/";

#######################################################
/* optional configuration options */
#######################################################

# table settings for images display
define('ROWS', 3);
define('COLS', 5);

# thumbnail demensions
define('THMBWIDTH', 160);
define('THMBHEIGHT',160);

# gallery title
define('TITLE', "Test Clasificados");

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

//Sets year on all footers
$year = date(o);

