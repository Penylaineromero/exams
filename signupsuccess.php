<!DOCTYPE html>
<html>
<head>
	<title>Welcome</title>
	<link rel="stylesheet" type="text/css" href="css/frontpage.css">
	<link rel="shortcut icon" type="image/png" href="icons/PUPLogo.png"/>
</head>
<body>
<style type="text/css">
.header{
	background-color:maroon;
	color:yellow;
	padding-left: 2em;
	width: 100%;
	height: 76px;
	top: 0em;
	left: -1em;
	position: fixed;
}
.links{
	float: right;
	right: 5.5em; 
	position: fixed;
	font-size: 20px;
	margin-top: -90px;
}
.content {
		background: #ffffff ;
		width: 90%;
		height: 30px;
		top: 5em;
		left: -1em;
		position: fixed;
}

.message_success
{
	width: 550px;
	margin: 0 auto;
	right: 34em;
	top: -5em;
	position: fixed;
	padding-top: 220px;
	font-size: 11px;
	font-family: Segoe UI;
	text-align: justify;
	color: #252c21;
}

.message_form {
	width: 37em;
	height: 17em;
	margin: 0 auto;
	right: 22.3em;
	top: 10em;
	position: fixed;
	border: 1px solid #bdbdbd;
	border-radius: 5px;
	background-color: #fff;
	opacity: 0.95;
	-webkit-box-shadow: 0px 0px 18px 1px rgba(209,209,209,1);
	-moz-box-shadow: 0px 0px 18px 1px rgba(209,209,209,1);
	box-shadow: 0px 0px 18px 1px rgba(209,209,209,1);
}
.about:hover{
    color: #2b3424;
    background-color:yellow; 
}
.footer{
	background-color: maroon;
}
</style>

	<div id ="wrapper">
		<div class ="header">
			<div class = "title"><h3>PUP Entrance Exam</h3></div>
			<img src="img/PUPLogo.png "width="75px" height="75px"alt="header">
			<div class = "links">
				<ul>
					<li><td><div><a href="#" class="about"><font color="black">About Us</a></div></td></li>
					<li><td><div><a href="#" class="about"><font color="black">Academic Offerings</a></div></td></li>
					<li><td><div><a href="#" class="about"><font color="black">Admission</a></div></td></li>
				</ul>
			</div>

		</div>

		<div class = "content">
			<div class = "message_form">
				<div class = "message_success">
					<h2><b><center>Sign Up Success!</center></b></h2>
					<p style="font-size: 20px;"><font color="black">Thank you for signing up. You can now log in to your account. Please wait for the administrator to verify your account before you can take the exam.</p>
					<center><p style="font-size: 20px;"><a href="index.php" style="color: red;">Click here to login</a></p></center>
				</div>
			</div>
		</div>	


		<div class = "footer">
			<div class = "credits">
				<br><h1><i><font color="black"><font size = "1 .5">&#169; Created by DICT 3-5 2017-2018</i></h1></br>
			</div>
		</div>
	</div>

</body>
</html>