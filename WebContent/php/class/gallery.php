<?php
/*
 * Created: 10/3/2016
 * Author:  LF Bolivar
 *
 * Class Gallery
 *
 * The class contains the definitions defines the algorithm to display content by category
 * - __construct()
 *
 * The class contains x methods:
 * - display_gallery()
 * - display_category()
 * - display_detail()
 * 
 */

class Gallery {
	
	public $_domain;
//	public $_modal = NULL;
	public $image;

	public $html_files;
	public $php_files;
	public $_priv_header_title;
	public $_priv_welcome_message;
	public $_priv_welcome_message2;
	public $_pub_header_title;
	public $_pub_welcome_message;
	public $_pub_welcome_message2;
	public $user_vchPassword;
	public $url_css;
	public $url_home;
	public $url_php;
	public $sec_html_files;
	public $sec_url_php;
	
	public $htmlDetail;
		
	protected $_CatBody;
	protected $_CatId;
	protected $_title;	
	protected $Image;
	
	private $cat = array();
	private $categoryArray = array();	
	
	
/*
 * 	Method to initialize variables and prepare for to call methods of the Gallery class.
 * 	
 */	
	function __construct(){
		
		
		//  Sets path location variables for files.
		$objConfig = Config::getInstance();
		
		$this->_domain               	= $objConfig->get('domain');
		$this->html_files            	= $objConfig->get('html_files');
		$this->php_files            	= $objConfig->get('php_files');
		$this->_pub_header_title     	= $objConfig->get('pub_header_title');
		$this->_pub_welcome_message   	= $objConfig->get('pub_welcome_message');
		$this->_pub_welcome_message2  	= $objConfig->get('pub_welcome_message2');
		$this->_priv_header_title     	= $objConfig->get('priv_header_title');
		$this->_priv_welcome_message  	= $objConfig->get('priv_welcome_message');
		$this->_priv_welcome_message2 	= $objConfig->get('priv_welcome_message2');
		$this->_priv_content_desc		= $objConfig->get('priv_content_desc');
		$this->priv_class_files      	= $objConfig->get('priv_class_files');
		$this->sec_html_files        	= $objConfig->get('sec_html_files');
		$this->sec_url_php           	= $objConfig->get('sec_url_php');
		$this->url_css               	= $objConfig->get('url_css');
		$this->url_home   			 	= $objConfig->get('url_home');
		$this->url_php               	= $objConfig->get('url_php');
				
		$this->_CatBody              	= "Category";
		$this->_modal                	= $objConfig->get('modal');
		
	}

	/*
	 * 	Method to display category
	 */
	function display_gallery($cat) {
	
	    //$data = array();
	    
	    require $this->priv_class_files.'db_gallery.php';
	    		
		// Only DB credentials are needed to connect and read the category table (table5)
		// fetch all columns  from the  category table
		if (empty($cat['catid']) && empty($cat['ad'])) {
			
			$obj_gallery = new db_gallery($data);
			$this->categoryArray = $obj_gallery->join_category_ad();
			//echo($categoryArray['CatImageArray']);
			
			if ($this->categoryArray != 0){
				$this->categoryArray['htmlDetail']	= $this->html_files.'browse.html';
			}
				
		}			
		// $this->_catid = $cat['catid'];
		if (!empty($cat['catid'])) {

			$data['catid']	= $cat['catid'];
			$this->_CatBody	= $cat['catdesc'];
			$this->_CatId	= $cat['catid'];
			
			$obj_gallery = new db_gallery($data);
			$this->categoryArray = $obj_gallery->join_ad_image();
			
			if ($this->categoryArray != 0){
				$this->categoryArray['htmlDetail']	= $this->html_files.'category.html';
				$this->categoryArray['catid']		= $this->_CatId;
			}
			
		}
		if (!empty($cat['ad'])) {
			
			$data['ad']        = $cat['ad'];
			$this->_CatBody    = $cat['catdesc'];
			$data['FileId']    = $cat['FileId'];
			
			$obj_gallery = new db_gallery($data);
			$this->categoryArray = $obj_gallery->join_details();
				
			if ($this->categoryArray != 0){
				$this->categoryArray['htmlDetail']	= $this->html_files.'browsedetails.html';
			}
		}
		//print_r("catid: ".$this->_catid);
		
		// Include Cascading Style Sheet and html tag definition
		require $this->html_files.'pageHeader.html';
		
		$this->_title = !empty($this->_CatBody) ? TITLE.' - '.basename($this->_CatBody) : TITLE;
		//print('<title>'.$this->title.'</title>'."\r\n");
		print('</head>'."\r\n".'<body>'."\r\n");
		
		// Set messages and variables before call to PublicGallery to process display functions/methods.
		$pub_header_title     	        = $this->_pub_header_title;
		$pub_welcome_message  			= $this->_pub_welcome_message;
		$pub_welcome_message2 			= $this->_pub_welcome_message2;
		$priv_content_desc				= $this->_priv_content_desc;
		$modal               	 		= $this->_modal;
		
		require $this->html_files.'pageHeaderMenu.html';
		
		if(!empty($this->categoryArray)){
			
			$this->categoryArray['catdesc']		= $this->_CatBody;
			$this->categoryArray['htmlBody']	= $this->html_files.'pageBody.html';
			
			$obj_gallery = new PublicGallery($this->categoryArray);
			$obj_gallery->display_thumbnails();
			//print('<!-- Closed div class=content -->'."\r\n".'</div>'."\r\n");
		}
		else {
			print('</ul>'."\r\n");
			print('<div class="content2">');
			//echo('<h2>Browse '.$this->_CatBody.'</h2>'."\r\n");
			print_r('<h2>Category '.$this->_CatBody.'</h2>'."\r\n");
			print('<h3 class="content2">Nothing to display here! </h3>'."\r\n");
		
		}	
		
		//include $php_files.'PubGallery.php';
		$domain = $this->_domain;
		require $this->html_files.'pageFooter.html';
		exit();
	}

	/*
	 * 	Method to display workench category
	 */
	function display_workbench($sessionLogin) {
	
	    // $data = array();
	    
	    // Only DB credentials are needed to connect and read the category table (table5)
		// fetch all columns  from the  category table
		require $this->priv_class_files.'db_workbench.php';
	
		$data['sessionEmail']= $sessionLogin['sessionEmail'];
		$data['sessionPass']= $sessionLogin['sessionPass'];
		
		// $this->_catid = $cat['catid'];
		if (empty($sessionLogin['catid']) && empty($sessionLogin['adid'])) {
			
			$obj_workbench = new db_workbench($data);
			$categoryArray = $obj_workbench->read_ad_by_category();
			//echo($categoryArray['CatImageArray']);
			
			if ($categoryArray != 0){
				$categoryArray['htmlDetail']	= $this->html_files.'viewAd.html';
			}
		}

		// $this->_catid = $cat['catid'];
		if (!empty($sessionLogin['catid'])) {
		
			$data['catid'] 	= $sessionLogin['catid'];
			$this->_CatBody	= $sessionLogin['catdesc'];
			$this->_CatId	= $sessionLogin['catid'];
				
			$obj_workbench = new db_workbench($data);
			$categoryArray = $obj_workbench->read_ad_images();
		
			if ($categoryArray != 0){
				$categoryArray['htmlDetail']= $this->html_files.'mycategory.html';
				$categoryArray['catid']=$this->_CatId;
			}
		}
		if (!empty($sessionLogin['adid'])) {
			
			$data['adid'] 	= $sessionLogin['adid'];
			$this->_CatBody	= $sessionLogin['catdesc'];
			$data['FileId']	= $sessionLogin['FileId'];
			
			$obj_workbench = new db_workbench($data);
			$categoryArray = $obj_workbench->read_ad_detail();
			
			if ($categoryArray != 0){
				$categoryArray['htmlDetail']= $this->html_files.'mydetails.html';
			}
				
		}
		
		// Include Cascading Style Sheet and html tag definition
		require $this->sec_html_files.'pageHeaderPrivate.html';
	
	
		$this->_title = !empty($this->_CatBody) ? TITLE.' - '.basename($this->_CatBody) : TITLE;
		print('<title>'.$this->title.'</title>'."\r\n");
		print('</head>'."\r\n".'<body>'."\r\n");
	
		//	Set messages and variables before call to PublicGallery to process display functions/methods.
		//	Set the variables to display before the html is generated		
		$priv_header_title     			= $this->_priv_header_title;
		$priv_welcome_message  			= $this->_priv_welcome_message;
		$priv_welcome_message2 			= $this->_priv_welcome_message2;
		$modal                			= $this->_modal;
	
		require $this->sec_html_files.'pageHeaderPrivMenu2.html';
	
		if(!empty($categoryArray)){

			$categoryArray['htmlBody']		= $this->html_files.'pageBodyPrivate.html';
			$categoryArray['catdesc']		= $this->_CatBody;
				
			$obj_gallery = new PublicGallery($categoryArray);
			$obj_gallery->display_thumbnails();
			//print('<!-- Closed div class=content -->'."\r\n".'</div>'."\r\n");
		}
		else {
			print('</ul>'."\r\n");
			print('<div class="content2">');
			//echo('<h2>Browse '.$this->_CatBody.'</h2>'."\r\n");
			print_r('<h2>Browse '.$this->_CatBody.'</h2>'."\r\n");
			print('<h3 class="content2">Nothing to display here! </h3>'."\r\n");
	
		}
	
		// set the html variables and send the tags
		$domain = $this->_domain;
		require $this->html_files.'pageFooterPrivate.html';
		exit();
	}
	
}

/*
 *  PublicGallery extends Gallery Class and begins to define the details of the Category and Detail Drill Down.
 *
 */
class PublicGallery extends Gallery {

	public $categoryArray;
	public $images_files;
	public $php_files;
	public $url_images;
	public $ImageId;
	public $imageName;
	

	protected $CatAdArray= array();
	protected $CatCaptionArray= array();
	protected $CatCountArray= array();
	protected $CatDescArray= array();
	protected $CatImageArray = array();
	protected $CatImageIdArray= array();
	protected $CatIdArray= array();
	protected $CatHtmlDetail= array();
	protected $CatHtmlBody= array();

	protected $_pub_content_desc;
	protected $_priv_content_desc;	
	
	protected $CatArray= array();
	
	protected $CatAdDateArray= array();
	protected $CatAdDescArray= array();
	protected $CatAddr1Array= array();
	protected $CatAddr2Array= array();
	protected $CatAddr3Array= array();
	protected $CatAdExDateArray= array();
	protected $CatAdModDateArray= array();
	protected $CatAdValidArray= array();
	protected $CatCityArray= array();
	protected $CatCountryArray= array();
	protected $CatEmailArray= array();
	protected $CatHeadlineArray= array();
	protected $CatHideArray= array();
	protected $CatPeriodArray= array();
	protected $CatPhoneArray= array();
	protected $CatStateArray= array();
	protected $CatURLArray= array();
	protected $CatUserFirstNameArray= array();
	protected $CatUserLastNameArray= array();
	protected $CatZipArray= array();
	
	protected $c;
	protected $end;
	protected $i;
	protected $index;
	protected $month;
	protected $n;
	protected $next;
	protected $p;
	protected $pg;
	protected $prev;
	protected $query;
	protected $rows;
	protected $section;
	protected $start;
	protected $_CatId;
	
	protected $AdMail;
	protected $AdCaption;
	protected $AdCategory;
	protected $Cat;
	protected $CatCount;
	protected $CatId;
	protected $Id;
	protected $modal;
	protected $sessionEmail;
	protected $total;
	protected $URL;
	
	/*
	 *	Constructor Method to initialize variables
	 */
	function __construct($CatArray) {
		
	    if (isset($CatArray['ImageArray'])){
    	    $this->CatImageArray 		= $CatArray['ImageArray'];
    	    $this->CatIdArray    		= $CatArray['IdArray'];
    	    $this->CatDescArray  		= $CatArray['DescArray'];
    	    $this->CatCountArray 		= $CatArray['CountArray'];
    	    $this->CatAdArray    		= $CatArray['AdArray'];
	    }
	    
	    if (isset($CatArray['ImageIdArray'])){		
	        $this->CatImageIdArray		= $CatArray['ImageIdArray'];
	        $this->CatURLArray			= $CatArray['URLArray'];
	        $this->CatCaptionArray		= $CatArray['CaptionArray'];
	        $this->CatHeadlineArray		= $CatArray['HeadlineArray'];
	        $this->CatAdValidArray		= $CatArray['AdValidArray'];
	        $this->CatAdExDateArray		= $CatArray['AdExDateArray'];
	    }
		
	    if (isset($CatArray['AdDateArray'])){
	        $this->CatAdDateArray		= $CatArray['AdDateArray'];
	        $this->CatAdModDateArray	= $CatArray['AdModDateArray'];
	        $this->CatAdDescArray		= $CatArray['AdDescArray'];
	        $this->CatAdPeriodArray		= $CatArray['PeriodArray'];
	        $this->CatUserFirstNameArray= $CatArray['UserFirstNameArray'];
	        $this->CatUserLastNameArray	= $CatArray['UserLastNameArray'];
	        $this->CatEmailArray		= $CatArray['EmailArray'];
	        $this->CatAddr1Array		= $CatArray['Addr1Array'];
	        $this->CatAddr2Array		= $CatArray['Addr2Array'];
	        $this->CatAddr3Array		= $CatArray['Addr3Array'];
	        $this->CatCityArray			= $CatArray['CityArray'];
	        $this->CatStateArray		= $CatArray['StateArray'];
	        $this->CatPhoneArray		= $CatArray['PhoneArray'];
	        $this->CatCountryArray		= $CatArray['CountryArray'];
	        $this->CatHideArray			= $CatArray['HideArray'];
	        $this->CatZipArray			= $CatArray['ZipArray'];
	    }
		
	    $this->CatHtmlDetail		= $CatArray['htmlDetail'];
	    $this->CatHtmlBody			= $CatArray['htmlBody'];
	    $this->_CatBody         	= $CatArray['catdesc'];
	    if (isset($CatArray['catid'])){
		    $this->_CatId				= $CatArray['catid'];
		}
		
		//  Sets path for files and start session.
		$objConfig = Config::getInstance();
		
		$this->priv_class_files     = $objConfig->get('priv_class_files');
		$this->sec_html_files       = $objConfig->get('sec_html_files');
		$this->html_files           = $objConfig->get('html_files');
		$this->images_files         = $objConfig->get('images_files');
		$this->php_files            = $objConfig->get('php_files');
		$this->url_images           = $objConfig->get('url_images');

		$this->_priv_content_desc	= $objConfig->get('priv_content_desc');
		$this->_pub_content_desc	= $objConfig->get('pub_content_desc');
		
		
		// decide what page of a paticular gallery we're viewing
		$this->pg = !empty($_REQUEST['pg']) && ctype_digit($_REQUEST['pg']) ? $_REQUEST['pg'] : 1;
		// echo '$pg='.$pg;
	
		// images per page reflect php arrays start at position zero [0]
		$this->section = ROWS * COLS;
		//echo ' ROWS*COLS=$section='.$section;
	
		// last possible ending point for images, depending which page we're on
		$this->end = $this->section * $this->pg;
		//echo ' $section*$pg=$end='.$this->end;
	
		// starting point for images, depending which page we're on
		$this->start = $this->end - $this->section;
		// echo ' $end-$section=$start='.$start;
	
		// previous page
		$this->prev = $this->pg - 1;
		// echo ' $pg-1=$prev='.$prev;
	
		// next page
		$this->next = $this->pg + 1;
		// echo ' $pg+1=$next='.$next;
	}	

	/*
	 *	Method to draw previous and next links for images
	 */ 
	protected function navigate_images($total) {
		
		$this->query = !empty($this->Image) ? '?file='.rawurlencode($this->Image).'&pg=' : '?pg=';
		$this->pages = $this->total <= $this->section ? 1 : ceil($this->total / $this->section);
		$this->p = '<li><a href="'.SELF.$this->query.$this->prev.'&cat='.$this->_CatId.'&catd='.$this->_CatBody.'">Prev</a></li>';
		$this->n = '<li><a href="'.SELF.$this->query.$this->next.'&cat='.$this->_CatId.'&catd='.$this->_CatBody.'">Next</a></li>';
		$this->c = '<li><p>Page '.$this->pg.' of '.$this->pages.'</p></li>';
	
		//echo('<div class="navigate_images">'."\r\n");
		//echo('<div class="left">'."\r\n".'<ul>'."\r\n");
		if(($this->pg == 1 && $this->end >= $this->total)){
			echo($this->c."\r\n");
		}elseif($this->pg == 1){
			//echo($n.' '.$c);
			echo ($this->n."\r\n");
			echo ($this->c."\r\n");
		}elseif($this->end < $this->total){
			echo($this->p."\r\n");
			echo($this->n."\r\n");
			echo($this->c."\r\n");
			// echo($p.' '.$n.' '.$c);
		}else{
			//echo($p.' '.$c);
			echo($this->p."\r\n");
			echo($this->c."\r\n");
		}
		//    print($c);
		// echo('</div>');
		// compensate for 1px style image borders, i feel dirty
		// $mainwidth = COLS * THMBWIDTH;
		//print('<div id="main" style="width: '.$mainwidth.'px;">'."\r\n");
		$CatBody = $this->_CatBody;
		require $this->CatHtmlBody;
		//print('<div class="content">'."\r\n");
		//echo('<h2>Browse '.$CatBody.'</h2>'."\r\n");
		//print_r($CatBody);
		}
	
	/*
	 *	Method to display thumbnails
	 */ 
	protected function display_thumbnails() {
	
		$this->total = count($this->CatImageArray);
		//echo '$total='.$this->total;
	
		$this->end = $this->total < $this->end ? $this->total : $this->end;
	
		// get rid of redundant table rows
		$this->math = count(array_slice($this->CatImageArray, $this->start)) / COLS;
		$this->rows = is_int($this->math) ? $this->math : ceil($this->math);
	
		//  In case we have to page through pages of categories lets set up the Next and Prev buttons dynamically
		self::navigate_images($this->total);
		
		print('<table cellpadding="0" cellspacing="0">'."\r\n");
		
		//  This loop is where the actual table html tags are generated to create the thumbnail grid
		for($this->i = 0; $this->i < $this->rows; $this->i++) {
			print('<tr>');
			for($this->n = 0; $this->n < COLS; $this->n++) {
				$this->index = $this->start++;
				$image = $this->index < $this->end ? $this->CatImageArray[$this->index] : '&nbsp;';
				if($image != '&nbsp;') {
					print('<td style="width:'.(THMBWIDTH + 20).'px; height:'.(THMBHEIGHT + 20).'px;">'."\r\n");
					// Load array values from Category table.  The calling scrips are BrowseAd.php, Category.php, ViewDetails.php
					//					echo '$start='.$start;
					//					echo '$index='.$index;
					//					echo ' $end='.$end;
					$Cat = $this->CatDescArray[$this->index];
					$CatId = $this->CatIdArray[$this->index];
					$AdCategory = $CatId;
						
					// The below variable $Image will contain a valid path for the category image
					// It will not contain a good path for Ad images in database
					// **** I need to figure out how the category image gets dispayed with classes
					// ****************************************************************************
					$Image = $this->url_images.$image;
					$ImageId  = $this->CatImageIdArray[$this->index];
					$AdEmail = $this->CatEmailArray[$this->index];
					//	Display the variables
					//print_r('$Cat='.$Cat);
					// echo 'mg-$CatCount='.$CatCount;
					// echo 'mg-$AdEmail='.$AdEmail;
					
					//  CatAdPeriodArray contains variable with length of time (in days) displayed in Week(s) in drop-down 
					//  the Content will be visible in Public Gallery
					$AdPeriod = $this->CatAdPeriodArray[$this->index];
								
					// This will check and correct the count for a single add
					$CatCount = $this->CatCountArray[$this->index];
					$Id     = $this->CatAdArray[$this->index];
					if (($Id == Null) && $CatCount == 1)
					{
						$CatCount = 0;
					}
						
					$AdURL			= $this->CatURLArray[$this->index];
					$AdCaption		= $this->CatCaptionArray[$this->index];
					$AdHeadline 	= $this->CatHeadlineArray[$this->index];
					$AdDesc			= $this->CatAdDescArray[$this->index];
					$AdDate			= $this->CatAdDateArray[$this->index];
					$AdExDate		= $this->CatAdExDateArray[$this->index];
					$AdModDate		= $this->CatAdModDateArray[$this->index];
					$first			= $this->CatUserFirstNameArray[$this->index];
					$last			= $this->CatUserLastNameArray[$this->index];
						
					// Check if content is active in public gallery
					$AdValid = $this->CatAdValidArray[$this->index];
					if ($AdValid == 0){
						$AdActive = "Hidden";
					} else if ($AdExDate > date("Y-m-d")){
						$AdActive = "Visible";
					} else {
					    $AdActive = "Expired";
					}
					// This checks if user wants private personal information
					$Hide  = $this->CatHideArray[$this->index];
					// echo ($Hide ? 'Yes' : 'No');
					switch ($Hide){
						case 0:
							$Addr1 = "Private";
							$Addr2 = "";
							$Addr3 = "";
							$City = "";
							$State = "";
							$Zip = "";
							$Country = "";
							$Phone = "Phone: Private";
							break;
						case 1:
							$Addr1 = $this->CatAddr1Array[$this->index];
							$Addr2 = $this->CatAddr2Array[$this->index];
							$Addr3 = $this->CatAddr3Array[$this->index];
							$City = $this->CatCityArray[$this->index];
							$State = $this->CatStateArray[$this->index];
							$Zip = $this->CatZipArray[$this->index];
							$Country = $this->CatCountryArray[$this->index];
							$Phone = "Phone: ".$this->CatPhoneArray[$this->index];
							break;
						case 2:
							$Addr1 = "Private";
							$Addr2 = "";
							$Addr3 = "";
							$City = "";
							$State = "";
							$Zip = "";
							$Country = "";
							$Phone = "Phone: ".$this->CatPhoneArray[$this->index];
							break;
					}
					//print_r ($this->images_files.$this->image);
					if (!file_exists($this->images_files.$this->image))
					{
						$imageName = "No Image Found";
					}else{
						$imageName = $image;
					}
					// print_r ("AdPeriod: ".$AdPeriod);
					//$ImageId = $this->ImageId;
					require $this->php_files.'LoadCatArray.php';
					require $this->CatHtmlDetail;
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
		
	} // end of display_thumbnails()
	
} //end of PublicGallery
