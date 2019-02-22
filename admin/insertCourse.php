<?php  
	require('../dbConn.php');
	require('adminSessionChecker.php');

	if(isset($_POST['btn_insert']))
	{
		$course_name = $_POST['course_name'];
		$course_abbrev = $_POST['course_abbrev'];
		$course_cut_off = $_POST['course_cut_off'];

		$sqlInsertCourse = "INSERT INTO college_courses(course_name, course_abbrev, course_cut_off) VALUES ('$course_name', '$course_abbrev', '$course_cut_off')";
		$queryInsertCourse = mysql_query($sqlInsertCourse) or die(mysql_error());

		mysql_close();
		header('Location: adminPanel.php?tab=viewCourses');
		die();
	}	


?>