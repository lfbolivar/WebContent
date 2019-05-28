<?php
/*
 * Created: 10/29/2016
 * Author:  LF Bolivar
 *
 * Class content
 *
 * The class contains basic (min) attributes related to the application Ad table 
 * - __construct()
 *
 * The class contains x methods:
 * - update_content()
 * - insert_content()
 * - display_content_form()
 * - delete_content()
 */

class Content {

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
	
	protected $ad						=array();
	protected $AdId						=NULL;
	protected $AdCategory				=NULL;
	protected $AdPeriod					=NULL;
	protected $AdCaption				=NULL;
	protected $AdHeadline				=NULL;
	protected $AdNoUpload 				=NULL;
	protected $AdDesc					=NULL;
	protected $AdURL					=NULL;
	protected $AdUserId					=NULL;
	protected $AdValid					=NULL;
	protected $AdExpireDate				=NULL;
	protected $UserEmail				=NULL;
	protected $UserPass					=NULL;
	protected $UserName					=NULL;

	protected $_imageid					=Null;
	protected $_deltype					=Null;
	
	protected $_regemailtitle			=Null;
	protected $_regemailaddr			=Null;
	protected $_localregion				=Null;
	protected $_priv_content_desc		=Null;
	
	protected $fileName					=NULL;
	protected $tmpName					=NULL;
	protected $fileSize					=NULL;
	protected $fileType					=NULL;
	
	/*
	 *
	 * constructor to initialize variables.
	 *
	 *
	 */
	function __construct($ad){
		
		//  Sets path for files and start session.
		$objConfig = Config::getInstance();
	
		$this->priv_class_files			= $objConfig->get('priv_class_files');
		$this->sec_html_files			= $objConfig->get('sec_html_files');
		$this->sec_php_files			= $objConfig->get('sec_php_files');
		$this->html_files				= $objConfig->get('html_files');
		$this->php_files				= $objConfig->get('php_files');
		$this->pub_header_title			= $objConfig->get('pub_header_title');
		$this->pub_welcome_message		= $objConfig->get('pub_welcome_message');
		$this->pub_welcome_message2		= $objConfig->get('pub_welcome_message2');
		$this->priv_header_title		= $objConfig->get('priv_header_title');
		$this->priv_welcome_message		= $objConfig->get('priv_welcome_message');
		$this->priv_welcome_message2	= $objConfig->get('priv_welcome_message2');
		$this->_domain					= $objConfig->get('domain');
		$this->_regemailtitle			= $objConfig->get('regemailtitle');
		$this->_regemailaddr			= $objConfig->get('regemailaddr');
		$this->_localregion				= $objConfig->get('localregion');
		$this->_priv_content_desc		= $objConfig->get('priv_content_desc');
		
		$this->AdId						=$ad['AdId'];
		$this->AdCategory				=$ad['AdCatId'];
		$this->AdPeriod					=$ad['AdPeriod'];
		$this->AdCaption				=$ad['AdCaption'];
		$this->AdHeadline				=$ad['AdHeadline'];
		$this->AdNoUpload				=$ad['AdNoUpload'];
		$this->AdDesc					=$ad['AdDesc'];
		$this->AdURL					=$ad['AdURL'];
		$this->AdUserId					=$ad['AdUserId'];
		$this->AdValid					=$ad['AdValid'];
		$this->AdExpireDate				=$ad['AdExpireDate'];

		$this->UserEmail				=$ad['UserEmail'];
		$this->UserPass					=$ad['UserPass'];
		$this->UserName					=$ad['UserName'];
		
		// From MyAdDelete we will load 3 variables icluding AdId above.
		$this->_deltype 				=$ad['deltype'];
		$this->_imageid					=$ad['imageid'];
		
		$this->fileName 				=$ad['fileName'];
		$this->tmpName  				=$ad['tmpName'];
		$this->fileSize 				=$ad['fileSize'];
		$this->fileType 				=$ad['fileType'];
		
	
	}
	
	/*
	 *
	 * method to update content in Ad table.
	 *
	 */
	function update_content(){
		
		
		$ad['AdCaption']	=$this->AdCaption;
		$ad['AdHeadline']	=$this->AdHeadline;
		$ad['AdDesc']		=$this->AdDesc;
		$ad['AdURL']		=$this->AdURL;
		$ad['AdExpireDate']	=$this->AdExpireDate;
		$ad['AdPeriod']		=$this->AdPeriod;
		$ad['AdCatId']		=$this->AdCategory;
		$ad['AdValid']		=$this->AdValid;
		$ad['AdId']			=$this->AdId;	
		$ad['UserEmail']	=$this->UserEmail;
		$ad['UserPass']		=$this->UserPass;
		$ad['UserName']		=$this->UserName;

		$AdCaption			=$this->AdCaption;
		$AdHeadline			=$this->AdHeadline;
		$AdDesc				=$this->AdDesc;
		$AdURL				=$this->AdURL;
		$AdExpireDate		=$this->AdExpireDate;
		$AdPeriod			=$this->AdPeriod;
		$AdCategory			=$this->AdCategory;
		$AdValid			=$this->AdValid;
		$AdId				=$this->AdId;
		$UserEmail			=$this->UserEmail;
		$UserPassword		=$this->UserPass;
		$UserName			=$this->UserName;
		
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		$priv_header_title=$this->priv_header_title;
		$priv_welcome_message=$this->priv_welcome_message;
		$priv_welcome_message2=$this->priv_welcome_message2;
			
		//The routine LoadCatArray.php will select all catagories from the Catagory table and format them for loading into the $options array.
		require_once $this->php_files.'LoadCatArray.php';
		
		require $this->sec_html_files.'pageHeaderPrivate.html';
		require $this->html_files.'pageMemberMenu.html';
		require_once $this->priv_class_files.'db_ad.php';
		
		// Validation of required fields.
		if(empty($AdCategory) or empty($AdPeriod) or empty($AdCaption) or empty($AdHeadline) or empty($AdDesc)){
			$msg1 = "Please provide required '*' ";
			$msg2 = "fields, and resubmit request\n";
			include $this->html_files.'mydetails.html';
			include $this->sec_html_files.'pageFooterPrivate.html';
			self::show_form($AdId,$AdCategory,$AdPeriod,$AdCaption,$AdHeadline,$AdURL,$AdDesc,$AdValid);
			
		} else {
							
			try {
				$obj_ad = new db_ad($data, $ad);
				$result = $obj_ad->update();
				if ($result==0){
					// print_r($ad);
					//  On successful update route back to member.html.
					$MsgTitle = $this->_regemailtitle;
					$MsgType = "Thank you, ".$this->UserName.";";
					$Msg1 = "No update(s) or change(s) to existing data found in your request.";
					$Msg2 = "You can continue processing your content via the WorkBench tool.";
					include $this->sec_html_files.'member.html';
					include $this->sec_html_files.'pageFooterPrivate.html';
					exit();
						
				}
			} catch(PDOException $ex) {
				//Something went wrong rollback!
				//$db->rollBack();
				echo $ex;
			}
						
			//  On successful update route back to member.html.
			$MsgTitle = $this->_regemailtitle;
			$MsgType = "Thank you, ".$this->UserName.";";
			$Msg1 = "You have successfully updated your web content and by default extended its expiration date in the Public Gallery.";
			$Msg2 = "If you chose to activate or deactivate your content this will now be reflected in the Public Gallery.";
			include $this->sec_html_files.'member.html';
			include $this->sec_html_files.'pageFooterPrivate.html';
			exit();
		}
	}
	/*
	 *
	 * method to Insert content into Ad table.
	 *
	 */
	function insert_content(){
		
		$ad['AdCaption']	=$this->AdCaption;
		$ad['AdHeadline']	=$this->AdHeadline;
		$ad['AdNoUpload']	=$this->AdNoUpload;
		$ad['AdDesc']		=$this->AdDesc;
		$ad['AdURL']		=$this->AdURL;
		$ad['AdExpireDate']	=$this->AdExpireDate;
		$ad['AdPeriod']		=$this->AdPeriod;
		$ad['AdCatId']		=$this->AdCategory;
		$ad['AdValid']		=$this->AdValid;
		$ad['AdId']			=$this->AdId;
		$ad['UserEmail']	=$this->UserEmail;
		$ad['UserPass']		=$this->UserPass;
		$ad['UserName']		=$this->UserName;
		
		$AdCaption			=$this->AdCaption;
		$AdHeadline			=$this->AdHeadline;
		$AdNoUpload			=$this->AdNoUpload;
		$AdDesc				=$this->AdDesc;
		$AdURL				=$this->AdURL;
		$AdExpireDate		=$this->AdExpireDate;
		$AdPeriod			=$this->AdPeriod;
		$AdCategory			=$this->AdCategory;
		$AdValid			=$this->AdValid;
		$AdId				=$this->AdId;
		$UserEmail			=$this->UserEmail;
		$UserPass			=$this->UserPass;
		$UserName			=$this->UserName;
		
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		$priv_header_title=$this->priv_header_title;
		$priv_welcome_message=$this->priv_welcome_message;
		$priv_welcome_message2=$this->priv_welcome_message2;
			
		require $this->sec_html_files.'pageHeaderPrivate.html';
		require $this->html_files.'pageMemberMenu.html';
		require $this->html_files.'pageBodyPrivate.html';
		
		//The routine LoadCatArray.php will select all catagories from the Catagory table and format them for loading into the $options array.
		require_once $this->php_files.'LoadCatArray.php';
		
		// Validation of required fields.
		if(empty($AdCategory) or empty($AdPeriod) or empty($AdCaption) or empty($AdHeadline) or empty($AdDesc)) {

			$msg1 = "Please provide required '*' ";
			$msg2 = "fields, and resubmit request\n";
			require $this->sec_html_files.'newAdForm2.html';
			require $this->sec_html_files.'pageFooterPrivate.html';
			self::show_form($AdCategory,$AdPeriod,$AdCaption,$AdHeadline,$AdURL,$AdDesc);
			
		} else {
			
			try {
				require_once $this->priv_class_files.'db_ad.php';
				
				$obj_ad = new db_ad($data, $ad);
				$result = $obj_ad->create();
				if ($result==0){
					print_r($ad);
					//  On successful update route back to member.html.
					$MsgTitle = $this->_regemailtitle;
					$MsgType = "Thank you, ".$this->UserName.";";
					$Msg1 = "No rows inserted in your request.";
					$Msg2 = "You can continue processing your content via the WorkBench tool.";
					require $this->sec_html_files.'member.html';
					require $this->sec_html_files.'pageFooterPrivate.html';
					exit();
			
				}
			} catch(PDOException $ex) {
				//Something went wrong rollback!
				//$db->rollBack();
				// echo $ex;
				$MsgTitle = $this->_regemailtitle;
				$MsgType = "Thank you, ".$this->UserName.";";
				$Msg1 = "PDO call to db_ad::create() failed with error:";
				$Msg2 = $ex;
				require $this->sec_html_files.'member.html';
				require $this->sec_html_files.'pageFooterPrivate.html';
				exit();
			}
				
			// echo($NoUpload);
			// You got here cause you are posting content and chose to upload image now
			// When AdNoUpload == image you need to insert Image for the Ad(Content) inserted
			// above.
			if ($AdNoUpload == "image") {
				//print_r($AdNoUpload);
				//print_r($this->tmpName);
				// Successful insert of AD row and message to the 3d and final page to upload image (optional since AD has been inserted)
				$fileAdId = $result;
					
				$image = array();
				$image['iFileID']		=0;
				$image['iFileAdId']		=$fileAdId;
				$image['vchFileName']	=$this->fileName;
				$image['vchFileType']	=$this->fileType;
				$image['iFileSize']		=$this->fileSize;
				$image['bFileContent']	=fopen($this->tmpName, 'rb');
						
				// Insert image into table.
				try {
					require_once $this->priv_class_files.'db_image.php';
						
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
				// This ActivateAdEmail script can be converted into function within this 
				// Class.
				require $this->sec_php_files.'ActivateAdEmail.php';
				
				$msg1 = "Thank you, ".$this->UserName.", you have completed posting content and image";
				$msg2 = " in posting your add ".$fileAdId." as your Classified Category.\n";
				require $this->sec_html_files.'newAdForm2.html';
				require $this->sec_html_files.'pageFooterPrivate.html';
				self::show_form($AdCategory,$AdPeriod,$AdCaption,$AdHeadline,$AdURL,$AdDesc);
				exit();
				
			} else {
				
				// Implement private header html code to produce page container
				// Followup with custom menu for the member view
				//include $this->sec_html_files.'pageHeaderPrivate.html';
				//include $this->html_files.'pageMemberMenu.html';
			
				//  User chose to upload an image at a later time.
				$msg1 = "Thank you, $this->UserName, you have stored content in your workbench";
				$msg2 = " you can upload an image now or at a later time from the Content menu bar.";
				//include $this->sec_html_files.'newAdMsg.html';
				require $this->sec_html_files.'newAdForm2.html';
				require $this->sec_html_files.'pageFooterPrivate.html';
				self::show_form($AdCategory,$AdPeriod,$AdCaption,$AdHeadline,$AdURL,$AdDesc);
//				include $this->sec_html_files.'pageFooterPrivate.html';
				exit();
			}
				
		}
				
	}
		
	/*
	 *
	 * method to display empty content form to allow data input.
	 *
	 */
	function display_content_form(){
		
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		$priv_header_title=$this->priv_header_title;
		$priv_welcome_message=$this->priv_welcome_message;
		$priv_welcome_message2=$this->priv_welcome_message2;
		
		// Make sure that you redirect to NewAdForm2 in case you came from NewAd and skipped NewAdForm.
		$redirect = "NewAdForm2.php";
		
		//The routine LoadCatArray.php will select all catagories from the Catagory table and format them for loading into the $options array.
		require $this->php_files.'LoadCatArray.php';
			
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		require $this->sec_html_files.'pageHeaderPrivate.html';
		//require $this->sec_html_files.'pageHeaderPrivMenu2.html';
		require $this->html_files.'pageMemberMenu.html';
		require $this->html_files.'pageBodyPrivate.html';
		
		// echo('Category: '.$AdCategory);
		$MsgType = "Information";
		$msg1 = "Welcome to the ".$this->_regemailtitle." app ".$this->UserName."";
		$msg2 = "To post your content please select the details below.";
		require $this->sec_html_files.'newAdForm2.html';
		require $this->sec_html_files.'pageFooterPrivate.html';
		self::show_form();
	}
	
	// Function used for validity of fields and re-display on return so that user does not need to re-enter data.
	function show_form($AdId=""
					,$AdCategory=""
					,$AdPeriod=""
					,$AdCaption= ""
					,$AdHeadline=""
					,$AdURL=""
					,$AdDesc=""
					,$AdNoUpload=""
					,$AdValid="")
	{
		global $options;
	}
	/*
	 *
	 * method to delete content (Ad table) from workbench via MyAdDelete.php.
	 *
	 */
	function delete_content(){
		
		// Implement private header html code to produce page container
		// Followup with custom menu for the member view
		$priv_header_title=$this->priv_header_title;
		$priv_welcome_message=$this->priv_welcome_message;
		$priv_welcome_message2=$this->priv_welcome_message2;
		
		require_once $this->priv_class_files.'db_ad.php';
		require_once $this->priv_class_files.'db_workbench.php';
		
		if ($this->_deltype == "Ad") {
			// Delete Ad row from table-3.
			$ad = array();
			$ad['AdId'] = $this->AdId;
			
			try {
				$obj_ad = new db_ad($data, $ad);
				$result = $obj_ad->delete();
				if ($result==0){
					// print_r($ad);
					//  If we got here we could not find and Ad for the user trying to upload image
					//  Gives error if we cannot find the latest AD from user.
					$MsgTitle = "MyAdDelete";
					$redirect = "MyAdDelete.php";
					$MsgType = "MyAdDelete.php Message:";
					$Msg1 = "Unable to delete AD for this Id:".$this->AdId;
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
				
			// Implement private header html code to produce page container
			// Followup with custom menu for the member view
			include $this->sec_html_files.'pageHeaderPrivate.html';
			include $this->html_files.'pageMemberMenu.html';
		
			$MsgTitle = $regemailtitle;
			$MsgType = "Thank you, $UserName";
			$Msg1 = "Your $priv_content_desc #$adid and all images were deleted successfully.";
			$Msg2= "To View and/or Post new $priv_content_desc or Update your Profile click on the link below.";
			include $this->sec_html_files.'member.html';
			include $this->sec_html_files.'pageFooterPrivate.html';
			exit();
		} else {
			// Delete Image row from table-4.
			if(empty($this->_imageid)){
				// Implement private header html code to produce page container
				// Followup with custom menu for the member view
				include $this->sec_html_files.'pageHeaderPrivate.html';
				include $this->html_files.'pageMemberMenu.html';
		
				$MsgTitle = $regemailtitle;
				$MsgType = "Thank you, $UserName";
				$Msg1 = "There is no image to delete here! Please review your action";
				$Msg2= "To View and/or Post new $priv_content_desc or Update your Profile click on the link below.";
				include $this->sec_html_files.'member.html';
				include $this->sec_html_files.'pageFooterPrivate.html';
				exit();
			}
			try {
				$ad = array();
				$ad['AdId'] = $this->AdId;
				$ad['imageid'] = $this->_imageid;
				
				$obj_WB = new db_workbench($data);
				$result = $obj_WB->delete_ad_image($ad);
				
				if ($result==0){
					// print_r($ad);
					//  If we got here we could not find and Ad for the user trying to upload image
					//  Gives error if we cannot find the latest AD from user.
					//print_r($ad);
					$MsgTitle = "MyAdDelete";
					$redirect = "MyAdDelete.php";
					$MsgType = "MyAdDelete.php Message:";
					$Msg1 = "Unable to delete AD for this Id:".$this->AdId;
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
			// Implement private header html code to produce page container
			// Followup with custom menu for the member view
			include $this->sec_html_files.'pageHeaderPrivate.html';
			include $this->html_files.'pageMemberMenu.html';
		
			$MsgTitle = $regemailtitle;
			$MsgType = "Thank you $this->UserName";
			$Msg1 = "Your image Id #$this->_imageid was deleted successfully.";
			$Msg2= "To View and/or Post new $this->_priv_content_desc or Update your Profile click on the link below.";
			require $this->sec_html_files.'member.html';
			require $this->sec_html_files.'pageFooterPrivate.html';
			exit();
		
		}
		
	}
	
}
