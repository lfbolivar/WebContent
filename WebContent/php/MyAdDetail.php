<?php
//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

//  If they are not logged in they are redirected to the login page.
// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to the Database
//  Include the db connection script from non public_html location.  Security feature.
include PRIVATE_DB."dbConfig.php";

// First check if session was created and currently exists.
if(isset($_SESSION['ClassAdsEmail']))
{
	// Include Cascading Style Sheet definition
	//  Loading the $CatBody before include of pageHeaderPrivate.html allows the display of specific level in the left pane.
	$CatBody = $priv_content_desc."# ".$_POST['myAd'];
	include $sec_html_files.'pageHeaderPrivate.html';
	// include $html_files.'pageBody.html';

	// Load session user and password information to select specific ADs
	$sessionEmail = $_SESSION['ClassAdsEmail'];
	$sessionPass= $_SESSION['ClassAdsPassword'];

	// This Category php script is used to display all open classifieds as a drill down from View My Ad script registered logged in members.
	// Detail select query by Category passed from the browseAd.html page.
	if (isset($_POST['myAd']))
	{
		$AdId = $_POST['myAd'];
		if (empty($_POST['myImage'])){
			$FileId = 0;
		}else{
			$FileId = $_POST['myImage'];
		}
		$ViewAds = mysqli_query($link, "SELECT A.*, I.*, C.*, U.* FROM ".$tbl_name3." A
								left join ".$tbl_name4." I on A.iAdId = I.iFileAdId
								and $FileId = I.iFileId
								left join ".$tbl_name5." C on A.iAdCatId = C.CatId 
								left join ".$tbl_name2." U on A.vchUserEmail = U.vchEmail
								WHERE $AdId = A.iAdId and '$sessionEmail' = A.vchUserEmail and '$sessionPass' = A.vchUserPassword") 
		or die('-MyAdDetail.php- '.mysqli_error().'');
		// initialize variables
		$CatImageArray = "";
		$CatImageIdArray = 0;
		$CatIdArray = "";
		$CatDescArray = "";
		$CatCountArray = 0;
		$CatAdArray = "";
		$CatURLArray = "";
		$CatCaptionArray = "";
		$CatHeadlineArray = "";
		$CatPeriodArray = 1;
		// Loop and display each item detail for given category
		while($Details = mysqli_fetch_array( $ViewAds ))
		{
			//When array is empty load first value
			if (empty($CatImageArray))
			{
				$CatImageArray = array($Details['iAdId']);
				$CatImageIdArray = array($Details['iFileID']);
				$CatIdArray = array($Details['iAdCatId']);
				$CatPeriodArray = array($Details['iAdPeriod']);
				$CatDescArray = array($Details['CatDesc']);
				$CatAdArray = array($Details['iAdId']);
				$CatURLArray = array($Details['vchAdURL']);
				$CatCaptionArray = array($Details['vchAdCaption']);
				$CatHeadlineArray = array($Details['vchAdHeadLine']);
				$CatAdDateArray = array($Details['dtAdDate']);
				$CatAdExDateArray = array($Details['dtAdExpireDate']);
				$CatAdModDateArray = array($Details['tsAdModifyDate']);
				$CatAdDescArray = array($Details['vchAdDesc']);
				$CatAdValidArray = array($Details['tiAdValid']);
				$CatUserFirstNameArray = array($Details['vchFirstName']);
				$CatUserLastNameArray = array($Details['vchLastName']);
				$CatEmailArray = array($Details['vchUserEmail']);
				$CatAddr1Array = array($Details['vchAddress1']);
				$CatAddr2Array = array($Details['vchAddress2']);
				$CatAddr3Array = array($Details['vchAddress3']);
				$CatCityArray = array($Details['vchCity']);
				$CatStateArray = array($Details['vchState']);
				$CatPhoneArray = array($Details['vchPhone']);
				$CatCountryArray = array($Details['vchCountry']);
				$CatHideArray = array($Details['tiHide_email']);
				$CatZipArray = array($Details['vchZip']);
			}
			else
			{
				// Append the remaining items from various tables
				array_push($CatImageArray, $Details['iAdId']);
				array_push($CatImageIdArray, $Details['iFileID']);
				array_push($CatIdArray, $Details['iAdCatId']);
				array_push($CatPeriodArray, $Details['iAdPeriod']);
				array_push($CatDescArray, $Details['CatDesc']);
				array_push($CatAdArray, $Details['iAdId']);
				array_push($CatURLArray, $Details['vchAdURL']);
				array_push($CatCaptionArray, $Details['vchAdCaption']);
				array_push($CatHeadlineArray, $Details['vchAdHeadLine']);
				array_push($CatAdDateArray, $Details['chAdDate']);
				array_push($CatAdExDateArray, $Details['dtAdExpireDate']);
				array_push($CatAdModDateArray, $Details['tsAdDateStamp']);
				array_push($CatAdDescArray, $Details['vchAdDesc']);
				array_push($CatAdValidArray, $Details['tiAdValid']);
				array_push($CatUserFirstNameArray, $Details['vchFirstName']);
				array_push($CatUserLastNameArray, $Details['vchLasttName']);
				array_push($CatEmailArray, $Details['vchUserEmail']);
				array_push($CatAddr1Array, $Details['vchAddress1']);
				array_push($CatAddr2Array, $Details['vchAddress2']);
				array_push($CatAddr3Array, $Details['vchAddress3']);
				array_push($CatCityArray, $Details['vchCity']);
				array_push($CatStateArray, $Details['vchState']);
				array_push($CatPhoneArray, $Details['vchPhone']);
				array_push($CatCountryArray, $Details['vchCountry']);
				array_push($CatHideArray, $Details['tiHide_email']);
				array_push($CatZipArray, $Details['vchZip']);
			}
			$year = date(o);
			$htmlDetail = $sec_html_files.'mydetails.html';
			include $sec_php_files.'MyGallery.php';
		}
		include $sec_html_files.'pageFooterPrivate.html';
		exit();
	}
	else
	{
		include $sec_php_files.'ViewMyAd.php';
		//echo ($_POST['cat'].'Form is not set');
		exit();
	}
}
else
{
	//if the session does not exist, you are taken to the login screen
	//header("Location: Login.php");
	//echo ('Session does not exist: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
	$MsgTitle = "MY Ad Details";
	$redirect = "Logout.php";
	$MsgType = "MyAdDetail.php Warning:";
	$Msg1 = "User name and password sesssion lost";
	$Msg2= "Please re-establish credentials with Login.";
	$button = "Logon";
	include $sec_html_files.'logonMsg.html';
	unset($_POST['submit']);
	exit();
}
?>