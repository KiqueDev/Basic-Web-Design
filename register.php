<html>
<head>
<style type="text/css">
#feedback{
	color:#FF0000;
}
#feedback2{
	color:#FF0000;
}
</style>

<h1>Registration</h1>

<!-- The username checking -->
<script type="text/javascript" src="jquery.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$('#feedback').load('check.php').show();
	
	$('#username_input').keyup(function(){
		$.post('check.php', { username: form.username.value },
		function(result) {
			$('#feedback').html(result).show();
		});
		
	});
	$('#feedback2').load('check.php').show();
	
	$('#email_input').keyup(function(){
		$.post('check.php', { email: form.email.value },
		function(result) {
			$('#feedback2').html(result).show();
		});
		
	});
	
});

</script>
</head>
<body>
<form action='register.php' method='POST' name='form' >
	<table>
			<tr>
				<td>
					Full Name: 
				</td>
				<td>
				<input type='text' name='fullname'>
				</td>
			</tr>
			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
			<tr>
				<td>
					UserName: 
				</td>
				<td>
				<input type='text' id="username_input" name='username'>
				</td>
				<td id='feedback'></td>
			</tr>
			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
			<tr>
				<td>
					Email: 
				</td>
				<td>
				<input type='text' id="email_input" name='email'>
				</td>
				<td id='feedback2'></td>
			</tr>
			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
			<tr>
				<td>
					Password: 
				</td>
				<td>
				<input type='password' name='password'>
				</td>
			</tr>
			<tr>
				<td>
					Repeat Password: 
				</td>
				<td>
				<input type='password' name='rpassword'>
				</td>
			</tr>
			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
			<tr>
				<td>
				</td>
				<td align='right'>
				<input type='submit' name='submit' value='Register'>
				</td>
			</tr>
	</table>
</form>
</body>
</html>

<?php

$submit= $_POST['submit'];
$fullname= strip_tags($_POST['fullname']);
$username=  strip_tags($_POST['username']);
$password=  strip_tags($_POST['password']);
$rpassword= strip_tags($_POST['rpassword']);
$date= date("Y-m-d");
$email = $_POST['email'];

if($submit){
	if($fullname && $username && $password && $rpassword){
		//Encrypted password
		$encryptedpassword= md5($password);
		$encryptedrpassword= md5($rpassword);
		
		//Generate random number for activation process
		$random = rand(23456789,98765432);
		
		//check for password
		if($password == $rpassword){
			//check username/fullname length
			if(strlen($username) > 20 || strlen($fullname) > 20){
				echo '<SCRIPT language="JavaScript">window.alert("Max limit for Username/Fullname are 20 characters")</script>';
			}else{
				
				//Open Database
				$connect= mysql_connect("localhost", "root", "" ) || die("Couldnt't Connect");
				mysql_select_db("myData") || die("Couldn't Find DB");
				
				$checkuser=mysql_query("SELECT username FROM logins WHERE username='$username'");
				$checkuser_num_rows=mysql_num_rows($checkuser);
				
				$checkemail=mysql_query("SELECT email FROM logins WHERE email='$email'");
				$checkemail_num_rows=mysql_num_rows($checkemail);
				
				if(strlen($password) > 20 || strlen($password) < 6){ //Check password length
					echo '<SCRIPT language="JavaScript">window.alert("Password Must be at Least 6 and less than 20 characters")</script>';
				}else if($checkuser_num_rows){
					echo '<SCRIPT language="JavaScript">window.alert("SORRY! UserName Already Exist!")</script>';
				}else if($checkemail_num_rows){
					echo '<SCRIPT language="JavaScript">window.alert("SORRY! Email Already Exist!")</script>';
				}
				else{// Registers user
	
					$queryreg= mysql_query("INSERT INTO logins VALUES ('','$fullname','$username','$email','1','$random','$encryptedpassword', '$date' ) ");
					
					$resultId = mysql_query("SELECT id FROM logins WHERE username='$username'"); 
					
					if(mysql_num_rows($resultId) !=0 ){
					while($row = mysql_fetch_assoc($resultId)){
							$id=$row['id'];
						}
					}
					
					//Send email Activation
					$to= $email;
					$subject= "Activate your account!";
					$header= "From: kique10000@yahoo.com";
					$server= "smtp.mail.yahoo.com";//Do not have one here
					
					ini_set("SMTP", $server);
					
					$body= "
					
					Hello $fullname,
					\n\n
					You need to activate your account with the link below:
					http://localhost/myWeb/firstfile/activate.php?id=$id&code=$random
					\n\n
					Thank you.
					";
					
					//Function to send email
					if(mail($to, $subject, $body, $header))
						die("You Have Been Registered! Check your email to activate you Account. <a href='index.php'> Retrun Home </a>"); 
					else
						die("Unable to Sent Email!");
				}
			}
		}else{
			echo '<SCRIPT language="JavaScript">window.alert("You Passwords do not Match")</script>';
		}

		
	}else{
		echo '<SCRIPT language="JavaScript">window.alert("Please Fill In All Fields")</script>';
	}
}

?>