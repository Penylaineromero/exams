<?php  
	session_start();
	require '../dbConn.php';

	if(isset($_POST['btn_save']))
	{
		$category_id = $_POST['category_id'];
		$category_name = $_POST['category_name'];
		$category_description = $_POST['category_description'];

		$sqlUpdateCategory = "UPDATE question_category SET q_cat_name = '$category_name', q_cat_desc = '$category_description' WHERE q_cat_id = '$category_id'";
		$queryUpdateCategory = mysql_query($sqlUpdateCategory) or die(mysql_error());
	}

	mysql_close();
	header('Location: adminPanel.php?tab=viewCategories');
	die();
?>