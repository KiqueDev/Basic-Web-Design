<?php

	//connect database
	$connect= mysql_connect("localhost", "root", "" ) || die("Couldnt't Connect");
	mysql_select_db("myData") || die("Couldn't Find DB");
	
	
	$username= mysql_real_escape_string( $_POST['username']);
	$email= mysql_real_escape_string( $_POST['email']);
	
	$checkuser=mysql_query("SELECT username FROM logins WHERE username='$username'");
	$checkemail=mysql_query("SELECT email FROM logins WHERE email='$email'");
	
	$checkuser_num_rows=mysql_num_rows($checkuser);
	$checkemail_num_rows=mysql_num_rows($checkemail);
	
	
	if($checkuser_num_rows){
		echo "UserName Already Exist";
	}
	if($checkemail_num_rows){
		echo "Email Already Exist";
	}
	
	
?>