<?php  
	require('../dbConn.php');
	require('adminSessionChecker.php');

	if(isset($_POST['btn_insert']))
	{
		$category_name = mysql_real_escape_string($_POST['category_name']);
		$category_description = mysql_real_escape_string($_POST['category_description']);
 	
		$sqlInsertQuestion = "INSERT INTO question_category(q_cat_name, q_cat_desc) VALUES ('$category_name','$category_description')";
		$queryInsertQuestion = mysql_query($sqlInsertQuestion) or die(mysql_error());

		mysql_close();
		header('Location: adminPanel.php?tab=viewCategories');
		die();
	}	


?>