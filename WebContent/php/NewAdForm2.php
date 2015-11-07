<?
//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

//  If they are not logged in they are redirected to the login page.
// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to your Database
//  Include the db connection script from non html location
include PRIVATE_DB."dbConfig.php";

// Function used for validity of fields and re-display on return so that user does not need to re-enter data.
function show_form2($AdCategory="", $AdPeriod="", $AdCaption= "", $AdHeadline="",$AdURL="",$AdDesc="", $AdNoUpload="")
{
	global $options;
}

// First check if session was created and currently exists.
if(isset($_SESSION['ClassAdsEmail']))
{
	$sessionEmail = $_SESSION['ClassAdsEmail'];
	$sessionPass = $_SESSION['ClassAdsPassword'];
	$logonName = $_SESSION['ClassAdsLogonName'];

	// Make sure that you redirect to NewAdForm2 in case you came from NewAd and skipped NewAdForm.
	$redirect = "NewAdForm2.php";

	//The routine LoadCatArray.php will select all catagories from the Catagory table and format them for loading into the $options array.
	include $php_files.'LoadCatArray.php';

	// If the category field is not set then we display empty form so the user can input variables.
	if (!isset($_POST['AdCategory']))
	{
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		include $sec_html_files.'pageHeaderPrivate.html';
		include $html_files.'pageMemberMenu.html';
		
		// echo('Category: '.$AdCategory);
		$msg1 = "Welcome to ".$regemailtitle." ".$first." ".$last.", ";
		$msg2 = "to post your add please complete the details below.";
		include $sec_html_files.'newAdForm2.html';
		// $func = 'show_form2';
		include $sec_html_files.'pageFooterPrivate.html';
		show_form2();
	}
	// Else, the user is submitting values in the form and we validate content of required fields before any DB update.
	else
	{
		$AdCategory = $_POST['AdCategory'];
		$AdPeriod = $_POST['AdPeriod'];
		$AdCaption = $_POST['AdCaption'];
		$AdHeadline = $_POST['AdHeadline'];
		$AdNoUpload = $_POST['AdNoUpload'];
		//fix to my text problem 2013-11-25 using strip_tags and mysqli->real_escape_string
		echo ($AdDesc);
		$AdDesc = htmlentities($_POST['AdDesc']);
		// $AdDesc = mysqli_real_escape_string($link,$AdDesc);
		$AdURL = $_POST['AdURL'];
		// echo('Category: '.$AdCategory.' Adperiod: '.$AdPeriod.' AdCaption: '.$AdCaption.' AdHeadline: '.$AdHeadline.' AdDesc: '.$AdDesc.'\n');

		// Validation of required fields.
		if(empty($AdCategory) or empty($AdPeriod) or empty($AdCaption) or empty($AdHeadline) or empty($AdDesc))
		{
			// Implement private header html code to produce page container
			// Followup with custom menu for the member view
			include $sec_html_files.'pageHeaderPrivate.html';
			include $html_files.'pageMemberMenu.html';
			
			$msg1 = "Please provide required '*' ";
			$msg2 = "fields, and resubmit request\n";
			include $sec_html_files.'newAdForm2.html';
			include $sec_html_files.'pageFooterPrivate.html';
			show_form2($AdCategory,$AdPeriod,$AdCaption,$AdHeadline,$AdURL,$AdDesc);
		}
		else
		{
			// Validity check passed and we begin to initialize DB variables before insert of AD table row.
			$AdDate = DATE(c);
			$AdUserName = $logonName;
			$AdUserEmail = $sessionEmail;
			$AdUserPassword = $sessionPass;
			$AdUserId = 0;
			$di = intval($AdPeriod);
				
			//  This command computes expiration date using integer of AD period.
			$AdExpireDate = date("y-m-d",mktime(0, 0, 0, date(m),date(d)+$di,date(y)));
				
			// Insert into AD table with minimal error handling.
			if(!mysqli_query($link,"insert into ".$tbl_name3." values
				(0,'$AdCaption','$AdHeadline','$AdDesc','$AdURL','$AdDate','$AdExpireDate','$AdPeriod',0,0,'$AdUserEmail','$AdUserId','$AdUserPassword','','','','','','',0,'',0,'$AdUserName',0,'$AdCategory')"))
			{
				if (mysqli_errno($link) == 1062)
				{
					echo mysqli_errno($link).": duplicate key error returned from MySQL";
				}
				else
				{
					echo mysqli_errno($link).": error returned from MySQL";
				}
			}
			else
			{
				// echo($NoUpload);
				include $sec_php_files.'ActivateAdEmail.php';
				if (!isset($AdNoUpload))
				{
					// Successful insert of AD row and message to the 3d and final page to upload image (optional since AD has been inserted)
					$msg1 = "Thank you, ".$first." ".$last.", you have completed the second of three steps";
					$msg2 = " in posting your add in ".$AdCategory." as your Classified Category.\n";
					include $sec_php_files.'Upload.php';
					exit();
				}
				else
				{
					// Implement private header html code to produce page container
					// Followup with custom menu for the member view
					include $sec_html_files.'pageHeaderPrivate.html';
					include $html_files.'pageMemberMenu.html';
					
					//  User chose to upload an image at a later time.
					$msg1 = "Thank you, $first $last, you have completed the second step to publish your AD";
					$msg2 = " you can upload an image at a later time from Los Cabos Classifieds Members menu.";
					include $sec_html_files.'newAdMsg.html';
					include $sec_html_files.'pageFooterPrivate.html';
					exit();
				}

			}
		}
	}
}
else
{
	// Implement private header html code to produce page container
	// Followup with custom menu for the member view
	include $sec_html_files.'pageHeader2.html';
	include $html_files.'pageHeaderMenu.html';
	
	//if the session does not exist, they are returned to the login screen
	//header("Location: Login.php");
	//echo ('Session does not exist: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
	$MsgTitle = "MEMBER";
	$redirect = "Logout.php";
	$MsgType = "Member.php Warning:";
	$Msg1 = "User name and password sesssion lost";
	$Msg2= "Please re-establish credentials with Login.";
	$button = "Login";
	include $sec_html_files.'logonNew.html';
	include $html_files.'pageFooter.html';
	unset($_POST['submit']);
	exit();

}
?>