<style type="text/css">
table td{
padding-right:50px;
}
</style>

<?php
session_start();
?>
<html>
<h3>My Profile</h3>
<body>
	<table>
		<tr>
			<td>
				Full Name: 
			</td>
			<td>
				<?php echo $_SESSION['fullname'] ?>
			</td>
		</tr>
		<tr>
			<td>
				UserName: 
			</td>
			<td>
				<?php echo $_SESSION['username'] ?>
			</td>
		</tr>
			<td>
				Email: 
			</td>
			<td>
				<?php echo $_SESSION['email'] ?>
			</td>
		<tr>
			<td>
				Date of Registration: 
			</td>
			<td>
				<?php echo $_SESSION['date'] ?>
			</td>
		</tr>
	</table>
</body>

</html>
