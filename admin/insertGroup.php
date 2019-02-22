<?php  
	require('../dbConn.php');
	require('adminSessionChecker.php');

	if(isset($_POST['btn_insert']))
	{
		$group_name = mysql_real_escape_string($_POST['group_name']); 	
		$sqlInsertGroup = "INSERT INTO groups(group_name) VALUES ('$group_name')";
		$queryInsertGroup = mysql_query($sqlInsertGroup) or die(mysql_error());

		mysql_close();
		header('Location: adminPanel.php?tab=viewGroups');
		die();
	}	


?>