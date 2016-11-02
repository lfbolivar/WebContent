<?PHP
//  Local config allows for dynamic definition of file paths and single point for private paths
require_once "setConfig.php";

//  If they are not logged in they are redirected to the login page.
// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to the Database
//  Include the db connection script from non public_html location.  Security feature.
include  PRIVATE_DB."dbConfig.php";

function show_profile($first="", $last="", $addr1= "",$addr2= "",$addr3= "",$city= "", $state="",$phone="",$country= "",$citystphone="",$zip="",
$changedEmail="",$changedPass="")
{
}

// First check if session was created and currently exists.
if(isset($_SESSION['ClassAdsEmail']))
{
	// Load session user and password information to select specific user
	$sessionEmail = $_SESSION['ClassAdsEmail'];
	$sessionPass= $_SESSION['ClassAdsPassword'];
	$logonName = $_SESSION['ClassAdsLogonName'];

	// Implement private header html code to produce page container
	// Followup with custom menu for the member view
	include $sec_html_files.'pageHeaderPrivate.html';
	include $html_files.'pageMemberMenu.html';
	
	// This MyProfile php script is used to update all contact information for the user that is logged in to this session.
	// Detail select query by email and password and display data on myprofile.html page with the intent to update profile.
	if (isset($_POST['myProfile']))
	{
		// Load values from myProfile form for updates to user table
		$first = $_POST['first'];
		$last = $_POST['last'];
		$addr1 = $_POST['addr1'];
		$addr2 = $_POST['addr2'];
		$addr3 = $_POST['addr3'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$phone = $_POST['phone'];
		$country = $_POST['country'];
		$citystphone = $_POST['citystphone'];
		$zip = $_POST['zip'];
		$logonName = $first." ".$last;

		// Check if user has changed email or password
		if ($sessionPass!= $_POST['pass'] or $sessionEmail != $_POST['email'])
		{
			if ($sessionPass!= $_POST['pass'])
			{
				$_POST['pass'] = stripslashes($_POST['pass']);
				$_POST['pass'] = md5($_POST['pass']);
			}
			$changedPass = $_POST['pass'];
			$changedEmail = $_POST['email'];
			mysqli_query($link,"update ".$tbl_name2." set vchEmail = '$changedEmail', vchFirstName = '$first', vchLastName = '$last',
					vchAddress1 = '$addr1', vchAddress2 = '$addr2', vchAddress3 = '$addr3',	vchCity = '$city', vchState = '$state', vchZip = '$zip',
					vchPhone = '$phone', vchPassword = '$changedPass', vchCountry = '$country', tiHide_email = $citystphone
					WHERE '$sessionEmail' = vchEmail and '$sessionPass' = vchPassword") or die('-MyProfile.php (Update User Table)-'.mysqli_error().'');

			// Update all existing ADs that belong to this email and user.
			mysqli_query($link,"update ".$tbl_name3." set vchUserEmail = '$changedEmail', vchUserPassword = '$changedPass'
					WHERE '$sessionEmail' = vchUserEmail and '$sessionPass' = vchUserPassword") or die('-MyProfile.php (update Ad table)-'.mysqli_error().'');

			// Delete and re-insert new email member key.
			mysqli_query($link, "delete from ".$tbl_name." WHERE '$sessionEmail' = vchEmail and '$sessionPass' = vchPassword") or die('-MyProfile.php (Delete Member Table)-'.mysqli_error().'');
			$today = DATE(c);
			mysqli_query($link, "INSERT INTO ".$tbl_name." (vchEmail, vchPassword, dtRegistered) VALUES ('$changedEmail', '$changedPass', '$today')") or die('-MyProfile.php (Insert Member Table)-'.mysqli_error().'');
			$_SESSION['ClassAdsPassword'] = $_POST['pass'];
			$_SESSION['ClassAdsEmail'] = $_POST['email'];
			$logonName = $first." ".$last;
			$_SESSION['ClassAdsName'] = $logonName;
		}
		else
		{
			mysqli_query($link,"update ".$tbl_name2." set vchEmail = '$sessionEmail', vchFirstName = '$first', vchLastName = '$last',
					vchAddress1 = '$addr1', vchAddress2 = '$addr2', vchAddress3 = '$addr3',	vchCity = '$city', vchState = '$state', vchZip = '$zip',
					vchPhone = '$phone', vchPassword = '$sessionPass', vchCountry = '$country', tiHide_email = $citystphone
					WHERE '$sessionEmail' = vchEmail and '$sessionPass' = vchPassword") or die('-MyProfile.php (Update User Table)-'.mysqli_error().'');
		}
		$MsgTitle = $regemailtitle;
		// $redirect = "Login.php";
		$MsgType = "Thank you, ".$logonName.";";
		$Msg1 = "Your personal information was updated successfully,";
		$Msg2= "To View your Ad, Post your Ad or Update your Profile click on the link below.";
		include $sec_html_files.'member.html';
		include $sec_html_files.'pageFooterPrivate.html';
		exit();
	}
	else
	{
		$MyProfile = mysqli_query($link, "SELECT * FROM ".$tbl_name2."
								WHERE '$sessionEmail' = vchEmail and '$sessionPass' = vchPassword") or die('-MyProfile.php (slelect)- '.mysqli_error().'');
		//Gives error if user doesn't exist
		$check3 = mysqli_affected_rows($link);
		if ($check3 == 0)
		{
			if(!mysqli_query($link,"insert into ".$tbl_name2." values
				(0,'$sessionEmail','$first','$last','$addr1','$addr2','$addr3','$city','$state','$phone','$sessionPass','',0,'$country',0,'$zip','','','','','','')")) 
			{
				if (mysqli_errno() == 1062)
				{
					echo mysqli_errno().": duplicate key error returned from MySQL";
				}
				else
				{
					echo mysqli_errno().": error returned from MySQL";
				}
			}
			$Msg1 = "If this is your first time in your Profile please update your personal information,";
		}
		else
		{
			while($Updates = mysqli_fetch_array( $MyProfile ))
			{
				// Loop and display each item detail for given session user
				$first      = $Updates['vchFirstName'];
				$last 		= $Updates['vchLastName'];
				$addr1 		= $Updates['vchAddress1'];
				$addr2 		= $Updates['vchAddress2'];
				$addr3 		= $Updates['vchAddress3'];
				$city 		= $Updates['vchCity'];
				$state 		= $Updates['vchState'];
				$phone 		= $Updates['vchPhone'];
				$country 	= $Updates['vchCountry'];
				$citystphone= $Updates['tiHide_email'];
				$zip        = $Updates['vchZip'];
			}
			$logonName = $first." ".$last;
			$_SESSION['ClassAdsName'] = $logonName;
			$msg1 = "To change information in your Profile please update any field below,";
		}
		$changedPass	= $sessionPass;
		$changedEmail 	= $sessionEmail;
		$MsgTitle = "MY PROFILE UPDATE";
		$MsgType = "Welcome back, ".$logonName.";";
		$msg2= "and click the Update Contact button below.";
		include $sec_html_files.'myprofile.html';
		include $sec_html_files.'pageFooterPrivate.html';
		show_profile($first,$last,$addr1,$addr2,$addr3,$city,$state,$phone,$country,$citystphone,$zip,$changedEmail,$changedPass);
	}
}
else
{
	//if the session does not exist, you are taken to the login screen
	//header("Location: Login.php");
	//echo ('Session does not exist: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
	$MsgTitle = "MY PROFILE UPDATE";
	$redirect = "Logout.php";
	$MsgType = "MyProfile.php Warning:";
	$Msg1 = "User sesssion expired";
	$Msg2= "Please re-establish credentials with Login.";
	$button = "Login";
	include $sec_html_files.'logonMsg.html';
	include $sec_html_files.'pageFooterPrivate.html';
	unset($_POST['submit']);
	exit();
}
?>