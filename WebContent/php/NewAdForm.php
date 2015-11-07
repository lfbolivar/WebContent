<?
function show_form($first="", $last="", $addr1= "",$addr2= "",$addr3= "",$city= "", $state="",$phone="",$country= "",$citystphone="",$zip="",
$email="",$password="",$AdCategory="", $AdPeriod="", $AdCaption= "", $AdHeadline="",$AdURL="",$AdDesc="")
{
}
if(isset($_SESSION['ClassAdsEmail']))
{
	if (!isset($first))
	{
		$msg1 = "Welcome to ".$regemailtitle." ".$email.",";
		$msg2 = "To post an Ad please tell us more about yourself.";
		include $html_files.'newAdForm.html';
		show_form();
	}
	else
	{
		if(empty($first) or empty($last) or empty($email) or empty($password))
		{
			$msg1 = "Please provide required '*' ";
			$msg2 = "fields, and resubmit request\n";
			include $html_files.'newAdForm.html';
			show_form($first,$last,$city,$state,$phone,$citystphone,$zip,$email,$password);
		}
		else
		{
			if(!mysql_db_query($db_name,"insert into ".$tbl_name2." values
				(0,'$email','$first','$last','$addr1','$addr2','$addr3','$city','$state','$phone','$password','',0,'$country',$citystphone,'$zip','','','','','','')")) 
			{
				if (mysql_errno() == 1062)
				{
					echo mysql_errno().": duplicate key error returned from MySQL";
				}
				else
				{
					echo mysql_errno().": error returned from MySQL";
				}
			}
			else
			{
				$msg1 = "Thank you, $first $last, you have completed the first of three steps";
				$msg2 = " in publishing your add with Playa Los Cabos.\n";
				include $php_files.'NewAdForm2.php';
				exit();
			}
		}
	}
}
else
{
	//if the cookie does not exist, they are taken to the login screen
	//header("Location: Login.php");
	//echo ('Session does not exist: '.$_SESSION['ClassAdsEmail'].' PASS: '.$_SESSION['ClassAdsPassword'].'');
	$MsgTitle = "MEMBER";
	$redirect = "Logout.php";
	$MsgType = "Member.php Warning:";
	$Msg1 = "User name and password sesssion lost";
	$Msg2= "Please re-establish credentials with Login.";
	$button = "Login";
	include $html_files.'loginMsg.html';
	unset($_POST['submit']);
	exit();
}
?>