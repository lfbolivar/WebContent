<?php

// includes to use PEAR mime functionality
include 'Mail.php';
include 'Mail/mime.php';
include('Mail/mail.php');     // adds the enhanced send function

//set the text variable
$text = 'Welcome to the '.$regemailtitle.'!
You have successfully registered Email:'.$email;

// set the html variable
$html = '<html><body><h2>Welcome to the '.$regemailtitle.'! </h2>
<p>You have successfully registered <b>Email:  '.$email.'. </b></p> 
<font size=2><p>
</p></body></html>';

// set file (not currently used)
//$file = '/home/bolitech/example.php';

// set crlf
$crlf = "\r\n";

//define the receiver of the email
$to = $email;

//define the subject of the email
$subject = 'Registration Confirmation';

// build headers array
$hdrs = array( 'From' => $regemailaddr,
               'Subject' => $subject,
);


$mime = new Mail_mime($crlf);

$mime->setTXTBody($text);
$mime->setHTMLBody($html);
//$mime->addAttachment($file,'text/plain');
 
//do not try to call these lines in reverse order
$body = $mime->get();
$hdrs = $mime->headers($hdrs);

@$mail =& Mail::factory('mail','-f '.$regemailaddr);
@$mail->send($to, $hdrs, $body);
?>