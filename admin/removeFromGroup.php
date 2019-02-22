<?php  
	require('../dbConn.php');
	require('adminSessionChecker.php');

	$group_id = $_GET['group_id'];
	$question_id = $_GET['question_id'];

	$sqlRemoveFromGroup = "DELETE FROM question_group WHERE group_id = $group_id AND question_id = $question_id";
	$queryRemoveFromGroup = mysql_query($sqlRemoveFromGroup) or die(mysql_error());

	mysql_close();
	header('Location: adminPanel.php?tab=viewQuestionGroups&group_id=' . $group_id);
	die();