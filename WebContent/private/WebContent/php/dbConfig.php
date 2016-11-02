<?php 

$objConfig = Config::getInstance();
$priv_app_files = $objConfig->get('priv_app_files');
require $priv_app_files.'sysParams/dbConfig_params.php';

//  This establishes the database variables and initiates the db connection
$db_host     = $host_param;			// Host name 
$db_username = $db_username_param;	// Mysql username 
$db_pass = $db_pass_param;	// Mysql password 
$db_name  = $db_name_param;	// Database name 
$tbl_name = "member";				// member Table name
$tbl_name2 = "user";				// user Table name
$tbl_name3 = "ad";					// advertisement Table name
$tbl_name4 = "image";				// images table name
$tbl_name5 = "category";			// categories table name

// load new $data array for database classes.
//  This establishes the database variables and initiates the db connection
$data = [];   // empty array for db_user class
$data = ["host"   => $host_param,			// Host name
         "user"   => $db_username_param,	// Mysql username
         "pass"   => $db_pass_param,	    // Mysql password
         "name"   => $db_name_param,	    // Database name
         "table"  => $tbl_name2,			// user Table name
         "table3" => $tbl_name3,			// ad Table name
         "table4" => $tbl_name4,			// image Table name
         "table5" => $tble_name5			// category table name
		];		

// Connects to the ClassAds Database 
$link = mysqli_connect($db_host, $db_username, $db_pass, $db_name) or 
  die('MySQL DB '.$db_name.' Connection error: '.mysqli_connect_error().' '); 
mysqli_select_db($link, $db_name) or 
  die('MySQL DB '.$db_name.' mysqli_select_db error: '.mysqli_error($link).' '); 

?>