<!-- 
/**
Author:  XuDing
Email:   hello@startutorial.com
Website: http://www.startutorial.com
Post on: Onextrapixel - http://www.onextrapixel.com
**/
 -->
<html>
<head>
<style>
body{
	width:100%;
	margin:0px;
	padding:0px;
}
#container{
	font-family: Arial, serif; 
	font-size:12px;	
	padding-top:20px;
	width:700px;
	margin: auto;	
}
form{
 	width:300px;
 	padding: 0px;
 	margin: 0px;
}
form textarea{
	font-family: Arial, serif; 
	font-size:12px;
	width:270px;
	margin:5px;
	height:40px;	
	overflow: hidden;
}
iframe{
 	border:1px solid #DDD;
}
#generator{
	width: 300px;
	float:left;
}
#generator fieldset{
	border:1px solid #DDD;
}
#result{
	padding-top:7px;
	margin-left:340px;
	width: 350px;	
}
</style>
</head>

<body>
<div id="container">
	<h1>QR code generator</h1>
	<div id="generator">
		<form target="qrcode-frame" action="gen.php" method="post">
		  <fieldset>
		    <legend>Size:</legend>
		  	 <input type="radio" name="size" value="150x150" checked>150x150<br>
		  	 <input type="radio" name="size" value="200x200">200x200<br>
		  	 <input type="radio" name="size" value="250x250">250x250<br>
		  	 <input type="radio" name="size" value="300x300">300x300<br>
		  </fieldset>
		  <fieldset>
		    <legend>Encoding:</legend>
		    <input type="radio" name="encoding" value="UTF-8" checked>UTF-8<br>
		    <input type="radio" name="encoding" value="Shift_JIS">Shift_JIS<br>
		    <input type="radio" name="encoding" value="ISO-8859-1">ISO-8859-1<br>
		  </fieldset>
		  <fieldset>
		    <legend>Content:</legend>
		    <textarea name="content"></textarea>
		  </fieldset>		  
		  <fieldset>
		    <legend>Error correction:</legend>
		    <select name="correction">
		    	<option value="L" selected>L</option>
		    	<option value="M">M</option>
		    	<option value="Q">Q</option>
		    	<option value="H">H</option>
		    </select>
		  </fieldset>		  
		  <input type="submit" value="Generate"></input>
		</form>
	</div>	
	<div id="result">
		<iframe name="qrcode-frame" frameborder="0"  id="qrcode" src="gen.php" height="315px;" width="350px"></iframe>
	</div>
</div>

</body>

</html>