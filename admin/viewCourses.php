<?php  
function displayCourses($details)
{
	$desired_course_id = $details['desired_course_id'];
	$course_name = $details['course_name'];
	$course_abbreviation = $details['course_abbrev'];
	$course_cut_off = $details['course_cut_off'];

	echo "<tr>";
	echo "<td>" . $course_name . "</td>";
	echo "<td>" . $course_abbreviation . "</td>";
	echo "<td>" . $course_cut_off . "%</td>";
	echo "<td><a href='adminPanel.php?tab=editCourse&desired_course_id=" . $desired_course_id . "' class='btn btn-xs btn-warning'>Update</a>&nbsp;<a href='deleteCourse.php?desired_course_id=$desired_course_id' onclick='return areYouSure();' class='btn btn-xs btn-danger'>Delete</a></td>";
	echo "</tr>";
}
?>

<?php
require('../sessionChecker.php');
require('../dbConn.php');

//get all college names
$sqlGetColleges = "SELECT college_courses.* FROM college_courses";
$queryGetColleges = mysql_query($sqlGetColleges) or die(mysql_error());
$totalCourses = mysql_num_rows($queryGetColleges);

echo "<a href='adminPanel.php?tab=addNewCourse' class='btn btn-success btn-xs'>New Course</a>";
echo "<table class='table table-condensed table-hover'>";
echo "<thead class='info'><th>Course Name</th><th>Course Abbreviation</th><th>Course Cut Off</th><th>Action</th></thead>";
if($totalCourses > 0)
{
	while($row = mysql_fetch_array($queryGetColleges))
	{
		displayCourses($row);	
	}

}
else
{
	echo "<tr><td colspan='5'><center>No results found!</center></td></tr>";
}

echo "<tr class='info'><td colspan='5'><u>Total Courses:</u> <b>$totalCourses</b></td></tr>";
echo "</table>";
mysql_close();
?>

<script type="text/javascript">

	function areYouSure()
	{
		var dialogConfirm = window.confirm("Are you sure you want to delete?");

		return dialogConfirm;
	}
</script>