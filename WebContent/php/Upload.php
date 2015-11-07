<?
//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

//  If they are not logged in they are redirected to the login page.
// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to your Database
//  Include the db connection script from non public_html location
include PRIVATE_DB."dbConfig.php";

// First check if session was created and currently exists.
if(isset($_SESSION['ClassAdsEmail']))
{
	$sessionEmail = $_SESSION['ClassAdsEmail'];
	$sessionPass = $_SESSION['ClassAdsPassword'];
	$logonName = $_SESSION['ClassAdsLogonName'];

	// Implement private header html code to produce page container
	// Followup with custom menu for the member view
	include $sec_html_files.'pageHeaderPrivate.html';
	include $html_files.'pageMemberMenu.html';
	
	if(isset($_POST['upload']))
	{

		// If the UPLOAD form is submitted initialize variables used to insert image UPLOAD row.
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];

		// Check to make sure user is providing a file to upload otherwise display message to upload at a later time
		if (empty($fileName))
		{
			//echo "<br>File $fileName uploaded<br>";
			$msg1 = "You have completed posting your '$priv_content_desc' and have chosen not to upload an image file at this time";
			$msg2 = "You can upload images for your '$priv_content_desc' via the AD update page.";
			include $sec_html_files.'newAdMsg.html';
			include $sec_html_files.'pageFooterPrivate.html';
			exit();
		}
		else
		{
			$fp = fopen($tmpName, 'r');
			$content = fread($fp, $fileSize);
			$content = addslashes($content);
			fclose($fp);

			// Prep file name in case it contains slashes in the name.
			if(!get_magic_quotes_gpc())
			{
				$fileName = addslashes($fileName);
			}

			// First we meed to retrieve the latest AD added by this user.
			if (isset($_POST['myAd']))
			{
				$AdId =  $_POST['myAd'];
				$query = "SELECT iAdId 'Ad' FROM ".$tbl_name3." WHERE vchUserEmail = '$sessionEmail' and vchUserPassword = '$sessionPass' and $AdId = iAdId";
			}
			else
			{
				$query = "SELECT max(iAdId) 'Ad' FROM ".$tbl_name3." WHERE vchUserEmail = '$sessionEmail' and vchUserPassword = '$sessionPass'";
			}
			$getAd = mysqli_query($link, $query )or die('-Upload.php- '.mysqli_error().'');

			//Gives error if we cannot find the latest AD from user.
			$checkAdId = mysqli_affected_rows($link);
			if ($checkAdId == 0)
			{
				//die('-Login.php- That user does not exist in our database. <a href=Register.php>Click Here to Register</a>');
				$MsgTitle = "UPLOAD";
				$redirect = "UPLOAD.php";
				$MsgType = "Upload.php Message:";
				$Msg1 = "Unable to retrieve the latest AD for this member.";
				$Msg2= "Click button below to Re-establish your session at the Login.";
				$button = "Login";
				include $sec_html_files.'logonMsg.html';
				include $sec_html_files.'pageFooterPrivate.html';
				unset($_POST['submit']);
				exit();
			}

			// We have found the latest AD and are ready to update both the AD table and Insert the image file in the UPLOAD table.
			while($Adrow = mysqli_fetch_array( $getAd ))
			{
				//	echo (' ad# '.$Adrow['iAdId']);
				$fileAdId = $Adrow['Ad'];
				$Name = $Adrow['vchAdUserName'];
			}

			// Insert image row into UPLOAD table.
			$query = "INSERT INTO ".$tbl_name4." VALUES (0,'$fileAdId', '$fileName', '$fileType', '$fileSize', '$content')";
			mysqli_query($link, $query) or die('-Upload.php- Error, query failed'.mysqli_error().'');

			//echo "<br>File $fileName uploaded<br>";
			$msg1 = "Thank you, $logonName, you have completed your image upload";
			$msg2 = " with file name $fileName stored in the $priv_header_title database.";
			include $sec_html_files.'newAdMsg.html';
			include $sec_html_files.'pageFooterPrivate.html';
			exit();
		}
	}
	else
	{
		// If upload form is not set, display upload HTML form for user input.
		include $sec_html_files.'upload.html';
		exit();
	}
}
else
{
	//if the cookie does not exist, they are taken to the login screen
	//header("Location: Login.php");
	//echo ('Session does not exist: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
	$MsgTitle = "UPLOAD";
	$redirect = "Logout.php";
	$MsgType = "Member.php Warning:";
	$Msg1 = "User name and password sesssion lost";
	$Msg2= "Please re-establish credentials with Login.";
	$button = "Login";
	include $sec_html_files.'logonMsg.html';
	unset($_POST['submit']);
	exit();
}
?>