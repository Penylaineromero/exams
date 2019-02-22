<?php
require("dbConn.php");
if(isset($_POST['btn_signup']))
{
	foreach($_POST as $key => $value)
	{
		if(empty($value))
		{
			die("Values cannot be empty");
		}
	}
	$firstname= mysql_real_escape_string($_POST['firstname']);
	$middlename= mysql_real_escape_string($_POST['middlename']);
	$lastname= mysql_real_escape_string($_POST['lastname']);
	$email=$_POST['email'];
	$username = mysql_real_escape_string($_POST['username']);
	$password=$_POST['password'];
	$school=mysql_real_escape_string($_POST['school']);
	$month=$_POST['month'];
	$day=$_POST['day'];
	$year=$_POST['year'];
	$sex=$_POST['sex'];
	$phone=$_POST['phone'];
	$desired_course = $_POST['desired_course'];
	$bday = $year . "-" . $month . "-" . $day;

	if(!checkdate($month, $day, $year))
	{
		header("Location: register.php?error=date");
		die();
	}

	$sqlCheckUsername = "SELECT username FROM users WHERE username='$username'";
	$queryCheckUsername = mysql_query($sqlCheckUsername);
	$usernameExists = mysql_num_rows($queryCheckUsername);

	if($usernameExists)
	{
		header("Location: register.php?error=username");
		die();
	}

	$sqlCheckName = "SELECT firstname, middlename, lastname FROM user_detail WHERE firstname='$firstname' AND middlename='$middlename' AND lastname='$lastname'";
	$queryCheckName = mysql_query($sqlCheckName);
	$nameExists = mysql_num_rows($queryCheckName);

	if($nameExists)
	{
		header("Location: register.php?error=name");
		die();
	}

	$sqlCheckEmail = "SELECT email FROM user_detail WHERE email='$email'";
	$queryCheckEmail = mysql_query($sqlCheckEmail) or die(mysql_error());
	$emailExists = mysql_num_rows($queryCheckEmail);

	if($emailExists)
	{
		header("Location: register.php?error=email");
		die();
	}
	//check if user exists

	$sqlInsertToUsers = "INSERT INTO users(role_id,username,password) VALUES ('2','$username','$password')";
	$queryInsertToUsers = mysql_query($sqlInsertToUsers) or die(mysql_error());

	$sqlGetID = mysql_insert_id();
	$sqlInsertToUserDetails = "INSERT INTO user_detail(user_id, firstname,middlename,lastname,email,birthday,gender,previous_school,phone, desired_course_id) VALUES ('$sqlGetID','$firstname','$middlename','$lastname','$email','$bday','$sex','$school','$phone', '$desired_course')";

	$querySqlInsertToUserDetails = mysql_query($sqlInsertToUserDetails) or die (mysql_error());
	mysql_close();

	header("Location: signupsuccess.php");
	die();
}