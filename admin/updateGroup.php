<?php  
	session_start();
	require '../dbConn.php';

	if(isset($_POST['btn_save']))
	{
		$group_id = $_POST['group_id'];
		$group_name = $_POST['group_name'];

		$sqlUpdateGroup = "UPDATE groups SET group_name = '$group_name' WHERE group_id = '$group_id'";
		$queryUpdateGroup = mysql_query($sqlUpdateGroup) or die(mysql_error());
	}

	mysql_close();
	header('Location: adminPanel.php?tab=viewGroups');
	die();
?>