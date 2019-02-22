<?php  
	require('../dbConn.php');
	require('adminSessionChecker.php');

	$group_id = $_GET['group_id'];
	$question_id = $_GET['question_id'];

	$sqlInsertGroup = "INSERT INTO question_group(question_id, group_id) VALUES ('$question_id', '$group_id')";
	$queryInsertGroup = mysql_query($sqlInsertGroup) or die(mysql_error());

	mysql_close();
	header('Location: adminPanel.php?tab=viewQuestionGroups&group_id=' . $group_id);
	die();