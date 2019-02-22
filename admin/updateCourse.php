<?php  
	session_start();
	require '../dbConn.php';

	if(isset($_POST['btn_save']))
	{
		$desired_course_id = $_POST['desired_course_id'];
		$course_name = $_POST['course_name'];
		$course_abbrev = $_POST['course_abbrev'];
		$course_cut_off = $_POST['course_cut_off'];

		$sqlUpdateCollege = "UPDATE college_courses SET course_name = '$course_name', course_abbrev = '$course_abbrev', course_cut_off = '$course_cut_off' WHERE desired_course_id = '$desired_course_id'";
		$queryUpdateCollege = mysql_query($sqlUpdateCollege) or die(mysql_error());
	}

	mysql_close();
	header('Location: adminPanel.php?tab=viewCourses');
	die();
?>