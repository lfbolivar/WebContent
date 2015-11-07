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
	$CatBody = "Category";
	//include $sec_html_files.'pageHeaderPrivate.html';
	//	include $html_files.'pageBody.html';
	// The above line was commented out as it is now generated from the Gallery.php or MyGallery.php scripts.
	// Load session user and password information to select specific ADs

	// load the session variables.
	$sessionEmail = $_SESSION['ClassAdsEmail'];
	$sessionPass= $_SESSION['ClassAdsPassword'];
	$logonName = $_SESSION['ClassAdsLogonName'];
	
	// Implement public header html code to produce page container
	// Followup with logonMsg and allow user to submit credentials
	include $sec_html_files.'pageHeaderPrivate.html';
	
	// This View My Ad php script is a members only page to view classifieds of the registered and logged in user.
	// Aggregate select query groups by Category=tbl_name5 and counts all ads from the ADs=tlb_name3.
	$AllCats = mysqli_query($link, "SELECT c.*,a.vchUserEmail,count(*) FROM ".$tbl_name5." c
								left join ".$tbl_name3." a on c.CatId = a.iAdCatId and '$sessionEmail' = a.vchUserEmail and '$sessionPass' = a.vchUserPassword
								group by 1,2,3,4 order by 2") or die('-ViewMyAd.php- '.mysqli_error().'');

	// load category table fetched for login user into array and pass to MyGallery variable $Cat*Array.
	$CatImageArray = "";
	$CatIdArray = "";
	$CatDescArray = "";
	$CatCountArray = 0;
	$CatAdArray = "";
	while($LoadCats = mysqli_fetch_array( $AllCats ))
	{
		// Loop and load each category to Category Array
		//	echo ($DispInfo['vchAdCategory']);
		if (empty($CatImageArray)){
			$CatImageArray = array($LoadCats['CatImage']);
			$CatIdArray = array($LoadCats['CatId']);
			$CatDescArray = array($LoadCats['CatDesc']);
			$CatCountArray = array($LoadCats['count(*)']);
			$CatAdArray = array($LoadCats['vchUserEmail']);
		}
		else{
			array_push($CatImageArray, $LoadCats['CatImage']);
			array_push($CatIdArray, $LoadCats['CatId']);
			array_push($CatDescArray, $LoadCats['CatDesc']);
			array_push($CatCountArray, $LoadCats['count(*)']);
			//$CatCountArray[] = $LoadCats['count(*)'];
			// echo 'vma-$count='.$LoadCats['count(*)'];
			array_push($CatAdArray, $LoadCats['vchUserEmail']);
			//$CatAdArray[] = $LoadCats['vchUserEmail'];
			// echo 'vma-$email='.$LoadCats['vchUserEmail'];
		}
	}
	// Call MyGallery display functions.
	$htmlDetail = $html_files.'viewAd.html';
	include $sec_php_files.'MyGallery.php';
	$year = date(o);
	include $sec_html_files.'pageFooterPrivate.html';
	exit();
}
else
{
	// Implement public header html code to produce page container
	// Followup with logonMsg and allow user to submit credentials
	include $sec_html_files.'pageHeader.html';
	include $html_files.'pageHeaderMenu.html';
	
	//if the session does not exist, you are taken to the login screen
	//header("Location: Login.php");
	//echo ('Session does not exist: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
	$MsgTitle = "VIEW MY AD";
	$redirect = "Logon.php";
	$MsgType = "Member.php Warning:";
	$Msg1 = "User name and password sesssion lost";
	$Msg2= "Please re-establish credentials with Login.";
	$button = "Logon";
	include $sec_html_files.'logonMsg.html';
	include $sec_html_files.'pageFooter.html';
	unset($_POST['submit']);
	exit();
}
?>