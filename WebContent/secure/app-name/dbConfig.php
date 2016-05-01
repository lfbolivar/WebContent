<?php

//  This establishes the database variables and initiates the db connection
$host     = "localhost";			// Host name
$port     = 8889;     // PortMySQL
$username = "lfbolivar";	// Mysql username
$passpass = "Tereb!nth";	// Mysql password
$db_name  = "WebContent";	// Database name
$tbl_name = "member";				// member Table name
$tbl_name2 = "user";				// user Table name
$tbl_name3 = "ad";					// advertisement Table name
$tbl_name4 = "image";				// images table name
$tbl_name5 = "category";			// categories table name

// Connects to the ClassAds Database
$link = mysqli_init();
$link = mysqli_connect( $host, $username, $passpass, $db_name, $port) 
   or die('MySQL DB '.$db_name.' Connection error: '.mysqli_connect_error().' ');
mysqli_select_db($link, $db_name) 
   or die('MySQL DB '.$db_name.' mysqli_select_db error: '.mysqli_connect_error().' ');

?>