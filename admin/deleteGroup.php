<?php  
require 'adminSessionChecker.php';
require '../dbConn.php';

$group_id = $_GET['id'];

$sqlGetExaminersInGroup = "SELECT * FROM examinee_group WHERE group_id = $group_id";
$queryGetExaminersInGroup = mysql_query($sqlGetExaminersInGroup) or die(mysql_error());

$examiner_ids = [];

while($row = mysql_fetch_assoc($queryGetExaminersInGroup))
{
	$examiner_ids[] = $row['examiner_id'];
}

$examiner_ids = implode(',', $examiner_ids);

$sqlDeleteGroups = "DELETE FROM groups WHERE group_id = $group_id";
$sqlDeleteQuestionGroups = "DELETE FROM question_group WHERE group_id = $group_id";

$sqlDeleteExaminerGroups = "DELETE FROM examinee_group WHERE group_id = $group_id";

$sqlDeleteExaminer = "DELETE FROM users WHERE user_id IN ($examiner_ids)";

$sqlDeleteExaminerDetails = "DELETE FROM user_detail WHERE user_id IN ($examiner_ids)";


mysql_query($sqlDeleteGroups) or die(mysql_error());
mysql_query($sqlDeleteQuestionGroups);
mysql_query($sqlDeleteExaminerGroups);
mysql_query($sqlDeleteExaminer);
mysql_query($sqlDeleteExaminerDetails);

header("Location: adminPanel.php?tab=viewGroups");
die();