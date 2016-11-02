<?php

// Basically what this does is check to see if the form has been submitted.
// If it has been submitted it checks to make sure that the data is all OK (passwords match, email isn't in use) as documented in the code.
// If everything is OK it adds the user to the database, if not it returns the appropriate error.
// If the form has not been submitted, they are shown the registration form, which collects the email and password.
//  Local config allows for dynamic definition of file paths and single point for private paths
require_once "setConfig.php";

//  If they are not logged in they are redirected to the login page.
// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

//  Include the db connection script from non html location
include PRIVATE_DB."dbConfig.php";

// First check if session was created and currently exists.
if(!isset($_SESSION['ClassAdsEmail']))
{
	$modal = '<a href="#loginmodal" class="flatbtn" id="modaltrigger">Member</a>';
}else{
	$modal = '<a href="Member.php">Member</a>';
}

// Implement private header html code to produce page container
// Followup with custom menu for the member view
include $sec_html_files.'pageHeader2.html';
include $html_files.'pageHeaderMenu.html';

	//This code runs if the form has been submitted
if (isset($_POST['register']))
{
	//This makes sure they did not leave any fields blank
	if (!$_POST['email'] | !$_POST['pass'] | !$_POST['pass2'] )
	{
		//die('You did not complete all of the required fields');
		$myemail=$_POST['email'];
		$MsgTitle = "Register.php ";
		$redirect = "Register.php";
		$MsgType = "Warning:";
		$Msg1 = "You did not complete all of the required fields(*).";
		$Msg2= "Enter the required fields and click the Register button.";
		$button = "Back";
		include $sec_html_files.'register.html';
		include $html_files.'pageFooter.html';
		unset($_POST['register']);
		exit();
	}

	// checks if the email is in use
	if (!get_magic_quotes_gpc())
	{
		$_POST['email'] = addslashes($_POST['email']);
	}

	// email and password sent from form
	$myemail=$_POST['email'];
	$mypassword=$_POST['pass'];

	//$usercheck = $_POST['email'];
	$check = mysqli_query($link, "SELECT vchEmail FROM ".$tbl_name." WHERE vchEmail = '$myemail'")
	or die(mysqli_error($link));
	$check2 = mysqli_affected_rows($link);

	//if the name exists it gives an error
	if ($check2 != 0)
	{
		//die('Sorry, the email '.$_POST['email'].' is already in use.');
		$MsgTitle = "Register.php";
		$redirect = "Logon.php";
		$MsgType = "Error:";
		$Msg1 = "I am sorry, the Email: ".$myemail.",";
		$Msg2= "is already in use click on the Member link on the left to logon.";
		//$button = "Logon";
		include $sec_html_files.'register.html';
		include $html_files.'pageFooter.html';
		unset($_POST['register']);
		exit();
	}

	// this makes sure both passwords entered match
	if ($_POST['pass'] != $_POST['pass2'])
	{
		//die('Your passwords did not match. ');
		$MsgTitle = "Register.php";
		$redirect = "Register.php";
		$MsgType = "Error:";
		$Msg1 = "I am sorry, the passwords for: ".$myemail.",";
		$Msg2= "did not match, Please try again.";
		$button = "Register";
		include $sec_html_files.'register.html';
		include $html_files.'pageFooter.html';
		unset($_POST['register']);
		exit();
	}

	if (!get_magic_quotes_gpc())
	{
		$_POST['pass'] = addslashes($_POST['pass']);
		$_POST['email'] = addslashes($_POST['email']);
	}

	// here we encrypt the password and add slashes if needed
	$_POST['pass'] = md5($_POST['pass']);

	// email and password sent from form
	$myemail=$_POST['email'];
	$mypassword=$_POST['pass'];

	// Validate email and and if successful continue otherwise show error
	include $sec_php_files.'ValidateEmail.php';
	$email = $myemail;
	if (validate_email($email))
	{
		// echo "Email is valid!";
		include $sec_php_files.'RegEmail.php';
	}
	else
	{
		//  echo "Email is invalid!";
		//die('Your email address is no good. ');
		$MsgTitle = "Register.php";
		$redirect = "Register.php";
		$MsgType = "Error:";
		$Msg1 = "I am sorry, the email address ".$myemail." is not valid.";
		$Msg2= "Please provide a valid email address, thank you.";
		$button = "Register";
		include $sec_html_files.'register.html';
		include $html_files.'pageFooter.html';
		unset($_POST['register']);
		exit();
	}

	// To protect MySQL injection (more detail about MySQL injection)
	$myemail = stripslashes($myemail);
	$mypassword = stripslashes($mypassword);
	$myemail = mysqli_real_escape_string($link, $myemail);
	$mypassword = mysqli_real_escape_string($link, $mypassword);

	// now we insert it into the database
	$today = DATE(c);
	$insert = "INSERT INTO ".$tbl_name." (vchEmail, vchPassword, dtRegistered)
		VALUES ('$myemail', '$mypassword', '$today')";
	$add_member = mysqli_query($link, $insert);

	// set session email and password to go right into Member page.
	// From Register.php we always destroy existing session to stay clean
	// Password is already hashed don't re hash it
	$_SESSION['ClassAdsEmail'] = $myemail;
	$_SESSION['ClassAdsPassword'] = $mypassword;
	//session_write_close();

	// <h1>Registered</h1>
	// <p>-Register.php- Thank you, you have registered - you may now <a href=Logon.php>Logon</a>.</p>
	$MsgTitle = "Register.php";
	$redirect = "Member.php";
	$MsgType = "Message:";
	$Msg1 = "Thank you! You have successfully registered email: ".$myemail.",";
	$Msg2= "Click on the Member button to enter the Members Area.";
	$button = "Member";
	include $sec_html_files.'register.html';
	unset($_POST['register']);
	include $html_files.'pageFooter.html';
	exit();
}
else
{
	$MsgTitle = "Register.php";
	include $sec_html_files.'register.html';
	include $html_files.'pageFooter.html';
	exit();
}
?>

