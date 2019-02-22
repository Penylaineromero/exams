<?php  
	
	if(isset($_GET['id']))
	{
		require('../dbConn.php');
		require('adminSessionChecker.php');
		$id = $_GET['id'];
		$sqlUpdateStatus = "UPDATE user_detail SET status='Approved' WHERE user_id='$id'";
		mysql_query($sqlUpdateStatus) or die(mysql_error());
		mysql_close();

		header("Location: adminPanel.php?tab=viewPending");
		die();
	}
?>