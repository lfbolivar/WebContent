<?php
/*
 * Author: LF Bolivar
 * Created: 10/24/2016
 *
 * Class db_workbench
 * 
 * Methods:
 * __construct($data)
 * read_ad_by_category()
 * read_ad_images()
 * read_ad_detail()
 * read_max_ad()
 * delete_ad_image($ad)
 * 
 */
//  Local config allows for dynamic definition of file paths and single point for private paths
require 'dbConfig_params.php';

class db_workbench {


	private $_dbHost	= NULL;
	private $_dbUser	= NULL;
	private $_dbPass	= NULL;
	private $_dbName	= NULL;
	private $_dbPort    = NULL;
	
	private $_tbUser	= NULL;
	private $_tbImage	= NULL;
	private $_tbAd		= NULL;
	private $_tbCategory= NULL;
	private $_ad		= NULL;
	private $_FileId	= NULL;
	
	private $_sessionEmail 	= NULL;
	private $_sessionPass  	= NULL;
	private $_catid		   	= NULL;
	private $_adid          = NULL;

	private $AdArray 			= NULL;
	private $AdDateArray 		= NULL;
	private $AdDescArray 		= NULL;
	private $Addr1Array 		= NULL;
	private $Addr2Array 		= NULL;
	private $Addr3Array 		= NULL;
	private $AdExDateArray 		= NULL;
	private $AdModDateArray		= NULL;
	private $AdValidArray 		= NULL;
	private $CaptionArray 		= NULL;
	private $CityArray 			= NULL;
	private $CountryArray 		= NULL;
	private $DescArray 			= NULL;
	private $EmailArray 		= NULL;
	private $HeadlineArray 		= NULL;
	private $HideArray 			= NULL;
	private $IdArray 			= NULL;
	private $ImageIdArray		= NULL;
	private $ImageArray 		= NULL;
	private $PeriodArray		= NULL;
	private $PhoneArray			= NULL;
	private $StateArray 		= NULL;
	private $URLArray 			= NULL;
	private $UserFirstNameArray = NULL;
	private $UserLastNameArray 	= NULL;
	private $ZipArray 			= NULL;
	private $MaxAdArray			= NULL;


	function __construct($data) {

		$this->_dbHost		=$data['host'];
		$this->_dbUser		=$data['user'];
		$this->_dbPass		=$data['pass'];
		$this->_dbName		=$data['name'];
		$this->_dbPort      =$data['port'];
		
		$this->_dbMember    =$data['table1'];		
		$this->_tbUser		=$data['table2'];
		$this->_tbAd		=$data['table3'];
		$this->_tbImage		=$data['table4'];
		$this->_tbCategory	=$data['table5'];
		$this->_ad			=$data['ad'];
		$this->_FileId		=$data['FileId'];
		
		$this->_sessionEmail = $data['sessionEmail'];
		$this->_sessionPass  = $data['sessionPass'];
		$this->_catid		 = $data['catid'];
		$this->_adid		 = $data['adid'];

		// Connects to the Database provided
		$this->mysqli = new mysqli($this->_dbHost,$this->_dbUser,$this->_dbPass,$this->_dbName,$this->_dbPort) or
		die('db_workbench '.$this->_dbName.' Connection error: '.mysqli_connect_error().' ');
		$this->mysqli->select_db($this->_dbName) or
		die('db_workbench '.$this->_dbName.' mysqli_select_db error: '.mysqli_error($this->mysqli).' ');

		// Internal UTF-8
		$this->mysqli->query ( "SET NAMES 'utf8'" );
		$this->mysqli->query ( 'SET character_set_connection=utf8' );
		$this->mysqli->query ( 'SET character_set_client=utf8' );
		$this->mysqli->query ( 'SET character_set_results=utf8' );

	}
	/*
	 * Function/Method to read categories for a member's content by email key passed by __construct()
	 */
	function read_ad_by_category(){
	
		// This Browse php script is open to the public to view app content without a login or registration.
		// Aggregate select query groups by Category (table5) and sums Open un-expired Ad (table3).
		// and dtAdExpireDate > now() and tiAdValid <> 0 group by 1,2,3 order by 2")
		$check = $this->mysqli->query("SELECT c.*
				                            , a.vchUserEmail
 				                            , count(*) 
				                       FROM ".$this->_tbCategory." c
								       inner join ".$this->_tbAd." a 
				                       on  c.CatId = a.iAdCatId 
				                       and '$this->_sessionEmail' = a.vchUserEmail 
				                       and '$this->_sessionPass' = a.vchUserPassword
								       group by 1,2,3,4
				                       order by 2")
					or die("mysql error on select of workbench category : ".mysqli_error($this->mysqli));
	
					// Gives error if user doesn't exist
					//$qry_param = mysqli_affected_rows($this->link);
					if ($check->num_rows == 0){
						return 0;
					} else {
						$result = array();
	
						while($info = $check->fetch_array()){
							// Loop and load each category to Category Array
							//	echo ($info['vchAdCategory'])
							if (empty($ImageArray)){
								//$result['CatImageArray'] = $info['CatImage'];
								$ImageArray = array($info['CatImage']);
								$IdArray    = array($info['CatId']);
								$DescArray  = array($info['CatDesc']);
								$CountArray = array($info['count(*)']);
								$AdArray    = array($info['vchUserEmail']);
							}
							else{
								array_push($ImageArray, $info['CatImage']);
								array_push($IdArray, $info['CatId']);
								array_push($DescArray, $info['CatDesc']);
								array_push($CountArray, $info['count(*)']);
								array_push($AdArray, $info['vchUserEmail']);
							}
	
						}
						$result['ImageArray'] = $ImageArray;
						$result['IdArray']    = $IdArray;
						$result['DescArray']  = $DescArray;
						$result['CountArray'] = $CountArray;
						$result['AdArray']    = $AdArray;
						
						return $result;
					}
					//return $qry_param;
	}
	/*
	 * Function/Method to read user row by email key passed by __construct()
	 */
	function read_ad_images(){
	
		// This category method script is open to the public to view content by category without a login or registration.
		// Aggregate select query groups by Ad (table3) and displays images from image (table4) using a join
		// and checking ExpireDate > then today.
		// and dtAdExpireDate > now() and tiAdValid <> 0 group by 1,2,3 order by 2")
		$check = $this->mysqli->query("SELECT A.iAdId
				                            , A.vchAdCaption
				                            , A.vchAdHeadLine
				                            , A.tiAdValid
                                            , A.dtAdExpireDate
				                            , I.iFileID
				                            , I.vchFileName
		                               FROM ".$this->_tbAd." A 
		                               left join ".$this->_tbImage." I 
				                       on A.iAdId = I.iFileAdId
								       WHERE 
				                           '$this->_sessionEmail' = A.vchUserEmail 
				                       and '$this->_sessionPass' = A.vchUserPassword 
				                       and A.iAdCatId = '$this->_catid'")
				or die("mysql error on select of ad and image join from workbench: ".mysqli_error($this->mysqli));
	
				// print_r("catid: ".$this->_catid);
				if ($check->num_rows == 0){
					return 0;
				} else {
					$result = array();
	
					while($info = $check->fetch_array()){
						// Loop and load each category to Category Array
						//	echo ($info['vchAdCategory'])
						if (empty($ImageArray)){
							$ImageArray 	= array($info['iAdId']);
							$ImageIdArray 	= array($info['iFileID']);
							$IdArray 		= array($info['iAdCatId']);
							$DescArray 		= array($info['vchAdDesc']);
							$AdArray 		= array($info['iAdId']);
							$URLArray 		= array($info['vcAdURL']);
							$CaptionArray 	= array($info['vchAdCaption']);
							$HeadlineArray 	= array($info['vchAdHeadLine']);
							$AdValidArray 	= array($info['tiAdValid']);
							$AdExDateArray 	= array($info['dtAdExpireDate']);
						}
						else{
							// Loop and display each item detail for given category
							array_push($ImageArray, 	$info['iAdId']);
							array_push($ImageIdArray, 	$info['iFileID']);
							array_push($IdArray, 		$info['iAdCatId']);
							array_push($DescArray, 		$info['vchAdDesc']);
							array_push($AdArray, 		$info['iAdId']);
							array_push($URLArray, 		$info['vcAdURL']);
							array_push($CaptionArray, 	$info['vchAdCaption']);
							array_push($HeadlineArray, 	$info['vchAdHeadLine']);
							array_push($AdValidArray, 	$info['tiAdValid']);
							array_push($AdExDateArray,	$info['dtAdExpireDate']);
						}
					}
					// print_r($ImageIdArray);
					$result['ImageArray']	= $ImageArray;
					$result['ImageIdArray']	= $ImageIdArray;
					$result['IdArray']		= $IdArray;
					$result['DescArray']	= $DescArray;
					$result['AdArray']		= $AdArray;
	
					$result['URLArray']		= $URLArray;
					$result['CaptionArray']	= $CaptionArray;
					$result['HeadlineArray']= $HeadlineArray;
					$result['AdValidArray']	= $AdValidArray;
					$result['AdExDateArray']= $AdExDateArray;
					
					return $result;
				}
				//return $qry_param;
	}
	
	
	/*
	 * Function/Method to read user row by email key passed by __construct()
	 */
	function read_ad_detail(){

		// This category method script is open to the public to view content by category without a login or registration.
		// Aggregate select query groups by Ad(table3) and displays images from image(table4) using a join
		// and checking ExpireDate > then today.
		// and dtAdExpireDate > now() and tiAdValid <> 0 group by 1,2,3 order by 2")
		$check = $this->mysqli->query("SELECT A.*
				                            , I.*
				                            , C.*
				                            , U.* 
				                       FROM ".$this->_tbAd." A
								       left join ".$this->_tbImage." I 
				                         on A.iAdId = I.iFileAdId
								         and $this->_FileId = I.iFileId
								       left join ".$this->_tbCategory." C 
				                         on A.iAdCatId = C.CatId 
								       left join ".$this->_tbUser." U 
				                         on A.vchUserEmail = U.vchEmail
								       WHERE $this->_adid = A.iAdId 
				                       and '$this->_sessionEmail' = A.vchUserEmail 
				                       and '$this->_sessionPass' = A.vchUserPassword")
				or die("mysql error on db_workbench.php->read_ad_detail(): ".mysqli_error($this->mysqli));
				 
				if ($check->num_rows == 0){
					return 0;
				} else {
					$result = array();

					while($info = $check->fetch_array()){

						// Loop and display each item detail for given category
						if (empty($ImageArray)){
							$ImageArray 		= array($info['iAdId']);
							$ImageIdArray		= array($info['iFileID']);
							$IdArray 			= array($info['iAdCatId']);
							$PeriodArray 		= array($info['iAdPeriod']);
							$DescArray 			= array($info['CatDesc']);
							$AdArray 			= array($info['iAdId']);
							$URLArray 			= array($info['vchAdURL']);
							$CaptionArray 		= array($info['vchAdCaption']);
							$HeadlineArray 		= array($info['vchAdHeadLine']);
							$AdDescArray 		= array($info['vchAdDesc']);
							$AdDateArray 		= array($info['dtAdDate']);
							$AdExDateArray 		= array($info['dtAdExpireDate']);
							$AdModDateArray		= array($info['tsAdModifyDate']);
							$AdValidArray 		= array($info['tiAdValid']);
							$UserFirstNameArray = array($info['vchFirstName']);
							$UserLastNameArray 	= array($info['vchLastName']);
							$EmailArray 		= array($info['vchUserEmail']);
							$Addr1Array 		= array($info['vchAddress1']);
							$Addr2Array 		= array($info['vchAddress2']);
							$Addr3Array 		= array($info['vchAddress3']);
							$CityArray 			= array($info['vchCity']);
							$StateArray 		= array($info['vchState']);
							$PhoneArray			= array($info['vchPhone']);
							$CountryArray 		= array($info['vchCountry']);
							$HideArray 			= array($info['tiHide_mail']);
							$ZipArray 			= array($info['vchZip']);

						}
						else
						{
							// Loop and display each item detail for given category
							array_push($ImageArray, 	$info['iAdId']);
							array_push($ImageIdArray, 	$info['iFileID']);
							array_push($IdArray, 		$info['iAdCatId']);
							array_push($PeriodArray, 	$info['iAdPeriod']);
							array_push($DescArray, 		$info['CatDesc']);
							array_push($AdArray, 		$info['iAdId']);
							array_push($URLArray, 		$info['vchAdURL']);
							array_push($CaptionArray, 	$info['vchAdCaption']);
							array_push($HeadlineArray, 	$info['vchAdHeadLine']);
							array_push($AdDescArray, 	$info['vchAdDesc']);
							array_push($AdDateArray, 	$info['dtAdDate']);
							array_push($AdExDateArray,	$info['dtAdExpireDate']);
							array_push($AdModDateArray, $info['tsAdModifyDate']);
							array_push($AdValidArray, 	$info['tiAdValid']);
							array_push($UserFirstNameArray, $info['vchFirstName']);
							array_push($UserLastNameArray, $info['vchLasttName']);
							array_push($EmailArray, 	$info['vchUserEmail']);
							array_push($Addr1Array, 	$info['vchAddress1']);
							array_push($Addr2Array, 	$info['vchAddress2']);
							array_push($Addr3Array, 	$info['vchAddress3']);
							array_push($CityArray, 		$info['vchCity']);
							array_push($StateArray, 	$info['vchState']);
							array_push($PhoneArray, 	$info['vchPhone']);
							array_push($CountryArray, 	$info['vchCountry']);
							array_push($HideArray, 		$info['tiHide_mail']);
							array_push($ZipArray, 		$info['vchZip']);
						}

					}
					// print_r($ImageIdArray);
					$result['ImageArray']			= $ImageArray;
					$result['ImageIdArray']			= $ImageIdArray;
					$result['IdArray']				= $IdArray;
					$result['PeriodArray']			= $PeriodArray;
					$result['DescArray']			= $DescArray;
					$result['AdArray']				= $AdArray;

					$result['URLArray']				= $URLArray;
					$result['CaptionArray']			= $CaptionArray;
					$result['HeadlineArray']		= $HeadlineArray;
						
					$result['AdDateArray']			= $AdDateArray;
					$result['AdExDateArray']		= $AdExDateArray;
					$result['AdModDateArray']		= $AdModDateArray;
					$result['AdDescArray']			= $AdDescArray;
					$result['AdValidArray']			= $AdValidArray;
					$result['UserFirstNameArray']	= $UserFirstNameArray;
					$result['UserLastNameArray']	= $UserLastNameArray;
					$result['EmailArray']			= $EmailArray;
					$result['Addr1Array']			= $Addr1Array;
					$result['Addr2Array']			= $Addr2Array;
					$result['Addr3Array']			= $Addr3Array;
					$result['CityArray']			= $CityArray;
					$result['StateArray']			= $StateArray;
					$result['PhoneArray']			= $PhoneArray;
					$result['CountryArray']			= $CountryArray;
					$result['HideArray']			= $HideArray;
					$result['ZipArray']				= $ZipArray;

					return $result;
				}
				//return $qry_param;
	}
	/*
	 * Function/Method to read max ad by user email and pass key via __construct()
	 * $query = "SELECT max(iAdId) 'Ad' FROM ".$tbl_name3." 
	 * WHERE vchUserEmail = '$sessionEmail' and vchUserPassword = '$sessionPass'";
	 */
	function read_max_ad(){
	
		$check = $this->mysqli->query("SELECT max(A.iAdId)
				                            , A.vchAdUserName

		                               FROM ".$this->_tbAd." A
									   WHERE
											'$this->_sessionEmail'	= A.vchUserEmail
										and '$this->_sessionPass' 	= A.vchUserPassword")
				or die("mysql error on select of max(ad) from workbench: ".mysqli_error($this->mysqli));
	
				// print_r("catid: ".$this->_catid);
				if ($check->num_rows == 0){
					return 0;
				} else {
					$result = array();
					while($info = $check->fetch_array()){
						$result['iAdId'] 			= $info['iAdId'];
						$result['vchAdUserName'] 	= $info['vchAdUserName'];
					}
					return $result;
				}
		}
		/*
			Function call from MyAdDelete to delete specific Ad Image.
			mysqli_query($link, "delete from ".$tbl_name4."
					WHERE $adid = iFileAdId
					and $imageid = iFileID")
					or die('-MyAdDelete.php (Delete of '.$tbl_name4.' Table failed)- '.mysqli_error().'');
		 */
		function delete_ad_image($ad){
			$adid = $ad['AdId'];
			$fileid = $ad['imageid'];
			// print_r($ad);			
			$check = $this->mysqli->query("delete from ".$this->_tbImage." WHERE $adid = iFileAdId and  $fileid = iFileID");
			// or die("-MyAdDelete.php - image delete failed for $adid and $fileid)- ".mysqli_error($this->mysqli));
			
			// print_r("catid: ".$this->_catid);
			if ($this->mysqli->affected_rows>0){
				return	$this->mysqli->affected_rows;
			} else {
				return 0;
			}
		}
		
}
?>