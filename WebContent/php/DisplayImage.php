<?php
//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

// Connects to your Database
//  Include the db connection script from non public_html location
include PRIVATE_DB."dbConfig.php";


$image = stripslashes($_REQUEST['imageName']);
$rs = mysqli_query($link, "select vchFileType, bFileContent from ".$tbl_name4." where iFileID = '$image'");
$row = mysqli_fetch_assoc($rs);
$imageContent = $row['bFileContent'];
$imageType = $row['vchFileType'];
header("Content-type: $imageType");
print $imageContent;
?>
