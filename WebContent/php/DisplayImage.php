<?php
//  Local config allows for dynamic definition of file paths and single point for private paths
require "setConfig.php";
require_once $priv_class_files.'db_gallery.php';
require_once 'class/image.php';

// Connects to your Database
//  Include the db connection script from non public_html location
require_once PRIVATE_DB."dbConfig.php";

$image = array();
$which_image = Null;
$imageContent = Null;

if (isset($_REQUEST['imageName'])){
	$image['iFileId'] = stripslashes($_REQUEST['imageName']);
	$which_image = 'Reg';
	
} else if (isset($_REQUEST['thmbImg'])){
	$image['iFileId'] = stripslashes($_REQUEST['thmbImg']);
	$which_image = 'Thmb';
}
$obj_db_gallery = new db_gallery($data);
$row = $obj_db_gallery->display_gallery_image($image);

if ($which_image == 'Reg' | (empty($row['bThumbnail']) && $which_image == 'Thmb')){
	$imageContent = $row['bFileContent'];
} else {
	$imageContent = $row['bThumbnail'];
}
$imageType = $row['vchFileType'];
header("Content-type: $imageType");
print $imageContent;
?>
