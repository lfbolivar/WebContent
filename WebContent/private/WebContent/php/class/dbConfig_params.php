<?php 

//  This establishes the database variables and initiates the db connection
$host_param     = 'localhost';			// Host name 
$db_username_param = 'lfbolivar';	// Mysql username 
$db_pass_param = 'Tereb!nth';	// Mysql password 
$db_name_param  = 'WebContent';	// Database name 
$db_port_param = 8889;  // Added 9/23/18 with upgrade to PHP 7.2.8 MySql 5.7.23

//  Session specific
$db_session_user = 'lfbolivar'; //  session pass
$db_session_pass = 'Tereb!nth'; //  session pass
$db_session_name = 'mamp_session'; // Session DB Name
$db_session_host = 'localhost';  // session host
$db_session_table = 'sessions'; //session table name


// load new $data array for database classes.
//  This establishes the database variables and initiates the db connection
$tbl_name1 = "member";
$tbl_name2 = "user";
$tbl_name3 = "ad";
$tbl_name4 = "image";
$tbl_name5 = "category";
$data = [];   // empty array for db_user class
$data = ["host" => $host_param,			// Host name
		"user" => $db_username_param,	// Mysql username
		"pass" => $db_pass_param,	    // Mysql password
		"name" => $db_name_param,	    // Database name
        "table1" => $tbl_name1,			// member table
		"table2" => $tbl_name2,			// user Table name
		"table3" => $tbl_name3,	 		// Ad Table
		"table4" => $tbl_name4,			// Image Table
		"table5" => $tbl_name5,			// category table
		"port" => $db_port_param            //  Added 9/23/18 with upgrade to PHP 7.2.8 MySQL 5.7.23
		];		

?>