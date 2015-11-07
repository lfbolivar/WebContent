<?php
//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

//  All our logout page does is destroy the session, and then direct them back to the logon page.
//  We destroy the session by calling session config file, intializing and destroying current session.
//  We also clear the $_SESSION array.
// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();
$_SESSION = array();
session_destroy();

// Connects to member table of PlayaLos_ClassAds Database
//  Include the db connection script from non public_html location
include PRIVATE_DB."dbConfig.php";

// Since session was destroyed above allow the user to re-logon.
$modal = '<a href="#loginmodal" class="flatbtn" id="modaltrigger">Logon</a>';

// Implement public header html code to produce page container
// Followup with logonMsg and allow user to submit credentials
include $sec_html_files.'pageHeader2.html';
include $html_files.'pageHeaderMenu.html';

$MsgTitle = "Logout.php";
$redirect = "Logon.php";
$MsgType1 = "Logout.php";
$MsgType2 = "Message LO-001";
$Msg1 = "Your session was closed successfully.";
$Msg2= "Click the Logon button in the left pane to re-establish your session";
$button = "Logon";
//include $html_files.'pageBodyPrivate.html';
include $sec_html_files.'logonNew.html';
include $html_files.'pageFooter.html';
unset($_POST['logon']);
exit();
?>
