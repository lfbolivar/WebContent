<?php

// require("photo_cfg.pl");

//receive POST with form values and validate data before inserting it to DB
//Check whether the form has been submitted
if (array_key_exists('check_submit', $_POST)) {
	//Converts the new line characters (\n) in the text area into HTML line breaks (the <br /> tag)
	$_POST['Comments'] = nl2br($_POST['Comments']);
	//Check whether a $_GET['Languages'] is set
	if ( isset($_POST['Departments']) ) {
		$_POST['Departments'] = implode(', ', $_POST['Departments']); //Converts an array into a single string
	}

	//Let's now print out the received values in the browser
	echo "Your name: {$_POST['Name']}<br />";
	echo "Your email: {$_POST['EMail']}<br />";
	echo "Your password: {$_POST['Password']}<br />";
	echo "Your AD period: {$_POST['AdPeriod']}<br /><br />";
	echo "Your City: {$_POST['City']}<br />";
	echo "Your State: {$_POST['State']}<br />";
	echo "Your CityStatePhone Display Code: {$_POST['CityStPhone']}<br />";
	echo "Your Phone: {$_POST['Phone']}<br />";
	echo "Your Web URL: {$_POST['WebURL']}<br />";
	echo "Your Caption: {$_POST['SubText']}<br />";
	echo "Your Subject: {$_POST['Subject']}<br />";
	echo "Your comments:<br />{$_POST['Comments']}<br /><br />";

} else {
	echo "You can't see this page without submitting the form.";
}
?>


<?php
//define the receiver of the email
$to = 'fernando@bolitech.com';
//define the subject of the email
$subject = 'Los Cabos Classifieds Test HTML email';
//create a boundary string. It must be unique
//so we use the MD5 algorithm to generate a random hash
$random_hash = md5(date('r', time()));
//define the headers we want passed. Note that they are separated with \r\n
$headers = "From: webmaster@bolitech.com\r\nReply-To: fernando@bolitech.com";
//add boundary string and mime type specification
$headers .= "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\"";
//define the body of the message.
ob_start(); //Turn on output buffering
?>
--PHP-alt-
<?php echo $random_hash; ?>
Content-Type: text/plain; charset="iso-8859-1"
Content-Transfer-Encoding: 7bit Los Cabos Classifieds !!! This is simple
text email message. --PHP-alt-
<?php echo $random_hash; ?>
Content-Type: text/html; charset="iso-8859-1" Content-Transfer-Encoding:
7bit

<h2>Los Cabos Classifieds</h2>
<p>This is something with <b>HTML</b> formatting.</p>



--PHP-alt-
<?php echo $random_hash; ?>
--
<?
//copy current buffer contents into $message variable and delete current output buffer
$message = ob_get_clean();
//send the email
$mail_sent = @mail( $to, $subject, $message, $headers );
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed"
echo $mail_sent ? "Mail sent" : "Mail failed";
?>




