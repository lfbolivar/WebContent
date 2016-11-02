<?php
#######################################################
/*
 *  File Name: Config.php
 *  Created by: LF Bolivar
 *  Contact: lfbolivar@bolitec.org, bolitec.org
 *  Last Modified: Aug 30 2016
 *  
 *  
 *  This page defines a Config class which uses Singleton Pattern:
 *  - Has site settings in one location
 *  - Stores URLs and URIs as constants
 *  - Advanced configuration and security options 
 *  
 *  The setConfig class.
 *  Class contains two attributes: $_instance and $_settings.
 *  Class contains four methods:
 *  - __contruct()
 *  - getInstance()
 *  - set()
 *  - get()
 *
 */
#########################################################
class Config {
#  *************************************************** #
#  ***************   Class Config   ****************** #
#  *************************************************** #

	// Store a single instance of this class:
	static private $_instance = NULL;
	
	//  Store settings:
	private $_settings = array();
	
	//  Private methods cannot be called:
	private function __construct() {}
	private function __clone() {}
	
	//  Method for returning the instance:
	static function getInstance() {
		if (self::$_instance == NULL) {
			self::$_instance = new Config();
		}
		return self::$_instance;
	}
	
	//  Method for defining a setting -> settings:
	function set($index, $value) {
		$this->_settings[$index] = $value;
	}
	
	// Method for retrieving a setting:
	function get($index) {
		return $this->_settings[$index];
	}
}  // End of setConfig Class definition.
?>