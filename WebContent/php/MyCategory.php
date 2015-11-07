<?
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
	$CatBody = $_POST['mycatdesc'];
	include $sec_html_files.'pageHeaderPrivate.html';
	// include $html_files.'pageBody.html';

	// Load session user and password information to select specific ADs
	$sessionEmail = $_SESSION['ClassAdsEmail'];
	$sessionPass= $_SESSION['ClassAdsPassword'];

	// This Category php script is used to display all open classifieds as a drill down from View My Ad script registered logged in members.
	// Detail select query by Category passed from the browseAd.html page.
	if (isset($_POST['mycatid']))
	{
		//	inner join ".$tbl_name4." I on A.iAdId = I.iFileAdId
		$catid = $_POST['mycatid'];
		$category = $_POST['mycatdesc'];
		$ViewAds = mysqli_query($link, "SELECT A.iAdId, A.vchAdCaption, A.vchAdHeadLine, tiAdValid, I.iFileID, I.vchFileName
		            FROM ".$tbl_name3." A 
		            left join ".$tbl_name4." I on A.iAdId = I.iFileAdId
								WHERE '$sessionEmail' = A.vchUserEmail and '$sessionPass' = A.vchUserPassword and A.iAdCatId = '$catid'
								") or die('-MyCategory.php- '.mysqli_error($link).'');
		$CatImageArray = "";
		$CatImageIdArray = 0;
		$CatIdArray = "";
		$CatDescArray = "";
		$CatCountArray = 0;
		$CatAdArray = "";
		$CatURLArray = "";
		$CatCaptionArray = "";
		$CatHeadlineArray = "";
		$CatStatusArray = 0;
		while($Details = mysqli_fetch_array( $ViewAds ))
		{
			// Loop and display each item detail for given category
			//$Id      = $Details['iAdId'];
			//$Caption = $Details['vchAdCaption'];
			//$Headline = $Details['vchAdHeadLine'];
			//$AdStatus = $Details['tiAdValid'];
			//$imageId = $Details['iFileID'];
			//$imageName = $Details['vchFileName'];
			if (empty($CatImageArray))
			{
				$CatImageArray = array($Details['iAdId']);
				$CatImageIdArray = array($Details['iFileID']);
				$CatIdArray = array($Details['iAdCatId']);
				$CatDescArray = array($Details['CatDesc']);
				$CatAdArray = array($Details['iAdId']);
				$CatURLArray = array($Details['vcAdURL']);
				$CatCaptionArray = array($Details['vchAdCaption']);
				$CatHeadlineArray = array($Details['vchAdHeadLine']);
				$CatStatusArray = array($Details['tiAdValid']);
			}
			else
			{
	  	// Loop and display each item detail for given category
				array_push($CatImageArray, $Details['iAdId']);
				array_push($CatImageIdArray, $Details['iFileID']);
				array_push($CatIdArray, $Details['iAdCatId']);
				array_push($CatDescArray, $DispInfo['CatDesc']);
				// array_push($CatCountArray, $DispInfo['count(*)']);
				array_push($CatAdArray, $Details['iAdId']);
				//$CatAdArray[] = $DispInfo['vchUserEmail'];
				// echo 'vma-$email='.$DispInfo['vchUserEmail'];
				array_push($CatURLArray, $Details['vcAdURL']);
				array_push($CatCaptionArray, $Details['vchAdCaption']);
				array_push($CatHeadlineArray, $Details['vchAdHeadLine']);
				array_push($CatStatusArray, $Details['tiAdValid']);
			}
		}
		$year = date(o);
		$htmlDetail = $sec_html_files.'mycategory.html';
		include $sec_php_files.'MyGallery.php';
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
	$MsgTitle = "MY CATEGORY";
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