<?php
session_start();
function showloginform(){
	include('index.php');
}

$username= $_POST['username'];
$password= $_POST['password'];

if($username && $password){
	$connect= mysql_connect("localhost", "root", "" ) || die("Couldnt't Connect");
	mysql_select_db("myData") || die("Couldn't Find DB");
	
	$query= mysql_query("SELECT * FROM logins WHERE username='$username'");
	
	$numrows= mysql_num_rows($query);
	
	//Checking for number of rows if not = 0 do the stuff
	if($numrows!=0){
		//fetchin the query SELECT.....username
		while($row=mysql_fetch_assoc($query)){
			$dbusername= $row['username'];
			$dbpassword= $row['password'];
			
			$activated= $row['activated'];
			
			if($activated==false){
				die("Your Account is not yet Active. Please Check your Email!");
			}
			
		}
		
		//Check if the password and username match
		if($username==$dbusername && (md5($password)==$dbpassword)){
			$result = mysql_query("SELECT fullname, username, email, date FROM logins WHERE username='$username'");
			if(mysql_num_rows($result) !=0 ){
				while($row = mysql_fetch_assoc($result)){
					$fullname=$row['fullname'];
					$username=$row['username'];
					$email=$row['email'];
					$date=$row['date'];
				}
			}
			$_SESSION['fullname']=$fullname;
			$_SESSION['username']=$username;
			$_SESSION['email']=$email;
			$_SESSION['date']=$date;
			$_SESSION['boolLog']=true;
			header( 'Location: home.php');
		}else{
			showloginform();
			echo '<SCRIPT language="JavaScript">window.alert("Incorrect Password")</script>';
		}
		
	}else{
		showloginform();
		echo '<SCRIPT language="JavaScript">window.alert("Username Does Not Exist")</script>';
	}
}else{
	showloginform();
	echo '<SCRIPT language="JavaScript">window.alert("Please Enter a Username And a Password")</script>';
}

?>

