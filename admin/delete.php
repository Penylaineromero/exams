<?php
require 'adminSessionChecker.php';
require '../dbConn.php';

if(!isset($_GET['id']))
{
	die("No chosen question");
}
$id = $_GET['id'];
$sqlDeleteQuestion = "DELETE FROM question WHERE q_id=$id";
$queryDelete = mysql_query($sqlDeleteQuestion) or die(mysql_error()); 
$sqlDeleteQuestion = "DELETE FROM answer WHERE q_id=$id";
$queryDelete = mysql_query($sqlDeleteQuestion) or die(mysql_error()); 
$sqlDeleteQuestion = "DELETE FROM choices WHERE q_id=$id";
$queryDelete = mysql_query($sqlDeleteQuestion) or die(mysql_error()); 
$sqlDeleteQuestion = "DELETE FROM examiner_answer WHERE q_id= $id;";
$queryDelete = mysql_query($sqlDeleteQuestion) or die(mysql_error()); 
$sqlDeleteQuestion = "DELETE FROM question_group WHERE question_id=$id";
$queryDelete = mysql_query($sqlDeleteQuestion) or die(mysql_error()); 

mysql_close();

header("Location: adminPanel.php?tab=viewQuestions&filter=all");