<?php  
require 'adminSessionChecker.php';
require '../dbConn.php';

if(!isset($_GET['examiner_id']))
{
	die("No chosen question");
}
$id = $_GET['examiner_id'];

$sqlDeteleExaminer = "DELETE FROM users WHERE user_id='$id'";
$queryDelete = mysql_query($sqlDeteleExaminer) or die(mysql_error());
mysql_close();

header("Location: adminPanel.php?tab=viewExaminers&filter=all");

?>
