<?php
//  Start of headerPubStyle.php   //
//  Local config allows for dynamic definition of file paths and single point for private paths
include "setConfig.php";

/*** set the content type header ***/
/*** Without this header, it wont work ***/
header("Content-type:text/css");
?>
<!-- /***************************/ -->
<!-- /** Inline Menu Section ****/ -->
<!-- /***************************/ -->
<!-- this first file csshover.htc is used in IE to fix hover over functionality 
colors	#000080=dark blue
		#F1F1F9=medium gray
		#0000FF=bright blue
		#e6fdc9=lime green
		#660066=magenta
		#ff3300=bright red -->
<!-- /********************** Page Master Section Public Gallery        *************/ -->
<!-- /*** Container consists of Header, Left Menu Pane, and Footer         *********/ -->
<!-- /*** Main section of the master template and its primary configurations *******/ -->
body{
	background-image:url('<?=$pub_browseAd_bg_image?>');
	color:black;
	margin-left:20px;
	margin-right:20px;
	background-color:white;
	behavior:url(csshover.htc);
}
div.container{
	background-color:white;
	width:80%;
	margin-left:10%;
	padding:0;
<!-- border:1px <?//=$pub_container_color?>;   -->	
	line-height: 125%;
}
div.header, div.footer{
	padding:0.5em;
	color:<?=$pub_header_type_color?>;
	background-color:<?=$pub_header_color?>;
	font-family:<?=$pub_header_font?>;
	text-align:center;
	clear:left;	
}
div.header h1{
	padding:0;
	margin:0;
}
<!--  /******************** Left block Menu Section  *********************/ -->
<!--  /******************** Left block Menu Section  *********************/ -->
<!--  /******************** Left block Menu Section  *********************/ -->
div.left {
 	display:block; 	
	border-right:1px white;	
	float:left;
	width:250px;
	height:100%;
	margin:0;
	padding-left:1em;
	padding-right:1em;
	font-family:<?=$pub_header_font?>;
	background-color:#F1F1F9;
}
div.left p {
	padding:0;
	margin:10px;
	width:250px;
}
div.left ul{
	position:fixed; 
 	display:block; 	
	height:100%;
	float:left;
	width:5%;
	padding-left:1em;
	margin:0;
	list-style-type:none;
}
div.left li {
 	display:block; 	
	float:left;
	padding:0;
	margin:0;
	width:250px;
}
div.left a{
	float:left;
	width:8em;
	text-decoration:none;
	color:white;
	background-color:<?=$pub_header_color?>;
	border-bottom:1px solid white; 
	font-family:<?=$pub_header_font?>;
	padding:0.2em 0.6em;
<!-- background-color: purple; -->
}
div.left a:link{
	background-color:<?=$pub_header_color?>;
	color:white;
}
div.left a:visited{
	color:white;
	background-color:<?=$pub_header_color?>;
}
div.left a:hover {
	background-color:#ff3300;
}
div.left a:active{
	color:white;
	background-color:<?=$pub_header_color?>;
}
<!--  /******************** Content Section  *********************/ -->
<!--  /******************** Content Section  *********************/ -->
<!--  /******************** Content Section  *********************/ -->
div.content{
	margin-left:260px;
	padding-left:5em;
	font-family:<?=$pub_header_font?>;
	color:#000080;
	float:left;
	position:relative;
	top:-130px;
	width:600px;
	}
div.content h2{
	color:#000080;
	width:300px;
	margin:10px;
}
div.content2{
	margin-left:300px;
	position:relative;
	top:-130px;
	float:left;
	height:30%;
	font-family:<?=$pub_header_font?>;
	width:300px;
}
div.content2 h3{
	color:red;
	width:300px;
}
<!--  /* controls the browsedetails.html page primarily the hover on the <a href> tags. */ -->
<!--  /* Inside the content area for display of content details. */ -->
div.content table{
	background-color:white;
	color:#000080;
	width:auto;
	cellpadding: 0;
	border:0;
	cellspacing:0;
}
div.content td.b{
	color:#660066;
	font-size:100%;
	font:17px <?=$pub_header_font?>;
}
div.content td.b a{
	color:#000080;
	font-size:100%;
	font:15px <?=$pub_header_font?>;
	vertical-align:middle;
 	margin:0;
	float:none;
<!--/* width:6em; */-->
	text-decoration:none;
	text-align:center;
}
div.content td.b a:link{
	background-color:#0000FF;
	color:#F1F1F9;
}
div.content td.b a:visited{
	background-color:#0000FF;
	color:#F1F1F9;
}
div.content td.b a:hover{
	background-color:#ff3300;
}
div.content td.b a:active{
	background-color:#0000FF;
	color:#F1F1F9;
}
div.content td.c {
	background-color:#660066;
	color: white;
	font:10px <?=$pub_header_font?>;
	text-align:center;
}
div.content td.d {
	background-color:white;
	color:#660066;
	font:20px <?=$pub_header_font?>;
	text-align:center;
}
div.content td.e {
	background-color:white;
	color:#000080;
	font:15px <?=$pub_header_font?>;
	width:100%;
	text-align:center;	
}
<!--********************* --><!--Image Gallery section --><!--*********************  -->
<!--********************* --><!--Image Gallery section --><!--*********************  -->
<!--********************* --><!--Image Gallery section --><!--*********************  -->
div.img{
	margin:2px;
	height:<?=THMBHEIGHT?>px;
<!-- 	height:156px; 
	height;auto; -->
 	width:<?=THMBWIDTH?>px;
<!--	 width:136px;
	width:auto;-->
<!--  text-align:center; -->	
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
div.img a:hover{
	border:2px solid #0000ff;
	background-color:#ff3300;
}
div.desc{
	text-align:center;	
	font-weight:normal;
	width:<?=THMBWIDTH?>px;
	margin: 1px;
}
div.hide{
	display:none;
}
div.err{
	display:block;
	font-size:1.1em; 
	font-weight:bold; 
	color:#c70039; 
	margin-bottom:3px;
}
/** modal window styles **/
#lean_overlay{
    position:fixed;
    z-index:100;
    top:0px;
    left:0px;
    height:100%;
    width:100%;
    background:#000;
    display:none;
}
#errormodal{
  width:600px;
  padding:15px 20px;
  background:#fdfefe ;
  -webkit-border-radius:6px;
  -moz-border-radius:6px;
  border-radius:6px;
  -webkit-box-shadow:0 1px 5px rgba(0, 0, 0, 0.5);
  -moz-box-shadow:0 1px 5px rgba(0, 0, 0, 0.5);
  box-shadow:0 1px 5px rgba(0, 0, 0, 0.5);
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
#loginform { /* no default styles */ }
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
