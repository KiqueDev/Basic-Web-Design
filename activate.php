<?php

$connect= mysql_connect("localhost", "root", "" ) || die("Couldnt't Connect");
mysql_select_db("myData") || die("Couldn't Find DB");

$id= $_GET['id'];
$code= $_GET['code'];

if($id && $code){
	$check= mysql_query("SELECT * FROM logins WHERE id='$id' AND randomnum='$code'");
	$checknum= mysql_num_rows($check);
	
	if($checknum){
		//run a query to activate the account
		$acti= mysql_query("UPDATE logins SET activated='1' WHERE id='$id'");
		die("Your account is activated. You may now log in.");
		
	}else{
		die("Invalid ID or Activation code. Please contact Admin" );
	}

}else{
	die("Data Missing!");
}

?>