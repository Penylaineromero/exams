<?php  
require('../dbConn.php');
require('adminSessionChecker.php');
?>

<form method="POST" action="insertCourse.php" role="form">
	<div class="form-group">
		<label for="course">Course Name: </label>
		<input class="form-control" id="course" type="text" name="course_name" placeholder="Course Name" required/>	
	</div>

	<div class="form-group">
		<label for="course-abbrev">Course Abbreviation: </label>
		<input class="form-control" id="course-abbrev" type="text" name="course_abbrev" placeholder="Course Abbreviation" required/>	
	</div>

	<div class="form-group">
		<label for="course-cut-off">Course Cut Off: </label>
		<input class="form-control" id="course-cut-off" type="number" min="20" max="100" name="course_cut_off" placeholder="Course Cut Off" required/>	
	</div>
	<input type="submit" class="btn btn-success" value="Save" name="btn_insert" />	
</form>
