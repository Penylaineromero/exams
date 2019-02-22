<?php

require('../dbConn.php');
require('adminSessionChecker.php');

$userID = $_SESSION['user_id'];
$sqlGetAdminPassword = "SELECT * FROM users WHERE user_id='$userID'";
$queryGetAdminPassword = mysql_fetch_array($sqlGetAdminPassword) or die(mysql_error());
$row = mysql_fetch_assoc($queryGetAdminPassword);

$oldPassword = $_POST['oldpassword'];
$oldPasswordDB = $row['password'];
$confirmPassword = $_POST['confirmpassword'];
if($oldPasswordDB == $oldPassword)
{
	$sqlUpdatePassword = "UPDATE users SET password='$confirmPassword'";
	mysql_query($sqlUpdatePassword) or die(mysql_error());

	mysql_close();
}
else
{

}