<?php
/**
*@author  XuDing
*@email   hello@startutorial.com
*@website http://www.startutorial.com
**/
//process only if data is posted
if(isset($_REQUEST['content'])){
	//capture from the form
	$size          = $_REQUEST['size'];
	$content 	   = $_REQUEST['content'];
	$correction    = strtoupper($_REQUEST['correction']);
	$encoding      = $_REQUEST['encoding'];
	
	//form google chart api link
	$rootUrl = "https://chart.googleapis.com/chart?cht=qr&chs=$size&chl=$content&choe=$encoding&chld=$correction";
	
	//print out the image
	echo '<img src="'.$rootUrl.'">';
}
?>