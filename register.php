<?php
require('dbConn.php');

$sqlGetCourses = "SELECT desired_course_id, course_name FROM college_courses";
$queryGetCourses = mysql_query($sqlGetCourses) or die(mysql_error());
$list_of_course = array();
while($row = mysql_fetch_array($queryGetCourses))
{
	$id = $row['desired_course_id'];
	$course_name = $row['course_name'];
	$list_of_course[$id] = $course_name;
}
mysql_close();
?>
<html>
<head>
	<title>Sign Up</title>
	<link rel="stylesheet" type="text/css" href="css/register.css">
	<link rel="shortcut icon" type="image/png" href="icons/PUPLogo.png">
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
	right:5.5em;
	position:fixed;
	font-size:20px;
	margin-top: -90px;
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

.footer{
	background-color:maroon;
}
</style>
</head>
<body>
	<div id ="wrapper">
		<div class ="header">
			<div class = "title">
				<h3><a href="index.php">PUP Online Examination</a></h3>
				<img src="img/PUPLogo.png "width="75px" height="75px"alt="header">
			</div>
			<div class = "links">
				<ul>
					<li><td><div><a href="about.php" class="about"><font color="black">About Us</a></div></td></li>
					<li><td><div><a href="academic.php" class="about"><font color="black">Academic Offerings</a></div></td></li>
					<li><td><div><a href="#" class="about"><font color="black">Contact Us</a></div></td></li>
				</ul>
			</div>

		</div>

		<div class="content">
			<div class ="forms">
				<table>
					<center>
						<p>WANT TO TEST YOUR SKILLS? SIGN UP NOW</p>
					</center>
					<hr>
					<form method="POST" action="signup.php" onsubmit="return validate();">
						<div class="table">
							<tr>
								<td>
									<input name="lastname" type="text" class="lname" id="lname" placeholder="Last Name" required />&nbsp;
									<input name="firstname" type="text" class="fname" id="fname" placeholder="First Name" required />
								</td>
							</tr>

							<tr>
								<td>
									<input name="middlename" type="text" class="mname" placeholder="Middle Name" id="mname" required />&nbsp;
									<input name="email" id="email" type="email" class="Email" placeholder="Email" required />
								</td>
							</tr>

							<tr>
								<td>
									<input name="username" id="username" type="text" class="Usern" placeholder="Username" required />&nbsp;
									<input name="password" id="password" type="password" class="Pass" placeholder="Password" required />
								</td>
							</tr>

							<tr>
								<td>
									<input name="phone" id="phone" type="text" class="Usern" placeholder="Mobile Phone" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="11"/>&nbsp;
									<input name="school" id="school" type="text" class="Pass" placeholder="Previous School" required/>
								</td>
							</tr>

							<tr>
								<td><div class="bday">Course</div></td>
							</tr>

							<tr>
								<td>
									<select class="desired-course" name="desired_course" id="desired-course" required>
										<option selected disabled value="">Select Course</option>
										<?php  
										foreach ($list_of_course as $id => $course_name)
										{
											echo "<option value='$id'>$course_name</option>";
										}
										?>
									</select>
								</td>
							</tr>

							<tr>
								<td>
									<div class="bday">Birthdate</div>
								</td>
							</tr>

							<tr>
								<td>
									<select class="Month" name="month" id="month" required>
										<option value="" disabled selected>Month</option>
										<?php  
										$monthArray = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
										foreach ($monthArray as $key => $value) 
										{
											echo "<option value='$key'>$value</option>";
										}
										?>
									</select>


									<select class="Day" name="day" id="day" required>
										<option value="" disabled selected>Day</option>
										<?php  for($i = 1; $i <= 31; $i++) echo "<option value='$i'>$i</option>"; ?>
									</select>

									<select class="Year" name="year" id="year" required>
										<option value="" disabled selected>Year</option>
										<?php
										$year = date("Y");
										for($i = $year; $i >= 1950; $i--)
										{
											echo "<option value='$i'>$i</option>";
										}
										?>
									</select>
								</td>
							</tr>

							<td>
								<i radio>
									<input type="radio" class="radio" name="sex" value="Male" id="sex" required />Male
									<input type="radio" id="sex" name="sex" value="Female" required/>Female
								</i>
							</td>
						</i>
						<tr>
							<td>
								<input type="submit" class="my-submit" value="SIGN UP" name="btn_signup">
							</td>
						</tr>
						<tr>
							<td>
								<button onclick="window.location.href='index.php'" class="my-submit">Back</button>
							</td>
						</tr>
					</table>
				</form>
			</div>

			<?php
			if(isset($_GET['error']))
			{
				$error_type = $_GET['error'];
				$error = array();
				$error['username'] = "<p>Username already taken!</p>";
				$error['name'] = "<p>Your are already registered in the database!</p>";
				$error['email'] = "<p>Email address is already taken!</p>";
				$error['date'] = "<p>Invalid birthday!</p>";
				
				echo "<div class='error-message'><b><p>Error:</p></b>$error[$error_type]</div>";
			}
			?>
			
		</div>


	</div>

	<div class = "footer">
		<div class = "credits">
			
		</div>
	</div>
</body>
</html>