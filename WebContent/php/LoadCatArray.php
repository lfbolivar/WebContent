<?php
//  Local config allows for dynamic definition of file paths and single point for private paths
require_once "class/Config.php";
$objConfig = Config::getInstance();
$PRIVATE_DB = $objConfig->get('PRIVATE_DB');

//	This is a new db class that loads the category table
require_once $this->priv_class_files.'db_category.php';

$obj_category = new db_category($data);
$options = $obj_category->read();
//print_r($options);

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