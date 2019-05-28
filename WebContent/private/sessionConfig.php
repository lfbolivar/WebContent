<?php
$objConfig = Config::getInstance();
require $objConfig->get('priv_app_files').'sysParams/dbConfig_params.php';

//  This establishes the database variables and initiates the db connection
global $_hostname;
$_hostname = $host_param;			// Host name

global $_session_user;
$_session_user = $db_username_param;	// Mysql username
// echo ($_SERVER['DB_USER']."\n");

global $_session_pass;
$_session_pass = $db_pass_param;	// Mysql password
// echo ($_SERVER['DB_PASS']."\n");

global $_session_db_name;
$_session_db_name = $db_session_name;	// Database name

global $_session_tbl_name;
$_session_tbl_name = $db_session_table;	// member Table name

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