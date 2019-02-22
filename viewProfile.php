<?php
	function printUserDetails($userDetails)
	{
		$firstname = $userDetails['firstname'];
		$middlename = $userDetails['middlename'];
		$lastname = $userDetails['lastname'];
		$email = $userDetails['email'];
		$birthday = $userDetails['birthday'];
		$gender = $userDetails['gender'];
		$date_of_testing = ($userDetails['date_of_testing'] == null) ? "N/A" : $userDetails['date_of_testing'] ;
		$phone = $userDetails['phone'];
		$previous_school = $userDetails['previous_school'];
		$course = $userDetails['course_name'];
		$status = $userDetails['status'];

		$sqlGetCourses = "SELECT desired_course_id, course_name FROM college_courses";
		$queryGetCourses = mysql_query($sqlGetCourses) or die(mysql_error());


		echo "<div class='form-group'>";
		echo "<label for='desired_course'>Course</label>";
		echo "<select class='form-control' id='desired_course' name='desired_course' disabled>";
		echo "<option>Select Course</option>";
		while($row = mysql_fetch_array($queryGetCourses))
		{
			$id = $row['desired_course_id'];
			$course_name = $row['course_name'];

			if($course == $course_name)
			{
				echo "<option value='$id' selected>$course_name</option>";
			}
			else
			{
				echo "<option value='$id'>$course_name</option>";
			}
			
		}

		echo "</select>";
		echo "</div>";
		echo "<div class='form-group'>";
		echo "<label for='firstname'>First Name</label>";
		echo "<input type='text' id='firstname' class='form-control' readonly value=" . "\"" . $firstname . "\"" . "/>";
		echo "</div>";

		echo "<div class='form-group'>";
		echo "<label for='middlename'>Middle Name</label>";
		echo "<input type='text' id='middlename' class='form-control' readonly value=" . "\"" . $middlename . "\"" . "/>";
		echo "</div>";

		echo "<div class='form-group'>";
		echo "<label for='lastname'>Last Name</label>";
		echo "<input type='text' id='lastname' class='form-control' readonly value=" . "\"" . $lastname . "\"" . "/>";
		echo "</div>";

		echo "<div class='form-group'>";
		echo "<label for='email'>E-Mail Address</label>";
		echo "<input type='text' id='email' class='form-control' readonly value=" . "\"" . $email . "\"" . "/>";
		echo "</div>";

		echo "<div class='form-group'>";
		echo "<label for='birthday'>Birthday</label>";
		echo "<input type='text' id='birthday' class='form-control' readonly value=" . "\"" . $birthday . "\"" . "/>";
		echo "</div>";

		echo "<div class='form-group'>";
		echo "<label for='gender'>Gender</label>";
		echo "<input type='text' id='gender' class='form-control' readonly value=" . "\"" . $gender . "\"" . "/>";
		echo "</div>";

		echo "<div class='form-group'>";
		echo "<label for='date_of_testing'>Date of Testing</label>";
		echo "<input type='text' id='date_of_testing' class='form-control' readonly value=" . "\"" . $date_of_testing . "\"" . "/>";
		echo "</div>";

		echo "<div class='form-group'>";
		echo "<label for='previous_school'>Previous School</label>";
		echo "<input type='text' id='previous_school' class='form-control' readonly value=" . "\"" . $previous_school . "\"" . "/>";
		echo "</div>";

		echo "<div class='form-group'>";
		echo "<label for='phone'>Phone Number</label>";
		echo "<input type='text' id='phone' class='form-control' readonly value=" . "\"" . $phone . "\"" . "/>";
		echo "</div>";

		echo "<div class='form-group'>";
		echo "<label for='status'>Status</label>";
		echo "<input type='text' id='status' class='form-control' readonly value=" . "\"" . $status . "\"" . "/>";
		echo "</div>";


	}
?>

<?php  
	require('dbConn.php');
	require('sessionChecker.php');
	$userID = $_SESSION['user_id'];

	$sqlGetDetails = "SELECT * FROM userdetails WHERE user_id='$userID'";
	$queryGetDetails = mysql_query($sqlGetDetails) or die(mysql_error());
	$details = mysql_fetch_assoc($queryGetDetails);
?>

<div class="row">
	<h4><?php echo $details['firstname'] . "'s"; ?> Profile</h4>
	<form role="form" name="editProfile" method="POST" action="updateprofile.php" class="col-md-5">
	<?php 
	if(mysql_num_rows($queryGetDetails) > 0)
	{
		printUserDetails($details);
	}
	else
	{
		echo "Not available";
	}
	?>
	</form>
</div>