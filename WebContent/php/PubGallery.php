<?php
//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

// Connects to the Database
//  Include the db connection script from non public_html location.  Security feature.
include PRIVATE_DB."dbConfig.php";

global $images_files;

// decide what page of a paticular gallery we're viewing
$pg = !empty($_REQUEST['pg']) && ctype_digit($_REQUEST['pg']) ? $_REQUEST['pg'] : 1;
// echo '$pg='.$pg;

// images per page reflect php arrays start at position zero [0]
$section = ROWS * COLS;
// echo ' ROWS*COLS=$section='.$section;

// last possible ending point for images, depending which page we're on
$end = $section * $pg;
// echo ' $section*$pg=$end='.$end;

// starting point for images, depending which page we're on
$start = $end - $section;
// echo ' $end-$section=$start='.$start;

// previous page
$prev = $pg - 1;
// echo ' $pg-1=$prev='.$prev;

// next page
$next = $pg + 1;
// echo ' $pg+1=$next='.$next;

// draw previous and next links for images
function navigate_images($total) {
	global $section, $Image, $prev, $next, $end, $pg, $html_files
	      , $CatBody, $css_files, $sec_url_php, $modal, $url_home
		  , $pub_header_title, $pub_welcome_message, $pub_welcome_message2;
	$query = !empty($Image) ? '?file='.rawurlencode($Image).'&pg=' : '?pg=';
	$pages = $total <= $section ? 1 : ceil($total / $section);
	$p = '<li><a href="'.SELF.$query.$prev.'">Prev</a></li>';
	$n = '<li><a href="'.SELF.$query.$next.'">Next</a></li>';
	$c = '<li><p>Page '.$pg.' of '.$pages.'</p></li>';
	
	//echo('<div class="navigate_images">'."\r\n");
	//echo('<div class="left">'."\r\n".'<ul>'."\r\n");
	if(($pg == 1 && $end >= $total)){
		echo($c."\r\n");
	}elseif($pg == 1){
		//echo($n.' '.$c);
		echo ($n."\r\n");
		echo ($c."\r\n");
	}elseif($end < $total){
		echo($p."\r\n");
		echo($n."\r\n");
		echo($c."\r\n");
		// echo($p.' '.$n.' '.$c);
	}else{
		//echo($p.' '.$c);
		echo($p."\r\n");
		echo($c."\r\n");
	}
	//    print($c);
	// echo('</div>');
	// compensate for 1px style image borders, i feel dirty
	// $mainwidth = COLS * THMBWIDTH;
	//print('<div id="main" style="width: '.$mainwidth.'px;">'."\r\n");
	include $html_files.'pageBody.html';
	//print('<div class="content">'."\r\n");
	//echo('<h2>Browse '.$CatBody.'</h2>'."\r\n");
}

// display thumbnails
function display_thumbnails($CatImageArray)
{
	global $CatIdArray, $CatImageIdArray, $CatDescArray, $CatCountArray, $CatAdArray, $CatURLArray,$CatCaptionArray, $CatHeadlineArray
	,$CatAdDateArray, $CatAdDescArray, $CatStatusArray, $CatPeriodArray, $CatAdExDateArray, $CatAdModDateArray
	,$CatUserFirstNameArray, $CatUserLastNameArray, $CatEmailArray, $CatAdValidArray
	,$CatAddr1Array, $CatAddr2Array, $CatAddr3Array
	,$CatCityArray, $CatStateArray, $CatCountryArray, $CatPhoneArray, $CatHideArray, $CatZipArray
	,$sessionEmail, $start, $end, $Image, $ImageId
	,$url_images, $url_php, $url_css, $sec_url_php, $modal, $url_home
	,$images_files, $html_files, $htmlDetail;

	$total = count($CatImageArray);
	// echo '$total='.$total;

	$end = $total < $end ? $total : $end;

	// get rid of redundant table rows
	$math = count(array_slice($CatImageArray, $start)) / COLS;
	$rows = is_int($math) ? $math : ceil($math);

	navigate_images($total);
	print('<table cellpadding="0" cellspacing="0">'."\r\n");
	for($i = 0; $i < $rows; $i++) {
		print('<tr>');
		for($n = 0; $n < COLS; $n++) {
			$index = $start++;
			$image = $index < $end ? $CatImageArray[$index] : '&nbsp;';
			if($image != '&nbsp;') {
				print('<td style="width:'.(THMBWIDTH + 20).'px; height:'.(THMBHEIGHT + 20).'px;">'."\r\n");
				// Load array values from Category table.  The calling scrips are BrowseAd.php, Category.php, ViewDetails.php
				//					echo '$start='.$start;
				//					echo '$index='.$index;
				//					echo ' $end='.$end;
				$Cat = $CatDescArray[$index];
				$CatId = $CatIdArray[$index];
				// The below variable $Image will contain a valid path for the category image
				// It will not contain a good path for Ad images in database
				$Image = $url_images.$image;
				$ImageId  = $CatImageIdArray[$index];
				// echo '$ImageId='.$ImageId;
				// echo 'mg-$CatCount='.$CatCount;
				$AdEmail = $CatEmailArray[$index];
				// echo 'mg-$AdEmail='.$AdEmail;
					
				// This will check and correct the count for a single add
				$CatCount = $CatCountArray[$index];
				$Id     = $CatAdArray[$index];
				if (($Id == Null) && $CatCount == 1)
				{
					$CatCount = 0;
				}
					
				$URL     = $CatURLArray[$index];
				$Caption = $CatCaptionArray[$index];
				$Headline = $CatHeadlineArray[$index];
				$AdStatus = $CatStatusArray[$index];
				$AdDesc = $CatAdDescArray[$index];
				$AdDate = $CatAdDateArray[$index];
				$AdExDate = $CatAdExDateArray[$index];
				$AdModDate = $CatAdModDateArray[$index];
				$first = $CatUserFirstNameArray[$index];
				$last = $CatUserLastNameArray[$index];
					
				// Check is content is active in public gallery
				$AdValid = $CatAdValidArray[$index];
				if ($AdValid == 0){
					$AdActive = "Hidden";
				} else {
					$AdActive = "Visible";
				}
				// This checks if user wants private personal information
				$Hide  = $CatHideArray[$index];
				// echo ($Hide ? 'Yes' : 'No');
				if ($Hide == 0){
					$Addr1 = "Private";
					$Addr2 = "Phone: Private";
					$Addr3 = "";
					$City = "";
					$State = "";
					$Zip = "";
					$Country = "";
					$Phone = "";
				} else {
					$Addr1 = $CatAddr1Array[$index];
					$Addr2 = $CatAddr2Array[$index];
					$Addr3 = $CatAddr3Array[$index];
					$City = $CatCityArray[$index];
					$State = $CatStateArray[$index];
					$Zip = $CatZipArray[$index];
					$Country = $CatCountryArray[$index];
					$Phone = $CatPhoneArray[$index];
				}
					
				if (!file_exists($images_files.$image))
				{
					$imageName = "No Image Found";
				}else{
					$imageName = $image;
				}
				//echo $image;
				include $php_files.'LoadCatArray.php';
				include $htmlDetail;
				print('</td>'."\r\n");
			}
			else
			{
				//print('</td>');
			}
		}
		print('</tr>'."\r\n");
	}
	print('</table>'."\r\n");
}

// display the gallery
function display_gallery($CatBody) {
	global $CatImageArray, $html_files, $CatBody, $url_css, $sec_url_php, $modal, $url_home
		  ,$pub_header_title, $pub_welcome_message, $pub_welcome_message2;
		$title = !empty($CatBody) ? TITLE.' - '.basename($CatBody) : TITLE;
	//  This is the old section that needs fixing
		//print('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">'."\r\n");
		//print('<html>'."\r\n".'<head>'."\r\n");
		//print('<title>'.$title.'</title>'."\r\n");
		//echo('<link href='.$url_css.'styles2.css rel="stylesheet" type="text/css" />'."\r\n");
		//print('</head>'."\r\n".'<body>'."\r\n");
	// end of old section
	print('<title>'.$title.'</title>'."\r\n");
	//echo('<link rel="stylesheet" type="text/css" href='.$url_css.'styles2.css />'."\r\n");
	//echo('<link rel="stylesheet" type="text/css" href='.$url_css.'style1.css />'."\r\n");
	print('</head>'."\r\n".'<body>'."\r\n");
	//print('<div class="container">'."\r\n".'<div class="header">'."\r\n");
	//print('<h1 class="header">'.$title.'</h1></div>'."\r\n");
	include $html_files.'pageHeaderMenu.html';
		
	if(!empty($CatImageArray)){
		display_thumbnails($CatImageArray);
		//print('<!-- Closed div class=content -->'."\r\n".'</div>'."\r\n");
	}
	else {
		// we might have a full size image here
		// but imgsrc.php is currently handling those
		//$CatImageArray = array("0");
		//display_thumbnails($CatImageArray);				
		//include $php_files.'LoadCatArray.php';
		//include $html_files.'pageBody.html';
		print('</ul>'."\r\n");
		print('<div class="content2">');
		echo('<h2>Browse '.$CatBody.'</h2>'."\r\n");
		print('<h3 class="content2">Nothing to display here! </h3>'."\r\n");
		//print('<!-- Closed div class=content2 -->'."\r\n".'</div>'."\r\n");
	}
	//print('</div>'."\r\n");
	//print('</body>'."\r\n".'</html>');
}
display_gallery($CatBody);
?>