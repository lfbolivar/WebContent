<?php
/*
 * Author: LF Bolivar
 * Created: 10/16/2016
 *
 * Class db_ad_image_join
 */
//  Local config allows for dynamic definition of file paths and single point for private paths
require 'dbConfig_params.php';

class db_gallery {


	private $_dbHost	= NULL;
	private $_dbUser	= NULL;
	private $_dbPass	= NULL;
	private $_dbName	= NULL;
	private $_tbUser	= NULL;
	private $_tbImage	= NULL;
	private $_tbAd		= NULL;
	private $_tbCategory= NULL;
	
	private $_catid		= NULL;
	private $_ad		= NULL;
	private $_FileId	= NULL;
	
	private $ImageArray 		= NULL;
	private $ImageIdArray		= NULL;
	private $IdArray 			= NULL;
	private $DescArray 			= NULL;
	private $AdArray 			= NULL;
	private $URLArray 			= NULL;
	private $CaptionArray 		= NULL;
	private $HeadlineArray 		= NULL;
	private $AdDateArray 		= NULL;
	private $AdExDateArray 		= NULL;
	private $AdModDateArray		= NULL;
	private $AdDescArray 		= NULL;
	private $AdValidArray 		= NULL;
	private $UserFirstNameArray = NULL;
	private $UserLastNameArray 	= NULL;
	private $EmailArray 		= NULL;
	private $Addr1Array 		= NULL;
	private $Addr2Array 		= NULL;
	private $Addr3Array 		= NULL;
	private $CityArray 			= NULL;
	private $StateArray 		= NULL;
	private $PhoneArray			= NULL;
	private $CountryArray 		= NULL;
	private $HideArray 			= NULL;
	private $ZipArray 			= NULL;
	

	function __construct($data) {

		$this->_dbHost		=$data['host'];
		$this->_dbUser		=$data['user'];
		$this->_dbPass		=$data['pass'];
		$this->_dbName		=$data['name'];
		$this->_tbUser		=$data['table'];
		$this->_tbAd		=$data['table3'];
		$this->_tbImage		=$data['table4'];
		$this->_tbCategory	=$data['table5'];
		
		$this->_catid		=$data['catid'];
		$this->_ad			=$data['ad'];
		$this->_FileId		=$data['FileId'];
		
		// Connects to the Database provided
		$this->mysqli = new mysqli($this->_dbHost,$this->_dbUser,$this->_dbPass,$this->_dbName) or
		die('db_category_ad_join '.$this->_dbName.' Connection error: '.mysqli_connect_error().' ');
		$this->mysqli->select_db($this->_dbName) or
		die('db_category_ad_join '.$this->_dbName.' mysqli_select_db error: '.mysqli_error($this->mysqli).' ');

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
				                       and dtAdExpireDate > now() 
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
						$ImageArray = "";
						$IdArray = "";
						$DescArray = "";
						$CountArray = 0;
						$AdArray = "";
	
						while($info = $check->fetch_array()){
							// Loop and load each category to Category Array
							//	echo ($info['vchAdCategory'])
							if (empty($ImageArray)){
								//$result['CatImageArray'] = $info['CatImage'];
								$ImageArray = array($info['CatImage']);
								$IdArray    = array($info['CatId']);
								$DescArray  = array($info['CatDesc']);
								$CountArray = array($info['count(*)']);
								$AdArray    = array($info['min(IAdCatId)']);
							}
							else{
								array_push($ImageArray, $info['CatImage']);
								array_push($IdArray, $info['CatId']);
								array_push($DescArray, $info['CatDesc']);
								array_push($CountArray, $info['count(*)']);
								array_push($AdArray, $info['min(IAdCatId)']);
							}
	
							//$result['logonName'] = $info['vchFirstName']." ".$info['vchLastName'];
							//$result['logonPass'] = $info['vchPassword'];
							//$result['logonEmail']= $info['vchEmail'];
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
				                       WHERE (dtAdExpireDate > now()
				                       and iAdCatId = '$this->_catid'
				                       and tiAdValid <> 0)
				                       or A.iAdId = 0")
				or die("mysql error from class=db_gallery() method=join_ad_image(): ".mysqli_error($this->mysqli));
	
				// print_r("catid: ".$this->_catid);
				if ($check->num_rows == 0){
					return 0;
				} else {
					$result = array();
					$ImageArray = "";
					$ImageIdArray = 0;
					$IdArray = "";
					$DescArray = "";
					$CountArray = 0;
					$AdArray = "";
					$URLArray = "";
					$CaptionArray = "";
					$HeadlineArray = "";
	
					while($info = $check->fetch_array()){
						// Loop and load each category to Category Array
						//	echo ($info['vchAdCategory'])
						if (empty($ImageArray)){
							$ImageArray = array($info['iAdId']);
							$ImageIdArray = array($info['iFileID']);
							$IdArray = array($info['iAdCatId']);
							$DescArray = array($info['vchAdDesc']);
							// $CountArray = array($info['count(*)']);
							$AdArray = array($info['iAdId']);
							$URLArray = array($info['vcAdURL']);
							$CaptionArray = array($info['vchAdCaption']);
							$HeadlineArray = array($info['vchAdHeadLine']);
						}
						else{
							// Loop and display each item detail for given category
							array_push($ImageArray, $info['iAdId']);
							array_push($ImageIdArray, $info['iFileID']);
							array_push($IdArray, $info['iAdCatId']);
							array_push($DescArray, $info['vchAdDesc']);
							// array_push($CountArray, $info['count(*)']);
							array_push($AdArray, $info['iAdId']);
							//$AdArray[] = $info['vchUserEmail'];
							// echo 'vma-$email='.$info['vchUserEmail'];
							array_push($URLArray, $info['vcAdURL']);
							array_push($CaptionArray, $info['vchAdCaption']);
							array_push($HeadlineArray, $info['vchAdHeadLine']);
						}
					}
					// print_r($ImageIdArray);
					$result['ImageArray']	= $ImageArray;
					$result['ImageIdArray']	= $ImageIdArray;
					$result['IdArray']		= $IdArray;
					$result['DescArray']	= $DescArray;
					//$result['CountArray']	= $CountArray;
					$result['AdArray']		= $AdArray;
	
					$result['URLArray']		= $URLArray;
					$result['CaptionArray']	= $CaptionArray;
					$result['HeadlineArray']= $HeadlineArray;
	
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
		$check = $this->mysqli->query("SELECT A.*, I.*, C.*, U.* FROM ".$this->_tbAd." A
							left join ".$this->_tbImage." I on A.iAdId = I.iFileAdId
			    		and $this->_FileId = I.iFileId
			    		left join ".$this->_tbCategory." C on A.iAdCatId = C.CatId
							left join ".$this->_tbUser." U on A.vchUserEmail = U.vchEmail
			    		WHERE dtAdExpireDate > now() and $this->_ad = A.iAdId")
			    or die("mysql error on db_gallery.php : ".mysqli_error($this->mysqli));
			    
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
			    			$DescArray 			= array($info['CatDesc']);
			    			$AdArray 			= array($info['iAdId']);
			    			$URLArray 			= array($info['vchAdURL']);
			    			$CaptionArray 		= array($info['vchAdCaption']);
			    			$HeadlineArray 		= array($info['vchAdHeadLine']);
			    			$AdDateArray 		= array($info['dtAdDate']);
			    			$AdExDateArray 		= array($info['dtAdExpireDate']);
			    			$AdModDateArray		= array($info['tsAdModifyDate']);
			    			$AdDescArray 		= array($info['vchAdDesc']);
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
			    			$HideArray 			= array($info['tiHide_email']);
			    			$ZipArray 			= array($info['vchZip']);
			    			
			    		}
			    		else
			    		{
			    			// Loop and display each item detail for given category
			    			array_push($ImageArray,			$info['iAdId']);
			    			array_push($ImageIdArray, 		$info['iFileID']);
			    			array_push($IdArray,			$info['iAdCatId']);
			    			array_push($DescArray,			$info['CatDesc']);
			    			array_push($AdArray,			$info['iAdId']);
			    			array_push($URLArray,			$info['vchAdURL']);
			    			array_push($CaptionArray,		$info['vchAdCaption']);
			    			array_push($HeadlineArray,		$info['vchAdHeadLine']);
			    			array_push($AdDescArray,		$info['vchAdDesc']);
			    			array_push($AdDateArray,		$info['dtAdDate']);
			    			array_push($AdExDateArray,		$info['dtAdExpireDate']);
			    			array_push($AdModDateArray,		$info['tsAdModifyDate']);
			    			array_push($AdDescArray,		$info['vchAdDesc']);
			    			array_push($AdValidArray,		$info['tiAdValid']);
			    			array_push($UserFirstNameArray,	$info['vchFirstName']);
			    			array_push($UserLastNameArray,	$info['vchLasttName']);
			    			array_push($EmailArray,			$info['vchUserEmail']);
			    			array_push($Addr1Array,			$info['vchAddress1']);
			    			array_push($Addr2Array,			$info['vchAddress2']);
			    			array_push($Addr3Array,			$info['vchAddress3']);
			    			array_push($CityArray,			$info['vchCity']);
			    			array_push($StateArray,			$info['vchState']);
			    			array_push($PhoneArray,			$info['vchPhone']);
			    			array_push($CountryArray,		$info['vchCountry']);
			    			array_push($HideArray,			$info['tiHide_email']);
			    			array_push($ZipArray,			$info['vchZip']);
			    		}
			    		 
			    	}
			    	// print_r($ImageIdArray);
			    	$result['ImageArray']			= $ImageArray;
			    	$result['ImageIdArray']			= $ImageIdArray;
			    	$result['IdArray']				= $IdArray;
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

}
