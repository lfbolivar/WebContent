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
if(!isset($_SESSION['ClassAdsEmail']))
{
	$modal = '<a href="#loginmodal" class="flatbtn" id="modaltrigger">Member</a>';
}else{
	$modal = '<a href="Member.php">Member</a>';
}
// Include Cascading Style Sheet definition
include $html_files.'pageHeader.html';

$CatBody = "Category";


// This Browse Ad php script is open to the public to view classifieds without a login or registration.
// Aggregate select query groups by Category (5) and sums Open un-expired ADs (3).

$OpenAds = mysqli_query($link, "SELECT CatId, CatDesc, CatImage, min(IAdCatId),count(*) FROM ".$tbl_name5."
			left outer join ".$tbl_name3." on CatId = iAdCatId group by 1,2,3 order by 2")
			// and dtAdExpireDate > now() and tiAdValid <> 0 group by 1,2,3 order by 2") 
             or die('-BrowseAd.php- '.mysqli_error().'');
// Loop and display each category
//	echo ($DispInfo['vchAdCategory']);
//	$Cat = $DispInfo['CatDesc'];
//	$CatId = $DispInfo['CatId'];
//	$Image = $url_images.$DispInfo['CatImage'];
//	$CatCount = $DispInfo['count(*)'];
//	include $html_files.'browseAd.html';
// load category table fetched for login user into array and pass to MyGallery variable $Cat*Array.
$CatImageArray = "";
$CatIdArray = "";
$CatDescArray = "";
$CatCountArray = 0;
$CatAdArray = "";
while($DispInfo = mysqli_fetch_array( $OpenAds ))
{
	// Loop and load each category to Category Array
	//	echo ($DispInfo['vchAdCategory']);
	if (empty($CatImageArray)){
		$CatImageArray = array($DispInfo['CatImage']);
		$CatIdArray = array($DispInfo['CatId']);
		$CatDescArray = array($DispInfo['CatDesc']);
		$CatCountArray = array($DispInfo['count(*)']);
		$CatAdArray = array($DispInfo['min(IAdCatId)']);
	}
	else{
		array_push($CatImageArray, $DispInfo['CatImage']);
		array_push($CatIdArray, $DispInfo['CatId']);
		array_push($CatDescArray, $DispInfo['CatDesc']);
		array_push($CatCountArray, $DispInfo['count(*)']);
		//$CatCountArray[] = $DispInfo['count(*)'];
		// echo 'vma-$count='.$DispInfo['count(*)'];
		array_push($CatAdArray, $DispInfo['min(IAdCatId)']);
		//$CatAdArray[] = $DispInfo['vchUserEmail'];
		// echo 'vma-$email='.$DispInfo['vchUserEmail'];
	}
}
// Call MyGallery display functions.
$htmlDetail = $html_files.'browseAd.html';
include $php_files.'PubGallery.php';
include $html_files.'pageFooter.html';
exit();
?>