<?php
/*
 * Created: 7/22/2016
 * Author: LF Bolivar
 *
 * Class Session
 *
 * The class contains basic (min) attributes related to the application session table
 * - __construct()
 *
 * The class contains x methods:
 * - addSession()
 * - readSession()
 * - updSession()
 * - delSession()
 */
/*
 * The session class models the Singleton Pattern class
 */
class Session {

	// Store a single instance of this class:
	// static private $_sessinst = NULL;
	
	private $_sessionEmail = NULL;
	private $_sessionPass  = NULL;
	private $_sessionIP    = NULL;
	private $_sessionName  = NULL;
	private $_sessionVars = array();
	
	private $priv_app_files = NULL;
	
	/*  
 	 * This is the session construct() method
 	 * It will check if set and intiatialize all session variables.
 	 *  
 	 */
	//  Private methods cannot be called:
	public function __construct($data) {

		//  Always start the session first thing
		//  Sets path for files and start session.
		$objConfig = Config::getInstance();
		
		$this->priv_app_files = $objConfig->get('priv_app_files');
		require_once $objConfig->get('PRIVATE_SESSION').'sessionConfig.php';
		
		session_start();
		
		if(isset($data['logonEmail'])) {
			$this->_sessionEmail = $data['logonEmail'];
		}
		if(isset($data['logonPass'])) {
			$this->_sessionPass = $data['logonPass'];
		}
		if(isset($data['logonIP'])) {
			$this->_sessionIP = $data['logonIP'];
		}
		if(isset($data['logonName'])) {
			$this->_sessionName = $data['logonName'];
		}
		
	}
	//	Destruct
	public function __destruct() {
		
		session_write_close();
	}
	//private function __clone() {}
	
	//  Method for returning the instance
	static function getSessinst() {
		if (self::$_sessinst == NULL) {
			self::$_sessinst = new Session();
		}
		return self::$_sessinst;
	}
	
	/*
	 * The addSession() method will start the session
	 * $data is an array that contains variables to store in $_SESSION 
	 */
	function addSession() {
		$_SESSION = array();
		$return_status = FALSE;
		
		if(isset($this->_sessionEmail)) {
			$_SESSION['sessionEmail'] = $this->_sessionEmail;
			$return_status = TRUE;
		} 
		if(isset($this->_sessionPass)) {
			$_SESSION['sessionPass'] = $this->_sessionPass;
			$return_status = TRUE;
		} 
		if(isset($this->_sessionIP)) {
			$_SESSION['sessionIP'] = $this->_sessionIP;
			$return_status = TRUE;
		}
		if(isset($this->_sessionName)) {
			$_SESSION['sessionName'] = $this->_sessionName;
			$return_status = TRUE;
		}
		return $return_status;
	}
	/*
	 * The readSession() method will retrieve session variables
	 */
	function readSession() {
		
		// Then check if session variable was created and currently exists.
		$this->_sessionVars = array();
		$return_status = NULL;
		
		if(isset($_SESSION['sessionEmail'])) {
			$this->_sessionVars['sessionEmail'] = $_SESSION['sessionEmail'];
			$return_status = TRUE;
		}
		if(isset($_SESSION['sessionPass'])) {
			$this->_sessionVars['sessionPass'] = $_SESSION['sessionPass'];
			$return_status = TRUE;
		}
		if(isset($_SESSION['sessionIP'])) {
			$this->_sessionVars['sessionIP'] = $_SESSION['sessionIP'];
			$return_status = TRUE;
		}
		if(isset($_SESSION['sessionName'])) {
			$this->_sessionVars['sessionName'] = $_SESSION['sessionName'];
			$return_status = TRUE;
		}
		if ($return_status == NULL){
			return FALSE;
		} else {
			return $this->_sessionVars;
		}
	}
	/*
	 * The updSession() method will add or change values in session variables
	 * $data is an array that contains variables to update in $_SESSION 
	 */
	function updSession($data) {
		
	}
	/*
	 * The delSession() method will remove a session on timeout or logoff
	 */
	function delSession() {
		$_SESSION = array();
		session_destroy();
		
	}
	
}  // End of session Class
