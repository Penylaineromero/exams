<?php 
session_start();
require("dbConn.php");
if(isset($_POST['btn_signin']))
{
	$found = false;
	$username = strtoupper($_POST['username']);
	$password = $_POST['password'];
	$sqlLogin = "SELECT u.role_id, u.user_id, u.username, u.password FROM users u WHERE UPPER(u.username)= UPPER('$username') AND u.password = '$password' LIMIT 1";
	$queryLogin = mysql_query($sqlLogin) or die(mysql_error());

	if(mysql_num_rows($queryLogin) > 0)
	{
		$row = mysql_fetch_array($queryLogin);
		$role_id = $row[0];
		$user_id = $row[1];
		$db_username = strtoupper($row[2]);
		$db_password = $row[3];

		//is the username and password equal to the db username and password
		if($password == $db_password && $username == $db_username)
		{
			$found = true; 
			$_SESSION['user_id'] = $user_id;
			$_SESSION['username'] = strtolower($username);
		}
	}

	if($found)
	{
		switch ($role_id)
		{

			case 1:
				$_SESSION['level'] = 1;
				header("Refresh: 0; URL=admin/adminPanel.php?tab=viewPending");
				die();
				break;
			case 2:
				$_SESSION['level'] = 2;
				$_SESSION['group_id'] = get_examiner_group($_SESSION['user_id']);
				header("Refresh: 0; URL=userPanel.php?tab=welcome&name=" . strtolower($_SESSION['username']));
				die();
				break;
			default:
				die("Invalid user type!");
				break;
		}
	}
	else
	{
		header("Refresh: 0; URL=index.php?code=invalidcredentials");
		die();	
	}

	
} else {
	die("Error. Not submitted");
}

function get_examiner_group($user_id)
{
	$sqlGetUserGroup = "SELECT * FROm examinee_group WHERE examiner_id = $user_id LIMIT 1";
	$queryGetUserGroup = mysql_query($sqlGetUserGroup) or die(mysql_error());

	if(mysql_num_rows($queryGetUserGroup) > 0)
	{
		return mysql_fetch_assoc($queryGetUserGroup)['group_id'];
	}

	return null;
}