<?php
//  This establishes the database variables and initiates the db connection
global $_hostname;
$_hostname = "localhost";			// Host name

global $_session_user;
$_session_user = 'lfbolivar';	// Mysql username
// echo ($_SERVER['DB_USER']."\n");

global $_session_pass;
$_session_pass = 'Tereb!nth';	// Mysql password
// echo ($_SERVER['DB_PASS']."\n");

global $_session_db_name;
$_session_db_name = 'mamp_session';	// Database name

global $_session_tbl_name;
$_session_tbl_name = 'sessions';	// member Table name

global $_connection;
$_connection = mysqli_init();
if (!mysqli_real_connect($_connection , $_hostname, $_session_user, $_session_pass, $_session_db_name))
{
	die ("Failed _open() @mysqli_connect");
}
if (!mysqli_select_db($_connection,$_session_db_name))
{
	die ("Failed _open() mysqli_select_db to ".$_session_db_name);
}

// these are session variables that control the GC garbage collection time
// must be set via root logon.
//ini_set(�session.gc_maxlifetime�,30);
//ini_set(�session.gc_probability�,1);
//ini_set(�session.gc_divisor�,1);

// connect to sessions db and start session
require_once("sessionHandler.php");

?>