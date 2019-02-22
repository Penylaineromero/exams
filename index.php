<!DOCTYPE html>
<html>
<head>
	<title>PUP Entrance Exam</title>
	<link rel="stylesheet" type="text/css" href="css/frontpage.css">
	<link rel="shortcut icon" type="image/png" href="icons/PUPLogo.png"/>
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
		background:0em;
		color:yellow;
		float: right;
		right: 5.5em; 
		position: fixed;
		font-size: 20px;
		margin-top: -95px;
}

.about:hover{
    	color: #2b3424;
    	background-color:yellow;
}

.about{
	background-color:yellow;
}

.box{
	background-color:yellow;
}
.submit{
	background-color:yellow;
	color:black;
}
.form2 {
	width: 20em;
	height: 10em;
	margin: 0 auto;
	right: 15em;
	top: 10em;
	position: fixed;
	border: 1px solid #bdbdbd;
	border-radius: 10px;
	background-color:;
	opacity: 0.85;
	-webkit-box-shadow: 0px 0px 18px 1px rgba(209,209,209,1);
	-moz-box-shadow: 0px 0px 18px 1px rgba(209,209,209,1);
	box-shadow: 0px 0px 18px 2px rgba(209,209,209,1);
}
.footer{
	
	background-color:maroon;
}

	.error-message
	{
		margin-left: 50em;
		width: 320px;
		margin-top: 21em;
		color: blue;
	}

	.error-message p
	{
		color: red;
		font-size: 14px;
		padding-left: 80px;
	}

	</style>
</head>
<body>

<div id ="wrapper">
		<div class ="header">
			<div class = ""><h3><a href="index.php">PUP Online Examination</a></h3></div>
			<img src="img/PUPLogo.png "width="75px" height="75px"alt="header">
			<div class = "links">
				<ul>

					<li><td><div><a href="about.php" class="about"><font color="black">About Us</font></a></div></td></li>
					<li><td><div><a href="academic.php" class="about"><font color="black">Academic Offerings</font></a></div></td></li>
					<li><td><div><a href="admission.php" class="about"><font color="black">Admission</a></div></td></li>
				</ul>
			</div>

		</div>

		<div class = "content">
			<div class = "form1">
				<div class = "message">
					<font size = "3.5"><font color="black"><h2><b>PUP ONLINE EXAMINATION</b></h2></font>
					<font size = "3"><font color="black">Polytechnic University of the Philippines is a coeducational, research state university located in Santa Mesa, Manila, Philippines. It was founded on October 19, 1904 as the Manila Business School. The university is ruled by Republic Act Number 8292, or the Higher Education Modernization Act of 1997. PUP has a total of 71,963 students enrolled, and it has 25 branches and campuses located in Metro Manila, Northern and Central Luzon, and in Southern Luzon.
					</font>
					<br>
					<br>
				</div>

				<div class="box"><a href="register.php"><font color="black">&#9654; REGISTER<a></div>
			</div>

			<div class = "form2">
				<form method="POST" action="signin.php">
					<table>
						<p><font color="black">ALREADY A MEMBER?</p>
						<hr>
						<tr>
							<td><input type="text" name="username" id="username" style ="text-indent: 17px;" class="Username" placeholder="Username" autocomplete="off" /></td>
						</tr>
						<tr>
							<td><input type="password" name="password" id="password" style = "text-indent:17px;" class="Username" placeholder="Password" autocomplete="off" /></td>
						</tr>
						<tr>
							<td><input type="submit" class="submit" value="LOG IN" name="btn_signin" /></td>
						</tr>
					</table>
				</form>	
			</div>
		</div>	

		<?php
		if(isset($_GET['code']))
		{

			$codeValue = $_GET['code'];
			if($codeValue == "invalidcredentials")
			{
				$message = "<p>Invalid login credentials!</p>";
				echo "<div class='error-message'>$message</div>";
			}

			if($codeValue == "required")
			{
				$message = "<p>You need to be logged in before you can access the page!</p>";
				echo "<div class='error-message'>$message</div>";
			}
		}
		?>
		
		<div class = "footer">
			<div class = "credits">
				
			</div>
		</div>
	</div>

</body>
</html>