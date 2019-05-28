<?php
/*
 *   Class errHandler contains function
 */

class errHandler {
	#  *************************************************** #
	#  **************** ERROR MANAGEMENT ***************** #
	
	// Create the error handler:
	function myErrorHandler($e_number, $e_message, $e_file, $e_line) {
	
		global $debug, $developer_email, $php_files, $html_files;
	    
	    if (!(error_reporting() & $e_number)) {
        // This error code is not included in error_reporting
        return;
        }
        
		switch ($e_number) {
			case E_USER_ERROR:
				$message = "<b>My ERROR</b> [$e_number] $e_message<br />\n";
				$message .= "  Fatal error on line $e_line in file $e_file";
				$message .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
				$message .= "Aborting...<br />\n";
//				exit(1);
				break;
		
			case E_USER_WARNING:
				echo "<b>My WARNING</b> [$e_number] $e_message<br />\n";
				break;
		
			case E_USER_NOTICE:
				echo "<b>My NOTICE</b> [$e_number] $e_message<br />\n";
				break;
		
			default:
				echo "Unknown error type: [$e_number] $e_message<br />\n";
				break;
		}	
		//  Build the error message:
		// $message = 'An error: '.$e_number.', occured in the script '.$e_file.' on line '.$e_line.': '.$e_message;
	
		//  Append $e_vars to the $message:
		//$message .= print_r($e_vars, 1);
	
		if ($debug) {  
			// Show the error
			//echo '<div class="error">'.$message.'</div>';
   			//debug_print_backtrace();
            $_GET['err'] = $message;
			
		} else {
	
			//  Log the error:
			error_log($message, 1, $developer_email);  // Send mail
	
			//  Only print an error message if the error isn't a notice or strict.
			if (($e_number != E_NOTICE) && ($e_number < 2048)) {
				echo '<div class="error">A system error occurred.  We apologize for the inconvenience.</div>';
	
			}
	
		} // End of $debug IF.
		
		/* Don't execute PHP internal error handler */
		return true;
		
	}  // End of my_error_handler() definition.
}
// set to the user defined error handler
//$old_error_handler = set_error_handler("myErrorHandler");

//  Use my error handler:
//set_error_handler(array("errHandler","myErrorHandler"),E_ERROR);
//set_error_handler("errHandler", E_ALL);
//$err = new errHandler();
//$err->myErrorHandler($e_number, $e_message, $e_file, $e_line, $e_vars);
$err = new errHandler();
$err->myErrorHandler($e_number, $e_message, $e_file, $e_line);

#  **************** ERROR MANAGEMENT ***************** #
#  *************************************************** #
