<HTML>
<HEAD>
<TITLE>New Ad Form</TITLE>
</HEAD>
<body BACKGROUND="images/loscabosmap.jpg" BGCOLOR="#FFFFFF"
	TEXT="#66066" LINK="#000080" VLINK="#000080" alink="#0000FF">
<center><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
	codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0"
	width="448" height="104" id="banner" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="movie" value="banner.swf" />
	<param name="quality" value="high" />
	<param name="bgcolor" value="#ffffff" />
	<embed src="banner.swf" quality="high" bgcolor="#ffffff" width="448"
		height="104" name="banner" align="middle"
		allowScriptAccess="sameDomain" type="application/x-shockwave-flash"
		pluginspage="http://www.macromedia.com/go/getflashplayer" /> </object><br>
<br>

<!-- *******************************************************************************-->
<!-- *** This is outer table defines dimensions for inner table                     -->
<!-- *******************************************************************************-->
<table width="600" cellspacing="3" border="1">
	<tr>
		<td bgcolor="#F1F1F9"><font color="#660066" FACE="arial,helvetica"
			size="2">
		<H1>
		<center>Los Cabos Classifieds</center>
		</H1>

		<table width="100%" bgcolor="#660066" cellpadding="0" border="0"
			colspan="0" cellspacing="0">
			<tr>
				<td bgcolor="#F1F1F9" align="center"><font FACE="arial,helvetica">
				<form><input type="button" name=submit
					value="AD Posting Rules & Hints"
					onClick="window.open('pophelp/postad.html','Photoimage','width=350,height=350,scrollbars=yes,left=100,top=80,screenX=100,screenY=100');return false"></form></td>
			</tr>
		</table>


		<?
		function show_form($first="", $last="", $city= "", $state="",$phone="",$citystphone="",
		$email="",$password="",$adcategory=""){
			$options = array("Boats & Accessories","Slips & Moorings","Water Sports",
                  "Travel","Shopping","Cottage/House Rentals","Hotels",
                  "Real Estate","Restaurants"); 


			?>
		<FORM ACTION="NewAdForm.php" METHOD="POST"><!-- *******************************************************************************-->
		<!-- *** This is STEP-1 section of the table where the form captures category info  -->
		<!-- *******************************************************************************-->
		<table width="100%" bgcolor="#660066" cellpadding="0" border="0"
			colspan="0" cellspacing="0">
			<tr>
				<td><font face="arial,helvetica" size="2" color="WHITE"><b> STEP-1
				Please provide your contact information... </font></td>
				</b>
				<td><small><font face="Arial,helvetica" color="WHITE" size="1">
				<p align="right">(1 of 3)</small></b></font></td>
			</tr>
			<tr>
				<td bgcolor="#F1F1F9"><font face="arial, helvetica" size="2"><b>
				*First Name: </font></b> <INPUT TYPE=text NAME=first
					VALUE="<?echo $first?>"></td>
				<td bgcolor="#F1F1F9"><font face="arial, helvetica" size="2"><b>
				*Last Name: </font></b> <INPUT TYPE=text NAME=last
					VALUE="<?echo $last?>"></td>
			</tr>
			<tr>
				<td bgcolor="#F1F1F9"><font face="arial,helvetica" size="2"><b> City
				and State:</b></font> <font face="arial,helvetica" size="1"><i>(Displayed
				only if you select "Yes" below)</i></font><br>
				<input type=text name=city size="28" VALUE="<?echo $city?>"> <b>,</b>
				<input type="text" name=state size="1" maxlength="2"
					VALUE="<?echo $state?>"></td>
				<td bgcolor="#F1F1F9"></td>
			</tr>
			<tr>
				<td bgcolor="#F1F1F9"><font face="arial,helvetica" size="2"><b>
				Phone:&nbsp;&nbsp; </b></font> <font face="arial,helvetica" size="1"><i>(Displayed
				only if you select "Yes" below)</i></font><br>
				<input type=text name=phone size="28" VALUE="<?echo $phone?>"></td>
				<td bgcolor="#F1F1F9"></td>
			</tr>
			<tr>
				<td bgcolor="#F1F1F9"><font face="arial,helvetica" size="2"> Do you
				wish to <b>display</b> your <b>City, State, Phone</b> in the <b>AD</b>?</font></td>
				&nbsp;&nbsp;
				<td bgcolor="#F1F1F9"><select name=citystphone size="1"
					VALUE="<?echo $citystphone?>">
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select></td>
			</tr>
			<tr>
				<td bgcolor="#F1F1F9"><font face="arial,helvetica" size="1"><i>Recommend
				"Yes" when selling, leasing, etc.</i></font></td>
				<td bgcolor="#F1F1F9" align="center"></td>
			</tr>
			<tr>
				<td bgcolor="#F1F1F9"><br>
				</td>
				<td bgcolor="#F1F1F9"><br>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F1F1F9"><font face="arial,helvetica" size="2"> <b>*E-Mail
				Address: </b></font><font face="arial,helvetica" size="1"> (<i>"<b>Hidden</b>"
				in AD for privacy </i>)</font><br>
				<input type=text name=email size="40" maxlength="40"
					VALUE="<?echo $email?>"></td>
				<td bgcolor="#F1F1F9"></td>
			</tr>
			<tr>
				<td bgcolor="#F1F1F9"><font face="arial,helvetica" size="2"> <b>*Password:</b>
				<input type="password" name=password size="11" maxlength="10"
					VALUE="<?echo $password?>"> <font face="arial, helvetica" size="1">(<i>10
				characters max </i>)</font></td>
				<td bgcolor="#F1F1F9"></td>
			</tr>
			<tr>
				<td bgcolor="#F1F1F9"><font face="arial, helvetica" size="1"><i> To
				<b>edit</b>, <b>renew</b> or <b>delete</b> your AD later, you will
				need this password<font></i></td>
				<td bgcolor="#F1F1F9"></td>
			</tr>
			<tr>
				<td bgcolor="#F1F1F9"><br>
				</td>
				<td bgcolor="#F1F1F9"><br>
				</td>
			</tr>
			<tr>
				<td bgcolor="#F1F1F9"><font face="arial, helvetica" size="2"
					color="#660066"> <b>Classified Category: </font></b> <SELECT
					NAME=adcategory size="1" VALUE="<?echo $adcategory?>">
					<? foreach($options as $category){
						/*	echo "<OPTION";*/
						if ($adcategory==$category) {
							echo "<option SELECTED>$category</option>/n" ;
							/*	next($adcategory);
							 }*/
						}else{ echo "<option> $category</option>/n";
						}
					}
					?>
				</SELECT></td>
				<td bgcolor="#F1F1F9"><font color="#F1F1F9"></td>
			</tr>
		</table></td>
	</tr>
</table>
</tr>
</table>
<br>
<INPUT TYPE=submit>
</FORM>

					<?
		}
		if (!isset($first)) {
			show_form();
		}
		elseif(empty($first) or empty($last) or empty($email) or empty($password) or empty($adcategory)) {
			?>
<center>
<h4><?
echo "Please provide required '*' ";
echo "fields, and resubmit request\n";
?></h4>
</center>
<?
show_form($first,$last,$city,$state,$phone,$citystphone,$email,$password,$adcategory);
		}
		else {
			?>
<center>
<h4><?
mysql_pconnect("localhost","playalos_caUser","sc8G9ES2");
$db = "playalos_ClassAds";
$table = "user";

if(!mysql_db_query($db,"insert into $table values
	('$email',0,'$first','$last','','','','$city','$state','$phone','$password',0,0,'',$citystphone,'','','','','','','')")) {
if (mysql_errno() == 1062){
	echo mysql_errno().": duplicate key error returned from MySQL";}
	else{
		echo mysql_errno().": error returned from MySQL";}
	}
	else{
		echo "Thank you, $first $last, you ";
		echo "have completed the first of three steps in posting your add in ''$adcategory''";
	echo " as your Classified Category.\n";
	}
	}
	?>

</center>
</h4>

</BODY>
</HTML>
