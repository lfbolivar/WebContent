<?php 

//  This establishes the database variables and initiates the db connection
$host_param     = 'localhost';			// Host name 
$db_username_param = 'lfbolivar';	// Mysql username 
$db_pass_param = 'Tereb!nth';	// Mysql password 
$db_name_param  = 'WebContent';	// Database name 
$db_session_name = 'mamp_session'; // Session DB Name
$db_session_table = 'session'; //session table name

// load new $data array for database classes.
//  This establishes the database variables and initiates the db connection
$tbl_name2 = "user";
$tbl_name3 = "ad";
$tbl_name4 = "image";
$tbl_name5 = "category";
$data = [];   // empty array for db_user class
$data = ["host" => $host_param,			// Host name
		"user" => $db_username_param,	// Mysql username
		"pass" => $db_pass_param,	    // Mysql password
		"name" => $db_name_param,	    // Database name
		"table" => $tbl_name2,			// user Table name
		"table3" => $tbl_name3,	 		// Ad Table
		"table4" => $tbl_name4,			// Image Table
		"table5" => $tbl_name5			// category table
		];		

?>