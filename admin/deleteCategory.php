<?php  
require 'adminSessionChecker.php';
require '../dbConn.php';

if(!isset($_GET['id']))
{
	die("No chosen question");
}
$id = $_GET['id'];

$sqlDeleteCategory = "DELETE FROM question_category WHERE q_cat_id='$id'";
$queryDelete = mysql_query($sqlDeleteCategory) or die(mysql_error());
mysql_close();

header("Location: adminPanel.php?tab=viewCategories");

?>
