<?
//  Local config allows for dynamic definition of file paths and single point for private paths
require_once "setConfig.php";

//  If they are not logged in they are redirected to the login page.
// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

//  Include the db connection script from non html location
include PRIVATE_DB."dbConfig.php";

// First check if session was created and currently exists.
if(isset($_SESSION['ClassAdsEmail']))
{
	if(isset($_GET['email']))
	{
		// Activate any inactive Ad with email provided in the ActivateAdEmail; table_name3=Ad table.
		$adEmail = $_GET['email'];
		// echo ($adEmail);
		if(!mysqli_query($link,"update ".$tbl_name3." set tiAdValid = 1 where vchUserEmail = '$adEmail'"))
		{
			if (mysql_errno() == 1062)
			{
				echo mysql_errno()." : duplicate key error returned from MySQL";
			}
			else
			{
				echo mysql_errno()." : error returned from MySQL";
			}
		}
		else
		{
			if(!mysqli_query($link,"update ".$tbl_name2." set iNum_ads = (iNum_ads + 1) where vchEmail = '$adEmail'"))
			{
				echo mysql_errno()." : could not increment ad counter in User table; error returned from MySQL";
			}
			else
			{
				//  Activiation of add via Update was successful.
				$msg1 = "Thank you, your Ad has been activated.";
				$msg2 = " Your Los Cabos Classified Ad is viewable in our public area.";
				include $html_files.'newAdMsg.html';
				exit();
			}
		}
	}
	else
	{
		//  Someone is trying to execute the script without the email parameter.
		$msg1 = "This php script is not accessible via URL.";
		$msg2 = " Your Los Cabos Classified Ads are need to be activated from your private area.";
		include $html_files.'newAdMsg.html';
		exit();
	}
}
else
{
	//if the session does not exist, they are returned to the login screen
	//header("Location: Login.php");
	//echo ('Session does not exist: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
	$MsgTitle = "MEMBER";
	$redirect = "Logout.php";
	$MsgType = "ActivateAd.php Warning:";
	$Msg1 = "User name and password sesssion lost";
	$Msg2= "Please re-establish credentials with Login.";
	$button = "Logon";
	include $html_files.'logonMsg.html';
	unset($_POST['submit']);
	exit();
}
?>