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
 */

class Content {

	public $priv_class_files		= NULL;
	public $sec_html_files			= NULL;
	public $html_files				= NULL;
	public $php_files				= NULL;
	public $pub_header_title		= NULL;
	public $pub_welcome_message		= NULL;
	public $pub_welcome_message2	= NULL;
	public $priv_header_title		= NULL;
	public $priv_welcome_message	= NULL;
	public $priv_welcome_message2	= NULL;
	public $modal					= NULL;
	public $options					= NULL;
		
	/*
	 *
	 * constructor to initialize variables.
	 *
	 *
	 */
	function __construct(){
		
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
	
	
	}
	
	/*
	 *
	 * method to update Ad table.
	 *
	 */
	function update_content($ad){
		
		$AdId		=$ad['AdId'];
		$AdCategory	=$ad['AdCatId'];
		$AdPeriod	=$ad['AdPeriod'];
		$AdCaption	=$ad['AdCaption'];
		$AdHeadline	=$ad['AdHeadline'];
		$AdNoUpload =$ad['AdNoUpload'];
		$AdDesc		=$ad['AdDesc'];
		$AdURL		=$ad['AdURL'];
		$AdUserId	=$ad['AdUserId'];
		$AdValid	=$ad['AdValid'];
		$AdExpireDate=$ad['AdExpireDate'];
		$UserEmail	=$ad['UserEmail'];
		$UserPass	=$ad['UserPass'];
		$UserName	=$ad['UserName'];
		require_once $this->priv_class_files.'db_ad.php';
		
		$data['AdCaption']=$AdCaption;
		$data['AdHeadline']=$AdHeadline;
		$data['AdDesc']=$AdDesc;
		$data['AdURL']=$AdURL;
		$data['AdExpireDate']=$AdExpireDate;
		$data['AdPeriod']=$AdPeriod;
		$data['AdCatId']=$AdCategory;
		$data['AdValid']=$AdValid;
		$data['AdId']=$AdId;
		
		$data['UserEmail']=$UserEmail;
		$data['UserPassword']=$UserPass;
		$data['UserName']=$UserName;
				
		// Validation of required fields.
		if(empty($AdCategory) or empty($AdPeriod) or empty($AdCaption) or empty($AdHeadline) or empty($AdDesc)){
			$msg1 = "Please provide required '*' ";
			$msg2 = "fields, and resubmit request\n";
			include $this->html_files.'mydetails.html';
			include $this->sec_html_files.'pageFooterPrivate.html';
			self::show_form3($AdId,$AdCategory,$AdPeriod,$AdCaption,$AdHeadline,$AdURL,$AdDesc,$AdValid);
		} else {
				
			try {
				$obj_ad = new db_ad($data, $ad);
				$result = $obj_ad->update();
				if ($result==0){
					print_r($ad);
				}
			} catch(PDOException $ex) {
				//Something went wrong rollback!
				//$db->rollBack();
				echo $ex;
			}
			// Implement private header html code to produce page container
			// Followup with custom menu for the member view
			$priv_header_title=$this->priv_header_title;
			$priv_welcome_message=$this->priv_welcome_message;
			$priv_welcome_message2=$this->priv_welcome_message2;
				
			include $this->sec_html_files.'pageHeaderPrivate.html';
			include $this->html_files.'pageMemberMenu.html';
			
			//The routine LoadCatArray.php will select all catagories from the Catagory table and format them for loading into the $options array.
			require_once $this->php_files.'LoadCatArray.php';
			
			// echo('Category: '.$AdCategory.' Adperiod: '.$AdPeriod.' AdCaption: '.$AdCaption.' AdHeadline: '.$AdHeadline.' AdDesc: '.$AdDesc.'\n');
			/*			mysqli_query($link,"update ".$tbl_name3." set vchAdCaption = '$AdCaption'
			 ,vchAdHeadLine = '$AdHeadline',vchAdDesc = '$AdDesc', vchAdURL = '$AdURL', dtAdExpireDate = '$AdExpireDate'
			 ,iAdPeriod = '$di',vchUserEmail = '$AdUserEmail', vchUserPassword = '$AdUserPassword'
			 ,vchAdUserName = '$AdUserName', iAdCatId = '$AdCategory', tiAdValid = '$nAdValid'
			 WHERE iAdId = '$AdId'")
			or die('-MyAdUpdate.php (Update Ad Table)- '.mysqli_error().'');
			*/
			//  On successful update route back to member.html.
			$MsgTitle = $regemailtitle;
			$MsgType = "Thank you, ".$logonName.";";
			$Msg1 = "You have successfully updated your web content and extended your expiration";
			$Msg2 = "If you chose to activate your content it will now be visible in the Public Gallery.";
			include $this->sec_html_files.'member.html';
			include $this->sec_html_files.'pageFooterPrivate.html';
			exit();
		}
	}
	
	// Function used for validity of fields and re-display on return so that user does not need to re-enter data.
	function show_form3($AdId="",$AdCategory="", $AdPeriod="", $AdCaption= "", $AdHeadline="",$AdURL="",$AdDesc="", $AdNoUpload="", $AdValid="")
	{
		global $options;
	}
	
}
