<?php  
	require('../dbConn.php');
	require('adminSessionChecker.php');

	$group_id = $_GET['group_id'];
	$user_id = $_GET['examiner_id'];

	$sqlInsertExaminer = "INSERT INTO examinee_group(examiner_id, group_id) VALUES ('$user_id', '$group_id')";
	$queryInsertGroup = mysql_query($sqlInsertExaminer) or die(mysql_error());

	mysql_close();
	header('Location: adminPanel.php?tab=viewExaminerGroups&group_id=' . $group_id);
	die();