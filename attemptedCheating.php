<?php
	require('dbConn.php');
	require('sessionChecker.php');

	$user_id = $_SESSION['user_id'];
	//update status of examiner to cheating
	$sqlUpdateToCheating = "UPDATE user_detail SET status='AttemptedCheating' WHERE user_id='$user_id'";
	mysql_query($sqlUpdateToCheating) or die("Error in sqlUpdateToCheating");

	mysql_close();
	header("Location: userPanel.php?tab=error&code=cheat");
	die();
?>