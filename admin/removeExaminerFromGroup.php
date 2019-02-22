<?php  
	require('../dbConn.php');
	require('adminSessionChecker.php');

	$group_id = $_GET['group_id'];
	$user_id = $_GET['examiner_id'];

	$sqlRemoveFromGroup = "DELETE FROM examinee_group WHERE group_id = $group_id AND examiner_id = $user_id";
	$queryRemoveFromGroup = mysql_query($sqlRemoveFromGroup) or die(mysql_error());

	mysql_close();
	header('Location: adminPanel.php?tab=viewExaminerGroups&group_id=' . $group_id);
	die();