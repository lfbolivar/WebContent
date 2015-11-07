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

// Include Cascading Style Sheet definition
include $html_files.'pageHeader.html';

// Load the category for the body with public content description.
$CatBody = $pub_content_desc.' #'.$_POST['Ad'];
//include $html_files.'pageBody.html';

// This Category php script is used to display all open (un-expired) classifieds as a drill down from Browse Ad script without a login or registration.
// Detail select query by Category passed from the browseAd.html page.
if (isset($_POST['Ad']))
{
	$ad = $_POST['Ad'];
	if (empty($_POST['AdNbr'])){
		$FileId = 0;
	}else{
		$FileId = $_POST['AdNbr'];
	}
	$ViewAds = mysqli_query($link, "SELECT A.*, I.*, C.*, U.* FROM ".$tbl_name3." A
							left join ".$tbl_name4." I on A.iAdId = I.iFileAdId
							and $FileId = I.iFileId
							left join ".$tbl_name5." C on A.iAdCatId = C.CatId 
							left join ".$tbl_name2." U on A.vchUserEmail = U.vchEmail
							WHERE dtAdExpireDate > now() and $ad = A.iAdId")
	or die('-AdDetail.php- '.mysqli_error($link).'');
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
		// Loop and display each item detail for given category
		// $Id      = $Details['iAdId'];
		// $URL     = $Details['vcAdURL'];
		// $Caption = $Details['vchAdCaption'];
		// $Headline = $Details['vchAdHeadLine'];
		// $imageId  = $Details['iFileID'];
		if (empty($CatImageArray)){
			$CatImageArray = array($Details['iAdId']);
			$CatImageIdArray = array($Details['iFileID']);
			$CatIdArray = array($Details['iAdCatId']);
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
			// Loop and display each item detail for given category
			array_push($CatImageArray, $Details['iAdId']);
			array_push($CatImageIdArray, $Details['iFileID']);
			array_push($CatIdArray, $Details['iAdCatId']);
			array_push($CatDescArray, $Details['CatDesc']);
			array_push($CatAdArray, $Details['iAdId']);
			array_push($CatURLArray, $Details['vchAdURL']);
			array_push($CatCaptionArray, $Details['vchAdCaption']);
			array_push($CatHeadlineArray, $Details['vchAdHeadLine']);
			array_push($CatAdDescArray, $Details['vchAdDesc']);
			array_push($CatAdDateArray, $Details['dtAdDate']);
			array_push($CatAdExDateArray, $Details['dtAdExpireDate']);
			array_push($CatAdModDateArray, $Details['tsAdModifyDate']);
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
	}
	$htmlDetail = $html_files.'browsedetails.html';
	include $php_files.'PubGallery.php';
	$year = date(o);
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