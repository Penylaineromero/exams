<?php
	require('../dbConn.php');
	require('adminSessionChecker.php');

	$oldPassword = $_POST['oldpassword'];
	$newPassword = $_POST['confirmpassword'];

	$userID = $_SESSION['user_id'];

	$sqlCompareOldPassword = "SELECT password FROM users WHERE user_id='$userID'";
	$queryCompareOldPassword = mysql_query($sqlCompareOldPassword) or die("Invalid query");

	$row = mysql_fetch_array($queryCompareOldPassword);
	$dbPassword = $row['password'];

	if($oldPassword == $dbPassword)
	{
		$sqlUpdatePasword = "UPDATE users SET password='$newPassword' WHERE user_id='$userID'";
		mysql_query($sqlUpdatePasword) or die(mysql_error());

	}
	else
	{
		echo "Error: Invalid password!";
		
	}
	mysql_close();
	header("Location: adminPanel.php?tab=settings&code=success");
	die();