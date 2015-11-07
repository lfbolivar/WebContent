<?php
//  Start of headerPrivStyle.php   //
//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

/*** set the content type header ***/
/*** Without this header, it wont work ***/
header("Content-type:text/css");
//<style type="text/css">
?>
<!-- ********************* -->
<!-- Inline Menu Section   -->
<!-- ********************* -->
<!-- this first file csshover.htc is used in IE to fix hover over functionality 
colors	#000080=dark blue
		#F1F1F9=medium gray
		#0000FF=bright blue
		#e6fdc9=lime green
		#660066=magenta
		#ff3300=bright red -->
<!-- ********************** Page Template section ********************* -->
<!-- ******************** Private Gallery image settings  ********************* -->
body{
	background-image:url('<?=$priv_myAd_bg_image?>');	
	color:#660066;
	font-size:100%;
	margin-right:80px;
	margin-left:80px; 	
	clear:both;
<!--  background-color:#FFFFFF;  -->	
	behavior:url(csshover.htc);
}
div.container{
	background-color:<?=$priv_container_color?>; 
	width:80%;
	margin-left:10%;
<!--  border:1px <?=$pub_container_color?>; -->	
	line-height:150%;
}
div.header, div.footer{
	padding:0.2em;
	color:white;
	background-color:<?=$priv_header_color?>;
	font-family:<?=$priv_header_font?>;
	clear:left;
	text-align:center;
}
div.header h1{
	padding:0;
	margin:0;
}
div.content{
	margin-left:250px;
	margin-top:10px;
	padding-left:5em;
	font-family:<?=$priv_header_font?>;
	float:left;
	position:relative;
	top:-130px;
/* <!-- border-left:1px<?=$pub_container_color?>;   --> */		
}
div.content h2{
	color:#660066;
	width:100%;
	margin:10px;
}
div.content2{
	margin-left:270px;
	margin-top:10px;
	position:relative;
	float:left;
	top:70px;
	padding:1em;
	font-family:<?=$pub_header_font?>;
	top:-130px;
}
div.content2 h3{
	color:red
	}
<!-- ******************** Left  Menu pane     ********************* -->
<!-- ******************** Left  Menu pane     ********************* -->
<!-- ******************** block Menu Section  ********************* -->
div.left{
	background-color:#F1F1F9;
	display:block;
	border-right:1px white;	
	float:left;
	width:250px;
	height:100%;
	margin:0;	
	padding:1em;
	font-family:<?=$priv_header_font?>;
	background-color:#F1F1F9;
}
div.left p {
	padding:0;
	margin:10px;
	width:250px;
	font-family:<?=$priv_header_font?>;
	color: #660066;
}
div.left ul{
	position:fixed;
	height:100%;
	border-right:"1px white";	
	float:left;
	width:25%;
	padding-left:1em;
	margin:0;
	list-style-type:none;
<!-- background-color:<?//php echo $priv_menu_color ?>; -->
}
div.left li {
 	display:block; 	
	float:left;
	margin:0;
	width:250px;
	padding:0;
	color:#660066;
}
div.left a{
	float:left;
	width:8em;
	text-decoration:none;
	color:white;
	background-color:<?=$priv_header_color?>;
	padding:0.2em 0.6em;
	border-bottom:1px solid white; 
	font-family:<?=$priv_header_font?>;
}
div.left a:link{
	background-color:<?=$priv_header_color?>;
	color:white;
}
div.left a:visited{
	color:white;
}
div.left a:hover {
	background-color:#ff3300;
}
div.left a:active{
	color:white;
}
div.url{
	margin-left:0px;
<!-- padding:1em; --> 
	font-family:<?=$priv_header_font?>;
}
div.url a{
	background-color:#F1F1F9;
	border-right:1px #F1F1F9;
	float:none;
<!-- 	width:6em; -->  
	text-decoration:none;
	color:blue;
	font-family:<?=$priv_header_font?>;
}
div.url a:hover{
	background-color:purple;
	color:white;
}

<!-- ******************** Table settings for MyGallery.php and My  ***********  -->
table {
	background-color: #F1F1F9;
	color:white;
	width:700px;
	cellpadding: 0;
}
th {
	background-color: #660066;
	color: white;
}
td.a {
	background-color: #000080;
	border-color:#F1F1F9;
	width:100%;
	colspan:2;
	text-align: center;
	font-size: 100%;
	font: 15px arial, helvetica;
	vertical-align: middle;
}
td.b {
	background-color: #F1F1F9;
	border-color: #660066;
	color: #660066;
	font-size: 100%;
	font: 15px arial, helvetica
}

td.c {
	background-color: #660066;
	color: white;
	font: 10px calibri, arial, helvetica
}
td.e {
	background-color:white;
	color:purple;
	font:15px calibri, arial, helvetica;
	width:100%;
	text-align:center;
}
<!--********************* --><!--Image Gallery section --><!--*********************  -->
div.img{
	margin:2px;
<!--  /*	border:1px solid #0000ff;  */ -->
	height:<?=THMBHEIGHT?>px;
<!--  /*	height:156px; 
	auto; px;<?php echo (THMBHEIGHT) ?>*/  -->
	width:<?=THMBWIDTH?>px;
<!--  /*	auto; px;<?php echo (THMBWIDTH) ?> float : left;*/  -->
	text-align:center;
<!--  /*	clear: both; */  -->
}
div.img img{
	text-align:center;
	display:inline;
	margin:3px;
<!--   /*	border:2px solid #ffffff; */  -->
}
div.img input:hover{
	border:2px solid #0000ff;
	background-color:#ff3300;
}
div.desc{
	text-align:center;
	font-weight:normal;
<!--  /*	width:<? echo(THMBWIDTH-2) ?> px; 160 px;*/  -->
	margin: 1px;
}
div.hide{
	display:none;
}
<!-- /** modal window styles for User Logon  **/   -->
#lean_overlay{
    position:fixed;
    z-index:100;
    top:0px;
    left:0px;
    height:100%;
    width:100%;
    background: #000;
    display:none;
}
#loginmodal{
  width:300px;
  padding:15px 20px;
  background:#f3f6fa;
  -webkit-border-radius:6px;
  -moz-border-radius:6px;
  border-radius:6px;
  -webkit-box-shadow:0 1px 5px rgba(0, 0, 0, 0.5);
  -moz-box-shadow:0 1px 5px rgba(0, 0, 0, 0.5);
  box-shadow:0 1px 5px rgba(0, 0, 0, 0.5);
}
#loginform { /* no default styles */ 
}
#loginform label{
	display:block;
	font-size:1.1em; 
	font-weight:bold; 
	color:#7c8291; 
	margin-bottom:3px;
}
.txtfield{ 
  display:block;
  width:100%;
  padding:6px 5px;
  margin-bottom:15px;
  font-family:'Helvetica Neue', Helvetica, Verdana, sans-serif;
  color:#7988a3;
  font-size:1.4em;
  text-shadow:1px 1px 0 rgba(255, 255, 255, 0.8);
  background-color:#fff;
  background-image:-webkit-gradient(linear, left top, left bottom, from(#edf3f9), to(#fff));
  background-image:-webkit-linear-gradient(top, #edf3f9, #fff);
  background-image:-moz-linear-gradient(top, #edf3f9, #fff);
  background-image:-ms-linear-gradient(top, #edf3f9, #fff);
  background-image:-o-linear-gradient(top, #edf3f9, #fff);
  background-image:linear-gradient(top, #edf3f9, #fff);
  border:1px solid;
  border-color:#abbce8 #c3cae0 #b9c8ef;
  -webkit-border-radius:4px;
  -moz-border-radius:4px;
  border-radius:4px;
  -webkit-box-shadow:inset 0 1px 2px rgba(0, 0, 0, 0.25), 0 1px rgba(255, 255, 255, 0.4);
  -moz-box-shadow:inset 0 1px 2px rgba(0, 0, 0, 0.25), 0 1px rgba(255, 255, 255, 0.4);
  box-shadow:inset 0 1px 2px rgba(0, 0, 0, 0.25), 0 1px rgba(255, 255, 255, 0.4);
  -webkit-transition:all 0.25s linear;
  -moz-transition:all 0.25s linear;
  transition:all 0.25s linear;
}
.txtfield:focus{
  outline:none;
  color:#525864;
  border-color:#84c0ee;
  -webkit-box-shadow:inset 0 1px 2px rgba(0, 0, 0, 0.15), 0 0 7px #96c7ec;
  -moz-box-shadow:inset 0 1px 2px rgba(0, 0, 0, 0.15), 0 0 7px #96c7ec;
  box-shadow:inset 0 1px 2px rgba(0, 0, 0, 0.15), 0 0 7px #96c7ec;
}
<!-- End of headerPrivStyle.php -->