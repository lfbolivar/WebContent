<?php
//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

// Connects to your Database
//  Include the db connection script from non public_html location
include PRIVATE_DB."dbConfig.php";

$CatTable = mysqli_query($link, "SELECT CatId, CatDesc FROM ".$tbl_name5." order by 2") or die('-LoadCatArray.php- '.mysql_error().' LoadCatArray.php Error on Select of Category table.');
while($CatRow = mysqli_fetch_array( $CatTable ))
{
	// Loop and display each item detail for given category
	$options[$CatRow['CatId']] = $CatRow['CatDesc'];
}

// Load the Period values dynamically to the control box on mydetails.html and newAdForm2.html
$periodWk = array("7" => "1 week","14"=>"2 weeks","21"=>"3 weeks","28"=>"4 weeks");
$periodMo = array("30" => "1 month","30"=>"2 months","60"=>"3 months","90"=>"4 months");

// Load the Caption values dynamically to the control box on mydetails.html and newAdForm2.html
$caption = array("For Display"=>"For Display",
				"Informational"=>"Informational",
				"FOR SALE"=>"For Sale",
				"WANTED"=>"Wanted",
				"BEST OFFER FOR"=>"Best offer for",
				"POSITION DESIRED"=>"Position desired",
				"POSITION OFFERED"=>"Position offered",
				"FOR RENT"=>"For Rent",
				"FOR LEASE"=>"For Lease",
				"SERVICES OFFERED"=>"Services Offered",
				"BUSINESS OPPORTUNITY"=>"Business Opportunity",
				"BUY WHOLESALE"=>"Buy Wholesale");
?>