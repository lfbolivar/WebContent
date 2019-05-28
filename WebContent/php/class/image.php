<?php
/*
 * Created: 12/02/2016
 * Author:  LF Bolivar
 *
 * Image content
 *
 * The class contains basic (min) attributes related to the application Image table
 * - __construct()
 *
 * The class contains x methods:
 * - upload_image()
 */

class Image {

	public $sec_html_files				=NULL;
	public $html_files					=NULL;
	public $php_files					=NULL;
	public $pub_header_title			=NULL;
	public $pub_welcome_message			=NULL;
	public $pub_welcome_message2		=NULL;
	public $modal						=NULL;
	public $options						=NULL;

	protected $priv_class_files			=NULL;
	protected $priv_header_title		=NULL;
	protected $priv_welcome_message		=NULL;
	protected $priv_welcome_message2	=NULL;
	
	protected $image					=NULL;
	protected $fileName					=NULL;
	protected $tmpName					=NULL;
	protected $fileSize					=NULL;
	protected $fileType					=NULL;
	protected $thmbName					=Null;

	/*
	 *
	 * constructor to initialize variables.
	 *
	 *
	 */
	function __construct($image){
	
		//  Sets path for files and start session.
		$objConfig = Config::getInstance();
	
		$this->priv_class_files			= $objConfig->get('priv_class_files');
		$this->sec_html_files			= $objConfig->get('sec_html_files');
		$this->html_files				= $objConfig->get('html_files');
		$this->php_files				= $objConfig->get('php_files');
		$this->pub_header_title			= $objConfig->get('pub_header_title');
		$this->pub_welcome_message		= $objConfig->get('pub_welcome_message');
		$this->pub_welcome_message2		= $objConfig->get('pub_welcome_message2');
		$this->priv_header_title		= $objConfig->get('priv_header_title');
		$this->priv_welcome_message		= $objConfig->get('priv_welcome_message');
		$this->priv_welcome_message2	= $objConfig->get('priv_welcome_message2');
		$this->_domain					= $objConfig->get('domain');

		// If the UPLOAD form is submitted initialize variables used to insert image UPLOAD row.
		$this->fileName = $image['fileName'];
		$this->tmpName  = $image['tmpName'];
		$this->fileSize = $image['fileSize'];
		$this->fileType = $image['fileType'];
		$this->thmbName	= $image['thmbName'];
		}
	/*
	 *
	 * method to upload and store Image into Image table.
	 *
	 *
	 */
	function upload_image(){
		
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		$domain = $this->_domain;
		$priv_header_title = $this->priv_header_title;
		$priv_welcome_message = $this->priv_welcome_message;
		$priv_welcome_message2 = $this->priv_welcome_message2;
		
		require $this->sec_html_files.'pageHeaderPrivate.html';
		require $this->html_files.'pageMemberMenu.html';
		require_once $this->priv_class_files.'db_ad.php';
		require_once $this->priv_class_files.'db_image.php';
		
		// Check to make sure user is providing a file to upload otherwise display message to upload at a later time
		if (empty($this->fileName))
		{
			//echo "<br>File $fileName uploaded<br>";
			$msg1 = "You have completed posting your '$priv_content_desc' and have chosen not to upload an image file at this time";
			$msg2 = "You can upload images for your '$priv_content_desc' via the AD update page.";
			require $this->sec_html_files.'newAdMsg.html';
			require $this->sec_html_files.'pageFooterPrivate.html';
			exit();
		} else {		
			// Prep file name in case it contains slashes in the name.
			if(!get_magic_quotes_gpc())
			{
				$this->fileName = addslashes($this->fileName);
			}
		
			// First we meed to retrieve the latest AD added by this user.
			if (isset($_POST['myAd']))
			{
				$AdId =  $_POST['myAd'];
				$ad = array();
				$ad['AdId'] = $AdId;
				
				try {
					$obj_ad = new db_ad($data, $ad);
					$result = $obj_ad->read();
					if ($result==0){
						// print_r($ad);
						//  If we got here we could not find and Ad for the user trying to upload image
						//  Gives error if we cannot find the latest AD from user.
						$MsgTitle = "UPLOAD";
						$redirect = "UPLOAD.php";
						$MsgType = "Upload.php Message:";
						$Msg1 = "Unable to retrieve the latest AD for this member.";
						$Msg2= "Click button below to Re-establish your session at the Login. ".$result;
						$button = "Login";
						require $this->sec_html_files.'logonMsg.html';
						require $this->sec_html_files.'pageFooterPrivate.html';
						unset($_POST['submit']);
						exit();
					}
						
				} catch(PDOException $ex) {
					//Something went wrong rollback!
					//$db->rollBack();
					echo $ex;
				}
			}
			else
			{
				try {
					$obj_ad = new db_workbench($data);
					$result = $obj_ad->read_max_ad();
					if ($result==0){
						print_r($ad);
						//  If we got here we could not find and Ad for the user trying to upload image
						//  Gives error if we cannot find the latest AD from user.
						$MsgTitle = "UPLOAD";
						$redirect = "UPLOAD.php";
						$MsgType = "Upload.php Message:";
						$Msg1 = "Unable to retrieve the max AD for this member.";
						$Msg2= "Click button below to Re-establish your session at the Login.";
						$button = "Login";
						require $this->sec_html_files.'logonMsg.html';
						require $this->sec_html_files.'pageFooterPrivate.html';
						unset($_POST['submit']);
						exit();
							
					}
						
				} catch(PDOException $ex) {
					//Something went wrong rollback!
					//$db->rollBack();
					echo $ex;
				}
				
			}
			// $getAd = mysqli_query($link, $query )or die('-Upload.php- '.mysqli_error().'');
			
		
			// We have found the latest AD and are ready to update both the AD table and Insert the image file in the UPLOAD table.
			// $Adrow = $result;
			
			//	echo (' ad# '.$Adrow['iAdId']);
			$fileAdId = $result['iAdId'];
			$logonName = $result['vchAdUserName'];
			
			$image = array();
			$image['iFileID']		=0;
			$image['iFileAdId']		=$fileAdId;
			$image['vchFileName']	=$this->fileName;
			$image['vchFileType']	=$this->fileType;
			$image['iFileSize']		=$this->fileSize;
			$image['bFileContent']	=$this->tmpName;
			$image['bThumbnail']	=$this->thmbName;
				
		
			// Insert image row into UPLOAD table.
			try {
				$obj_image = new db_image($data, $image);
				$result = $obj_image->create();
			} catch(PDOException $ex) {
				//Something went wrong rollback!
				//$db->rollBack();
				//echo $ex;
				//  Gives error if we cannot find the latest AD from user.
				$MsgTitle = "UPLOAD";
				$redirect = "UPLOAD.php";
				$MsgType = "Upload.php Message:";
				$Msg1 = "Unable to insert image for this ad.";
				$Msg2= $ex;
				$button = "Login";
				require $this->sec_html_files.'logonMsg.html';
				print_r($result);
				require $this->sec_html_files.'pageFooterPrivate.html';
				unset($_POST['submit']);
				exit();
				
			}
/*			$query = "INSERT INTO ".$tbl_name4." VALUES (0,'$fileAdId', '$fileName', '$fileType', '$fileSize', '$content')";
			mysqli_query($link, $query) or die('-Upload.php- Error, query failed'.mysqli_error().'');
*/		
			//echo "<br>File $fileName uploaded<br>";
			$msg1 = "Thank you $logonName, you have successfully completed your image upload.";
			$msg2 = "Your image file name $this->fileName is now stored in the $priv_header_title database.";
			require $this->sec_html_files.'newAdMsg.html';
			require $this->sec_html_files.'pageFooterPrivate.html';
			exit();
		}
		
	}
}
/*
 *  Class Thumbnail will extend Image
 *  
 *  Used in Upload.php script to resize and recrop image before saving to database.
 */
class Thumbnail extends Image {

	// Variables
		
	protected $image				= Null;
	protected $image_rb				= Null;
	protected $type					= Null;
	protected $name					= Null;
	protected $size					= Null;
	
	protected $ThumbWidth 			= Null; //Thumbnail will be 200x200
	protected $ImageMaxSize 		= Null; //Image Maximum height or width = 600
	protected $ThumbSufix			= Null; //Normal thumb Sufix _thmb
	protected $DestinationDirectory	= Null; //specify upload directory ends with / (slash) =upoads/
	protected $Quality 				= Null; //jpeg quality =90
	protected $CreatedImage 		= Null;
	protected $CurWidth 			= Null;
	protected $CurHeight			= Null;
	protected $ImageExt				= Null;
	protected $TempSrc				= Null;
	protected $ImageName			= Null;
	protected $ImageSize 			= Null;
	protected $ImageType 			= Null;
	protected $NewImageName 		= Null;
	protected $DestImageName_thmb 	= Null;
	protected $DestImageName 		= Null;
	

	function __construct($image_array) {

		$this->name 	= $image_array['fileName'];
		$this->type 	= $image_array['fileType'];
		$this->image 	= $image_array['tmpName'];
		$this->size 	= $image_array['fileSize'];
		// $this->image_rb = fopen($this->image, 'rb');
		
		$this->ThmbWidth 			= THMBWIDTH;
		$this->ImageMaxSize 		= IMGMAXSIZE; 			//Image Maximum height or width
		$this->ThumbSufix			= "_thmb"; 				//Normal thumb Prefix
		$this->DestinationDirectory	= 'uploads/'; 			//specify upload directory ends with / (slash)
		$this->Quality 				= IMGQUALITY; 			//jpeg quality
		
		
		// check $_FILES['ImageFile'] not empty
		if(!isset($this->name) || !isset($this->image)){
			print_r($image_array);
			die('Something wrong with uploaded file, something missing!'); // output error when above checks fail.
		}
		
		// Random number will be added after image name
		//$RandomNumber 	= rand(0, 9999999999);
		
		$this->ImageName	= str_replace(' ','-',strtolower($this->name));	//get image name
		$this->ImageSize	= $this->size; 									// get original image size
		$this->TempSrc		= $this->image; 								// Temp name of image file stored in PHP tmp folder
		$this->ImageType	= $this->type; 									//get file type, returns "image/png", image/jpeg, text/plain etc.
		
		//Let's check allowed $ImageType, we use PHP SWITCH statement here
		switch(strtolower($this->type))
		{
			case 'image/png':
				//Create a new image from file
				$this->CreatedImage =  imagecreatefrompng($this->image); break;
			case 'image/gif':
				$this->CreatedImage =  imagecreatefromgif($this->image); break;
			case 'image/jpeg':
			case 'image/pjpeg':
				$this->CreatedImage = imagecreatefromjpeg($this->image); break;
			default:
				die('Unsupported File!'); //output error and exit
		}
		
		//PHP getimagesize() function returns height/width from image file stored in PHP tmp folder.
		//Get first two values from image, width and height.
		//list assign svalues to $CurWidth,$CurHeight
		list($this->CurWidth,$this->CurHeight)=getimagesize($this->image);
		
		//Get file extension from Image name, this will be added after random name
		$this->ImageExt = substr($this->name, strrpos($this->name, '.'));
		$this->ImageExt = str_replace('.','',$this->ImageExt);
		
		//remove extension from filename
		$this->ImageName 		= preg_replace("/\\.[^.\\s]{3,4}$/", "", $this->ImageName);
				
		//set the Destination Image
		$this->DestImageName 	= $this->NewImageName.$this->ThumbSufix; //Thumbnail name with no destination directory
		
		//Construct a new name with random number and extension.
		$this->DestImageName_thmb = $this->DestImageName.'.'.$this->ImageExt;
		
/*		parent::set_img();
		parent::set_quality(80);
		parent::set_size($width,$height);
		$this->thumbnail= pathinfo($image, PATHINFO_DIRNAME).pathinfo($image, PATHINFO_FILENAME).'_tn.'.pathinfo($image, PATHINFO_EXTENSION);
		$this->thumbnail = 
		parent::save_img($this->thumbnail);
		parent::clear_cache();
		*/
	}

	/*
	** Resize image
	** 
	**/
	public function resize_image() {
				
		//Check Image size is not 0
		if($this->CurWidth <= 0 || $this->CurHeight <= 0){
			return false;
		}
		
		//Construct a proportional size of new image
		$ImageScale      	= min($this->ImageMaxSize/$this->CurWidth, $this->ImageMaxSize/$this->CurHeight);
		$NewWidth  			= ceil($ImageScale*$this->CurWidth);
		$NewHeight 			= ceil($ImageScale*$this->CurHeight);
		$NewCanvas 			= imagecreatetruecolor($NewWidth, $NewHeight);
		
		// Resize Image
		if(imagecopyresampled($NewCanvas, $this->CreatedImage,0, 0, 0, 0, $NewWidth, $NewHeight, $this->CurWidth, $this->CurHeight)){

			ob_start();
			
			switch(strtolower($this->ImageType))
			{
				case 'image/png':
					imagepng($NewCanvas, null, 0); break;
				case 'image/gif':
					imagegif($NewCanvas); break;
				case 'image/jpeg':
				case 'image/pjpeg':
					imagejpeg($NewCanvas,null,$this->Quality); break;
				default:
					return false;
			}
			$this->image_rb = ob_get_contents();
			ob_end_clean();
			/*Destroy image, frees memory
			 if(is_resource($NewCanves)){
			 imagedestroy($NewCanves);
			 }*/
			return $this->image_rb;
		}
	
	}
	//This function corps image to create exact square images, no matter what its original size!
	function crop_image(){
		
		$iSize = $this->CurWidth;
		//Check Image size is not 0
		if($this->CurWidth <= 0 || $this->CurHeight <= 0){
			return false;
		}
	
		//abeautifulsite.net has excellent article about "Cropping an Image to Make Square bit.ly/1gTwXW9
		if($this->CurWidth>$this->CurHeight){
			$y_offset = 0;
			$x_offset = ($this->CurWidth - $this->CurHeight) / 2;
			$square_size 	= $this->CurWidth - ($x_offset * 2);
		} else {
			$x_offset = 0;
			$y_offset = ($this->CurHeight - $this->CurWidth) / 2;
			$square_size = $this->CurHeight - ($y_offset * 2);
		}
	
		$NewCanvas 	= imagecreatetruecolor($iSize, $iSize);
		if(imagecopyresampled($NewCanvas, $this->CreatedImage ,0, 0, $x_offset, $y_offset, $iSize, $iSize, $square_size, $square_size)){
			
			ob_start();
			
			switch(strtolower($this->ImageType)){
				case 'image/png':
					imagepng($NewCanvas, null, 0); break;
				case 'image/gif':
					imagegif($NewCanvas); break;
				case 'image/jpeg':
				case 'image/pjpeg':
					imagejpeg($NewCanvas, null, $this->Quality); break;
				default:
					return false;
			}
			$this->image_rb = ob_get_contents();
			ob_end_clean();
			/*Destroy image, frees memory
			if(is_resource($NewCanves)){
				imagedestroy($NewCanves);
			}*/
			return $this->image_rb;
		}
	}
		 
	
}