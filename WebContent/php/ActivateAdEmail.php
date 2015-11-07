<?php

// includes to use PEAR mime functionality
include 'Mail.php';
include 'Mail/mime.php';
include('Mail/mail.php');     // adds the enhanced send function

//set the text variable
$text = "Dear ".$first." ".$last."
You have successfully stored a personal AD at ".$regemailtitle."
To activate your add, please click on the link provided or copy/paste the link below into your browser URL window. 

	http://www.playaloscabos.com/ClassAds/php/ActivateAd.php?email=".$AdUserEmail." ";

// set the html variable
$html = "<html><body><h2>Welcome to the ".$regemailtitle."! </h2>
<h2>Welcome to '$regemailtitle'</h2>
<p>Dear ".$first." ".$last."</p>
<p>You have successfully stored a personal AD at ".$regemailtitle."<br>
To activate your add and make it visible in '.$regemailtitle.' public area, please click on the link provided or copy/paste the link below into your browser URL window.</p>

<b><a href=www.bolitech.com/~bolitest/ClassAds/php/ActivateAd.php?email=".$AdUserEmail.">Activate Your Latest Ad</a></b></p> 
</p></body></html>";

// set file (not currently used)
//$file = '/home/bolitech/example.php';

// set crlf
$crlf = "\r\n";

//define the receiver of the email
$to = $AdUserEmail;

//define the subject of the email
$subject = 'Ad Activation Link';

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

$mail =& Mail::factory('mail','-f '.$regemailaddr);
$mail->send($to, $hdrs, $body);
?>