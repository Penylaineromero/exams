<?php  
require('../dbConn.php');
require('adminSessionChecker.php');

$course_id = $_GET['id'];

$sqlGetCourses = "SELECT * FROM college_courses WHERE desired_course_id = '$course_id'";
$queryGetCourses = mysql_query($sqlGetCourses) or die(mysql_error());

while($row = mysql_fetch_array($queryGetCourses))
{
	$desired_course_id = $row['desired_course_id'];
	$course_name = $row['course_name'];
	$course_abbrev = $row['course_abbrev'];
	$course_cut_off = $row['course_cut_off'];

}
?>

<form method="POST" action="updateCourse.php" role="form">
	<div class="form-group">
		<label for="course">Course Name: </label>
		<input class="form-control" id="course" type="text" name="course_name" placeholder="Course Name" value="<?=$course_name?>" required/>
	</div>

	<div class="form-group">
		<label for="course-abbrev">Course Abbreviation: </label>
		<input class="form-control" id="course-abbrev" type="text" name="course_abbrev" placeholder="Course Abbreviation" value="<?=$course_abbrev?>" required/>	
	</div>

	<div class="form-group">
		<label for="course-cut-off">Course Cut Off: </label>
		<input class="form-control" id="course-cut-off" type="number" min="20" max="100" name="course_cut_off" placeholder="Course Cut Off" required value="<?=$course_cut_off?>"/>	
	</div>

	<input type="hidden" name="desired_course_id" value="<?=$desired_course_id?>">
	<input type="submit" class="btn btn-success" value="Save" name="btn_save" />	
</form>
