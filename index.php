<?php
session_start();
?>

<script type="text/javascript">
</script>

<style type="text/css">
body{
	position:absolute;
	margin:0px;
}
#container{

	margin: 0 auto;
	width: 100%;
	background: #fff;
}
#header{

	background: #ccc;
	padding-bottom:60px;
}
#header h1 { 
	margin: 0;
	padding-left:200px;
	padding-top:25px;
}

#loginform{
	margin-top: -20px;
}

#navigation{
	float: left;
	width: 100%;
	background: #333;

}

#navigation ul{
	padding-left:100px;
	margin: 0;
}

#navigation ul li{
	list-style-type: none;
	display: inline;
}

#navigation li a{
	display: block;
	float: left;
	padding: 5px 10px;
	color: #fff;
	text-decoration: none;
	border-right: 1px solid #fff;
}

#navigation li a:hover { background: #383; }

#logout{
	visibility:hidden;
}

#myprofile{
	visibility:hidden;
}

#content-container1{
	min-width: 800px;
	float: left;
	background:#E0FFFF;
	margin-left:100px;
	margin-right:100px;
}

#content-container2{
	float: left;
	width: 100%;
	
}

#section-navigation{
	float: left;
	width: 16%;
	padding: 20px 0;
	margin: 0 2%;
	display: inline;
}

#section-navigation ul{
	margin: 0;
	padding: 0;
}

#section-navigation ul li{
	margin: 0 0 1em;
	padding: 0;
	list-style-type: none;
}

#content{
	background:#FFFFFF;
	float: left;
	width: 56%;
	padding: 20px 0;
	margin: 0 0 0 2%;
	min-height:500px;
}

#content h2 { margin: 0; }

#aside{
	float: right;
	width: 16%;
	padding: 20px 0;
	margin: 0 2% 0 0;
	display: inline;
}

#aside h3 { margin: 0; }

#footer{
	clear: both;
	background: #ccc;
	text-align: right;

}

#welcomeform{
	visibility:hidden;
	float:right;
	padding-top:25px;
}

</style>


<html>
<body>

<div id="container">
	<div id="header">
		<h1>
			Site name
		</h1>
		<div id='loginform'>
		<form method='POST' action='login.php'/form>
			<table  align='right'>
			<tr>
				<td>
					Username: <input type='text' name='username' />
				</td>
				<td>
					Password: <input type='password' name='password' />
				</td>
			</tr>
			<tr>
				<td align='center'>
					<input type='submit' value='Log In' />
				</td>
				<td>
					<a href="register.php">Register Now</a>
				</td>
			</tr>
			</table>
		</div>
		<div id='welcomeform' >
		<?php
			echo 'Welcome, '.$_SESSION['fullname']. '!';
		?>
		</div>
	</div>
	
	<div id="navigation">
		<ul>
		<?php
		//display when log in or not 
		if(!$_SESSION['boolLog']){
		echo"
			<li><a href=\"index.php\">Home</a></li>
			<li><a href=\"index.php?p=aboutus\">About</a></li>
			<li><a href=\"index.php?p=services\">Services</a></li>
			<li><a href=\"index.php?p=contactus\">Contact us</a></li>
			<li><a href=\"forum.php\">Forum</a></li>
			<li><a href=\"QRpage.php\">QR Code</a></li>
			<li><a href=\"FBFeeds.php\">FB Feeds</a></li>";
		}else{
		echo"
			<li><a href=\"home.php\">Home</a></li>
			<li><a href=\"home.php?p=aboutus\">About</a></li>
			<li><a href=\"home.php?p=services\">Services</a></li>
			<li><a href=\"home.php?p=contactus\">Contact us</a></li>
			<li><a href=\"forum.php\">Forum</a></li>
			<li id='myprofile'><a href=\"home.php?p=myprofile\">Profile</a></li>";
		}
		?>
		
		<div id='logout'><li><a href="logout.php">Log out</a></li></div>
		</ul>
	</div>
	<div id="content-container1">
		<div id="content-container2">
			<div id="section-navigation">
				<ul>
					<li><a href="#">Section page 1</a></li>
					<li><a href="#">Section page 2</a></li>
					<li><a href="#">Section page 3</a></li>
					<li><a href="#">Section page 4</a></li>
				</ul>
			</div>
			<div id="content">
			<?php
				//check for which pages to go to in the content
				$pages_dir= 'pages';
				if(!empty($_GET['p'])){
					$pages= scandir($pages_dir, 0);
					unset($pages[0], $pages[1]);
					
					$p = $_GET['p'];
					
					if(in_array($p.'.inc.php', $pages)){
						include($pages_dir.'/'.$p.'.inc.php');
					}else{
						echo 'sorry page not found.';
					}
				}else{
					include($pages_dir.'/home.inc.php');
				}
			?>
			</div>
			<div id="aside">
				<h3>
					Aside heading
				</h3>
				<p>
					Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan.
				</p>
			</div>
		</div>
	</div>
	<div id="footer">
		Copyright &copy KiqueX Production, 2012
	</div>
</div>

</body>
</html>