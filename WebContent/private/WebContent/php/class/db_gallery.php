<?php
/*
 * Author: LF Bolivar
 * Created: 10/16/2016
 *
 * Class db_gallery
 * 
 * Methods:
 * __construct($data)
 * join_category_ad()
 * join_ad_image()
 * join_details()
 * display_gallery_image($img)
 * 
 */
//  Local config allows for dynamic definition of file paths and single point for private paths
require 'dbConfig_params.php';

class db_gallery {


	private $_dbHost	= NULL;
	private $_dbUser	= NULL;
	private $_dbPass	= NULL;
	private $_dbName	= NULL;
	private $_dbPort    = NULL;
	
	private $_tbMember  = NULL;
	private $_tbUser	= NULL;
	private $_tbImage	= NULL;
	private $_tbAd		= NULL;
	private $_tbCategory= NULL;
	
	private $_catid		= Null;
	private $_ad		= Null;
	private $_FileId	= Null;
	
/* First pass or first layer at Category-to-Ad level */
	private $ImageArray 		= array();
	private $IdArray 			= array();
	private $DescArray 			= array();
	private $CountArray 		= array();
	private $AdArray 			= array();

/*  Second pass or drill-down layer 2 at Ad-Image level */
	private $ImageIdArray		= array();
	private $URLArray 			= array();
	private $CaptionArray 		= array();
	private $HeadlineArray 		= array();
	
	private $AdDateArray 		= array();
	private $AdExDateArray 		= array();
	private $AdModDateArray		= array();
	private $AdDescArray 		= array();
	private $AdValidArray 		= array();
	private $UserFirstNameArray = array();
	private $UserLastNameArray 	= array();
	private $EmailArray 		= array();
	private $Addr1Array 		= array();
	private $Addr2Array 		= array();
	private $Addr3Array 		= array();
	private $CityArray 			= array();
	private $StateArray 		= array();
	private $PhoneArray			= array();
	private $CountryArray 		= array();
	private $HideArray 			= array();
	private $ZipArray 			= array();
	

	function __construct($data) {

		$this->_dbHost		=$data['host'];
		$this->_dbUser		=$data['user'];
		$this->_dbPass		=$data['pass'];
		$this->_dbName		=$data['name'];
		$this->_dbPort      =$data['port'];
		
		$this->_tbMember	=$data['table1'];
		$this->_tbUser		=$data['table2'];
		$this->_tbAd		=$data['table3'];
		$this->_tbImage		=$data['table4'];
		$this->_tbCategory	=$data['table5'];
		
		if (isset($data['catid'])){
		  $this->_catid		=$data['catid'];
		}
		if (isset($data['ad'])){
		  $this->_ad			=$data['ad'];
		}
		if (isset($data['FileId'])){
		  $this->_FileId		=$data['FileId'];
		}
		
		// Connects to the Database provided
		$this->mysqli = new mysqli($this->_dbHost,$this->_dbUser,$this->_dbPass,$this->_dbName,$this->_dbPort) or
		die('db_category_ad_join '.$this->_dbName.' Connection error: '.mysqli_connect_error().' ');
		$this->mysqli->select_db($this->_dbName) or
		die('db_category_ad_join '.$this->_dbName.' mysqli_select_db error: '.mysqli_error($this->mysqli));

		// Internal UTF-8
		$this->mysqli->query ( "SET NAMES 'utf8'" );
		$this->mysqli->query ( 'SET character_set_connection=utf8' );
		$this->mysqli->query ( 'SET character_set_client=utf8' );
		$this->mysqli->query ( 'SET character_set_results=utf8' );

	}
	/*
	 * Function/Method to read to read Categories(s) and associated Image(s) by default (all categories).
	 */
	function join_category_ad(){
	
		// This Browse php script is open to the public to view app content without a login or registration.
		// Aggregate select query groups by Category (table5) and sums Open un-expired Ad (table3).
		// and dtAdExpireDate > now() and tiAdValid <> 0 group by 1,2,3 order by 2")
		$check = $this->mysqli->query("SELECT CatId
				                            , CatDesc
				                            , CatImage
				                            , min(IAdCatId)
				                            ,count(*) 
				                       FROM ".$this->_tbCategory."
			                           left outer join ".$this->_tbAd." 
				                       on  CatId = iAdCatId
				                       and date(dtAdExpireDate) > curdate()
				                       and tiAdValid <> 0 
				                       group by 1,2,3 
				                       order by 2")
					or die("mysql error from class=db_gallery() method=join_category_ad(): ".mysqli_error($this->mysqli));
	
					// Gives error if user doesn't exist
					//$qry_param = mysqli_affected_rows($this->link);
					if ($check->num_rows == 0){
						return 0;
					} else {
						$result = array();
	
						while($info = $check->fetch_array()){
							// Loop and load each category to Category Array
							//	echo ($info['vchAdCategory'])
							if (empty($this->ImageArray)){
								//$result['CatImageArray'] = $info['CatImage'];
								$this->ImageArray = array($info['CatImage']);
								$this->IdArray    = array($info['CatId']);
								$this->DescArray  = array($info['CatDesc']);
								$this->CountArray = array($info['count(*)']);
								$this->AdArray    = array($info['min(IAdCatId)']);
							}
							else{
								array_push($this->ImageArray, $info['CatImage']);
								array_push($this->IdArray, $info['CatId']);
								array_push($this->DescArray, $info['CatDesc']);
								array_push($this->CountArray, $info['count(*)']);
								array_push($this->AdArray, $info['min(IAdCatId)']);
							}
	
							//$result['logonName'] = $info['vchFirstName']." ".$info['vchLastName'];
							//$result['logonPass'] = $info['vchPassword'];
							//$result['logonEmail']= $info['vchEmail'];
						}
						$result['ImageArray'] = $this->ImageArray;
						$result['IdArray']    = $this->IdArray;
						$result['DescArray']  = $this->DescArray;
						$result['CountArray'] = $this->CountArray;
						$result['AdArray']    = $this->AdArray;
	
						return $result;
					}
					//return $qry_param;
	}
	
	/*
	 * Function/Method to read Ad(s) and Image(s) by selecting from Categories. Key(s) passed by __construct()
	 */
	function join_ad_image(){
	
		// This category method script is open to the public to view content by category without a login or registration.
		// Aggregate select query groups by Ad (table3) and displays images from image (table4) using a join
		// and checking ExpireDate > then today.
		// and dtAdExpireDate > now() and tiAdValid <> 0 group by 1,2,3 order by 2")
		$check = $this->mysqli->query("SELECT A.*
				                            , I.iFileID 
				                       FROM ".$this->_tbAd." as A
							           left join ".$this->_tbImage." as I 
				                       on A.iAdId = I.iFileAdId
				                       WHERE (date(dtAdExpireDate) > curdate()
				                       and iAdCatId = '$this->_catid'
				                       and tiAdValid <> 0)
				                       or A.iAdId = 0")
				or die("mysql error from class=db_gallery() method=join_ad_image(): ".mysqli_error($this->mysqli));
	
				// print_r("catid: ".$this->_catid);
				if ($check->num_rows == 0){
					return 0;
				} else {
					$result = array();
	
					while($info = $check->fetch_array()){
						// Loop and load each category to Category Array
						//	echo ($info['vchAdCategory'])
						if (empty($this->ImageArray)){
							$this->ImageArray    = array($info['iAdId']);
							$this->IdArray       = array($info['iAdCatId']);
							$this->DescArray     = array($info['vchAdDesc']);
							// $this->CountArray = array($info['count(*)']);
							$this->AdArray       = array($info['iAdId']);
							// Second pass
							$this->ImageIdArray  = array($info['iFileID']);
							$this->URLArray      = array($info['vcAdURL']);
							$this->CaptionArray  = array($info['vchAdCaption']);
							$this->HeadlineArray = array($info['vchAdHeadLine']);
							$this->AdExDateArray = array($info['dtAdExpireDate']);
						}
						else{
							// Loop and display each item detail for given category
							array_push($this->ImageArray,      $info['iAdId']);
							array_push($this->IdArray,         $info['iAdCatId']);
							array_push($this->DescArray,       $info['vchAdDesc']);
							// array_push($this->CountArray,   $info['count(*)']);
							array_push($this->AdArray,         $info['iAdId']);
							//$AdArray[] = $info['vchUserEmail'];
							// echo 'vma-$email='.$info['vchUserEmail'];
							array_push($this->ImageIdArray,    $info['iFileID']);
							array_push($this->URLArray,        $info['vcAdURL']);
							array_push($this->CaptionArray,    $info['vchAdCaption']);
							array_push($this->HeadlineArray,   $info['vchAdHeadLine']);
							array_push($this->AdExDateArray,   $info['dtAdExpireDate']);
						}
					}
					// print_r($ImageIdArray);
					$result['ImageArray']	= $this->ImageArray;
					$result['IdArray']		= $this->IdArray;
					$result['DescArray']	= $this->DescArray;
					//$result['CountArray']	= $this->CountArray;
					$result['AdArray']		= $this->AdArray;
					//Second pass
					$result['ImageIdArray']	= $this->ImageIdArray;
					$result['URLArray']		= $this->URLArray;
					$result['CaptionArray']	= $this->CaptionArray;
					$result['HeadlineArray']= $this->HeadlineArray;
					$result['AdExDateArray']= $this->AdExDateArray;
					
					return $result;
				}
				//return $qry_param;
	}
	/*
	 * Function/Method to read user row by email key passed by __construct()
	 */
	function join_details(){

		// This category method script is open to the public to view content by category without a login or registration.
		// Aggregate select query groups by Ad(table3) and displays images from image(table4) using a join 
        // and checking ExpireDate > then today.
		// and dtAdExpireDate > now() and tiAdValid <> 0 group by 1,2,3 order by 2")
		$check = $this->mysqli->query("SELECT A.*
				                            , I.*
				                            , C.*
				                            , U.* 
								       FROM ".$this->_tbAd." as A
							            left join (".$this->_tbImage." as I,".$this->_tbCategory." as C,".$this->_tbUser." as U)
		                                  on (I.iFileAdId=A.iAdId and C.CatId=A.iAdCatId and U.vchEmail=A.vchUserEmail)
			    		                WHERE A.iAdId = $this->_ad and I.iFileID = $this->_FileId and date(A.dtAdExpireDate) > curdate()")
		                          or die("mysql error from class=db_gallery() method=join_details(): ".mysqli_error($this->mysqli));
		
			    if ($check->num_rows == 0){
			    	return 0;
			    } else {
			    	$result = array();
			    	
			    	while($info = $check->fetch_array()){

			    		// Loop and display each item detail for given category
			    		if (empty($this->ImageArray)){
			    		    $this->ImageArray 		= array($info['iAdId']);
			    		    $this->IdArray 			= array($info['iAdCatId']);
			    		    $this->DescArray 		= array($info['CatDesc']);
			    		    $this->AdArray 			= array($info['iAdId']);

			    			//Second Pass - Drill-down level-2
			    		    $this->ImageIdArray		= array($info['iFileID']);
			    		    $this->URLArray 		= array($info['vchAdURL']);
			    		    $this->CaptionArray 	= array($info['vchAdCaption']);
			    		    $this->HeadlineArray 	= array($info['vchAdHeadLine']);

			    			// Third pass - Drill-down level-3
			    		    $this->AdDateArray 		= array($info['dtAdDate']);
			    		    $this->AdExDateArray 	= array($info['dtAdExpireDate']);
			    		    $this->AdModDateArray	= array($info['tsAdModifyDate']);
			    		    $this->AdDescArray 		= array($info['vchAdDesc']);
			    		    $this->AdValidArray 	= array($info['tiAdValid']);
			    		    $this->UserFirstNameArray = array($info['vchFirstName']);
			    		    $this->UserLastNameArray = array($info['vchLastName']);
			    		    $this->EmailArray 		= array($info['vchUserEmail']);
			    		    $this->Addr1Array 		= array($info['vchAddress1']);
			    		    $this->Addr2Array 		= array($info['vchAddress2']);
			    		    $this->Addr3Array 		= array($info['vchAddress3']);
			    		    $this->CityArray 		= array($info['vchCity']);
			    		    $this->StateArray 		= array($info['vchState']);
			    		    $this->PhoneArray		= array($info['vchPhone']);
			    		    $this->CountryArray 	= array($info['vchCountry']);
			    		    $this->HideArray 		= array($info['tiHide_mail']);
			    		    $this->ZipArray 		= array($info['vchZip']);
			    			
			    		}
			    		else
			    		{
			    			// Loop and display each item detail for given category
			    		    array_push($this->ImageArray,	$info['iAdId']);
			    		    array_push($this->IdArray,		$info['iAdCatId']);
			    		    array_push($this->DescArray,	$info['CatDesc']);
			    		    array_push($this->AdArray,		$info['iAdId']);

			    		    //Second Pass - Drill-down level-2
			    		    array_push($this->ImageIdArray, $info['iFileID']);
			    		    array_push($this->URLArray,		$info['vchAdURL']);
			    		    array_push($this->CaptionArray,	$info['vchAdCaption']);
			    		    array_push($this->HeadlineArray,$info['vchAdHeadLine']);
			    		    
			    		    // Third pass - Drill-down level-3
			    		    array_push($this->AdDateArray,	$info['dtAdDate']);
			    		    array_push($this->AdExDateArray,$info['dtAdExpireDate']);
			    		    array_push($this->AdModDateArray,$info['tsAdModifyDate']);
			    		    array_push($this->AdDescArray,	$info['vchAdDesc']);
			    		    array_push($this->AdValidArray,	$info['tiAdValid']);
			    		    array_push($this->UserFirstNameArray,$info['vchFirstName']);
			    		    array_push($this->UserLastNameArray,$info['vchLasttName']);
			    		    array_push($this->EmailArray,	$info['vchUserEmail']);
			    		    array_push($this->Addr1Array,	$info['vchAddress1']);
			    		    array_push($this->Addr2Array,	$info['vchAddress2']);
			    		    array_push($this->Addr3Array,	$info['vchAddress3']);
			    		    array_push($this->CityArray,	$info['vchCity']);
			    		    array_push($this->StateArray,	$info['vchState']);
			    		    array_push($this->PhoneArray,	$info['vchPhone']);
			    		    array_push($this->CountryArray, $info['vchCountry']);
			    		    array_push($this->HideArray,	$info['tiHide_mail']);
			    		    array_push($this->ZipArray,		$info['vchZip']);
			    		}
			    		 
			    	}
			    	// print_r($ImageIdArray);
			    	$result['ImageArray']			= $this->ImageArray;
			    	$result['IdArray']				= $this->IdArray;
			    	$result['DescArray']			= $this->DescArray;
			    	$result['AdArray']				= $this->AdArray;
			    	
			    	//Second Pass - Drill-down level-2
			    	$result['ImageIdArray']			= $this->ImageIdArray;
			    	$result['URLArray']				= $this->URLArray;
			    	$result['CaptionArray']			= $this->CaptionArray;
			    	$result['HeadlineArray']		= $this->HeadlineArray;

			    	// Third pass - Drill-down level-3
			    	$result['AdDateArray']			= $this->AdDateArray;
			    	$result['AdExDateArray']		= $this->AdExDateArray;
			    	$result['AdModDateArray']		= $this->AdModDateArray;
			    	$result['AdDescArray']			= $this->AdDescArray;
			    	$result['AdValidArray']			= $this->AdValidArray;
			    	$result['UserFirstNameArray']	= $this->UserFirstNameArray;
			    	$result['UserLastNameArray']	= $this->UserLastNameArray;
			    	$result['EmailArray']			= $this->EmailArray;
			    	$result['Addr1Array']			= $this->Addr1Array;
			    	$result['Addr2Array']			= $this->Addr2Array;
			    	$result['Addr3Array']			= $this->Addr3Array;
			    	$result['CityArray']			= $this->CityArray;
			    	$result['StateArray']			= $this->StateArray;
			    	$result['PhoneArray']			= $this->PhoneArray;
			    	$result['CountryArray']			= $this->CountryArray;
			    	$result['HideArray']			= $this->HideArray;
			    	$result['ZipArray']				= $this->ZipArray;
			    	
			    	return $result;
			    }
			    //return $qry_param;
	}
	/*
	 * Function/Method to display image thumbnail or maxsize_image
	 * $rs = mysqli_query($link, "select vchFileType, bFileContent, bThumbnail from ".$tbl_name4." where iFileID = '$image'");
	 * $row = mysqli_fetch_assoc($rs);
	 *
	 */
	function display_gallery_image($img){
	
		$image 			= $img['iFileId'];
		$check = $this->mysqli->query("SELECT * 
	
		                            FROM ".$this->_tbImage." 
									WHERE iFileID = '$image'")
				or die("mysql error from class=db_gallery() method=display_gallery_image(): ".mysqli_error($this->mysqli));
	
				// print_r("catid: ".$this->_catid);
				if ($check->num_rows == 0){
					return 0;
				} else {
					$result = array();
					while($info = $check->fetch_array()){
						$result['bFileContent'] = $info['bFileContent'];
						$result['bThumbnail'] 	= $info['bThumbnail'];					
						$result['vchFileType'] 	= $info['vchFileType'];
						$result['fileName'] 	= $info['vchFileName'];
						$result['tmpName']  	= $info['bFileContent'];   // Load to this name in case there is no thumbnail?
						$result['fileSize'] 	= $info['iFileSize'];
						$result['fileType'] 	= $info['vchFileType'];				
					}
					return $result;
				}
	}
	
}
