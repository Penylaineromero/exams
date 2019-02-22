<?php
	require('../dbConn.php');
	require('adminSessionChecker.php');

	$hours = $_POST['hours'];
	$minutes = $_POST['minutes'];
	$seconds = $_POST['seconds'];

	$sqlUpdateTime = "UPDATE time_limit SET hours='$hours', minutes='$minutes', seconds='$seconds'";
	mysql_query($sqlUpdateTime) or die(mysql_error());

	mysql_close();
	header("Location: adminPanel.php?tab=settings");
	die();
?>