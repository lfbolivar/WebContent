<?php 

//  This establishes the database variables and initiates the db connection
$host_param     = 'localhost';			// Host name 
$db_username_param = 'lfbolivar';	// Mysql username 
$db_pass_param = 'Tereb!nth';	// Mysql password 
$db_name_param  = 'WebContent';	// Database name 
$db_session_name = 'mamp_session'; // Session DB Name
$db_session_table = 'session'; //session table name
$db_session_host = 'localhost';  // session host

// load new $data array for database classes.
//This establishes the database variables and initiates the db connection
$tbl_name2 = "user";
$data = [];   // empty array for db_user class
$data = ["host" => $host_param,			// Host name
		"user" => $db_username_param,	// Mysql username
		"pass" => $db_pass_param,	    // Mysql password
		"name" => $db_name_param,	    // Database name
		"table2" => $tbl_name2];		// user Table name

?>