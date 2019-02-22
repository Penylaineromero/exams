<?php  
require 'adminSessionChecker.php';
require '../dbConn.php';

if(!isset($_GET['desired_course_id']))
{
	die("No chosen question");
}
$id = $_GET['desired_course_id'];

$sqlDeleteCategory = "DELETE FROM college_courses WHERE desired_course_id='$id'";
$queryDelete = mysql_query($sqlDeleteCategory) or die(mysql_error());
mysql_close();

header("Location: adminPanel.php?tab=viewCourses");

?>
