<?php
/*
 * Created: 07/30/2017
 * Author:  LF Bolivar
 *
 * Class message
 *
 * The class contains basic (min) attributes related to the application Ad table
 * - __construct()
 *
 * The class contains x methods:
 * - display_message()
 */

class Message {

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

	/*
	 *
	 * constructor to initialize variables.
	 *
	 *
	 */
	function __construct($msg){
	
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
		$this->_regemailtitle			= $objConfig->get('regemailtitle');
		$this->_regemailaddr			= $objConfig->get('regemailaddr');
		$this->_localregion				= $objConfig->get('localregion');
	
		$this->AdId			=$ad['AdId'];
	}
	function display_message(){

	}
}