<?
//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to the Database
//  Include the db connection script from non public_html location.  Security feature.
include PRIVATE_DB."dbConfig.php";

// First check if session was created and currently exists.
if(!isset($_SESSION['ClassAdsEmail']))
{
	$modal = '<a href="#loginmodal" class="flatbtn" id="modaltrigger">Member</a>';
}else{
	$modal = '<a href="Member.php">Member</a>';
}

$CatBody = $_POST['catdesc'];
// include $html_files.'pageBody.html';

// This Category php script is used to display all open (un-expired) classifieds as a drill down from Browse Ad script without a login or registration.
// Detail select query by Category passed from the browseAd.html page.
if (isset($_POST['catid']))
{
	$category = $_POST['catdesc'];
	$catid = $_POST['catid'];
	$ViewAds = mysqli_query($link, "SELECT A.*, I.iFileID FROM ".$tbl_name3." as A
							left join ".$tbl_name4." as I on A.iAdId = I.iFileAdId 
							WHERE (dtAdExpireDate > now() 
								and iAdCatId = '$catid' 
								and tiAdValid <> 0)
								or A.iAdId = 0") 
								or die('-Category.php- '.mysqli_error().'');
	$CatImageArray = "";
	$CatImageIdArray = 0;
	$CatIdArray = "";
	$CatDescArray = "";
	$CatCountArray = 0;
	$CatAdArray = "";
	$CatURLArray = "";
	$CatCaptionArray = "";
	$CatHeadlineArray = "";
	while($Details = mysqli_fetch_array( $ViewAds ))
	{
		if (empty($CatImageArray)){
			$CatImageArray = array($Details['iAdId']);
			$CatImageIdArray = array($Details['iFileID']);
			$CatIdArray = array($Details['iAdCatId']);
			$CatDescArray = array($DispInfo['CatDesc']);
			// $CatCountArray = array($DispInfo['count(*)']);
			$CatAdArray = array($Details['iAdId']);
			$CatURLArray = array($Details['vcAdURL']);
			$CatCaptionArray = array($Details['vchAdCaption']);
			$CatHeadlineArray = array($Details['vchAdHeadLine']);
		}
		else {
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
		}
	}
	// Include Cascading Style Sheet definition
	include $html_files.'pageHeader.html';
	
	$htmlDetail = $html_files.'category.html';
	include $php_files.'PubGallery.php';
	include $html_files.'pageFooter.html';
	exit();
}
else
{
	include $php_files.'BrowseAd.php';
	//echo ($_POST['cat'].'Form is not set');
	exit();
}
?>