<?php  
	require('dbConn.php');
	require('sessionChecker.php');

	if(isset($_POST['btn_submit']))
	{
		if(isset($_POST['desired_course']))
		{
			$desired_course = $_POST['desired_course'];
			$user_id = $_SESSION['user_id'];
			$sqlUpdateDetails = "UPDATE user_detail SET desired_course_id='$desired_course' WHERE user_id='$user_id'";
			mysql_query($sqlUpdateDetails) or die("You must choose a course!");

			mysql_close();
			header("Location: userPanel.php?tab=editProfile");
			die();
		}
	}
?>