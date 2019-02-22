<?php

function takenExam($user_id)
{
	$sqlChecker = "SELECT date_of_testing, status FROM user_detail WHERE user_id='$user_id'";
	$queryChecker = mysql_query($sqlChecker) or die(mysql_error());

	$row = mysql_fetch_assoc($queryChecker);

	$result = array();
	$result['status'] = $row['status'];
	$result['dot'] = $row['date_of_testing'];

	return $result;
}

function get_course_cut_off($user_id)
{
	$sql = "SELECT * FROM user_detail, college_courses WHERE user_id = '$user_id' AND user_detail.desired_course_id = college_courses.desired_course_id LIMIT 1";
	$query = mysql_query($sql) or die(mysql_error());

	return mysql_fetch_assoc($query)['course_cut_off'];

}

function updateUserScores($userID)
{
	//first i need to know what is his score. . .
	$sqlGetScoreFromView = "SELECT * FROM examiner_count_score WHERE user_id='$userID'";
	$queryGetScoreFromView = mysql_query($sqlGetScoreFromView) or die("Error in query");
	$user_scores = array();
	while($row = mysql_fetch_array($queryGetScoreFromView))
	{
		$user_scores[$row['q_cat_id']] = $row['score'];
	}
	$question_category_id = implode(',', array_keys($user_scores));
	if(!empty($question_category_id))
	{
		$sqlUpdateScore = "UPDATE examiner_score SET score = CASE q_cat_id ";
		foreach($user_scores as $key => $value)
		{
			$sqlUpdateScore .= sprintf("WHEN '%s' THEN '%s' ", $key, $value);
		}
		$sqlUpdateScore .= "END WHERE q_cat_id IN ($question_category_id) AND user_id='$userID'";
		mysql_query($sqlUpdateScore) or die(mysql_error());
	}
	
}

function displayScore($user_id)
{
	$sqlGetStuff = "SELECT * FROM examiner_score, question_category WHERE user_id = '$user_id' AND examiner_score.q_cat_id = question_category.q_cat_id GROUP BY question_category.q_cat_id";
	$queryGetStuff = mysql_query($sqlGetStuff) or die(mysql_error());
	$user_total_score = 0;
	$total_number_of_items = 0;

	$user_percentage = 0.0;

	$course_cut_off = get_course_cut_off($user_id);
	
	echo "<table class='table table-hover table-striped'>";
	echo "<tr class='info'><th>Category</th><th>Score</th><th>Total Items</th></tr>";
	while($row = mysql_fetch_assoc($queryGetStuff))
	{
		echo "<tr>";
		echo "<td>" . $row['q_cat_name'] . "</td>";
		echo "<td>" . $row['score'] . "</td>";
		echo "<td>" . $row['total_items'] . "</td>";
		echo "</tr>";

		$user_total_score += $row['score'];
		$total_number_of_items += $row['total_items'];
	}

	if($user_total_score > 0)
	{
		$user_percentage = ($user_total_score / $total_number_of_items) * 100.0;
	}


	echo "<tr class='warning'>";
	echo "<td><strong>Total</strong></td>";
	echo "<td>$user_total_score</td>";
	echo "<td>$total_number_of_items</td>";
	echo "</tr>";

	$sqlUpdateUserPercentage = "UPDATE examiner_percentage SET percentage = '$user_percentage' WHERE user_id = '$user_id'";
	$queryUpdateUserPercentage = mysql_query($sqlUpdateUserPercentage) or die(mysql_error());

	echo "<tr class='info'>";
	echo "<td colspan='20'><strong>Percentage: </strong><em>$user_percentage%</em></td>";
	echo "</tr>";
	echo "</table>";

	$user_percentage = (int) $user_percentage;
	if($user_percentage >= $course_cut_off)
	{
		echo "<h4>Congratulations! You got a passing score for your course!</h4>";
	}
	else
	{
		echo "<h4>Sorry, we would like to inform you that you did not pass the exam.</h4>";
	}
}

?>

<?php  
require('dbConn.php');
require('sessionChecker.php');

$id = $_SESSION['user_id'];
$result = takenExam($id);
$status = $result['status'];
$date_of_testing = $result['dot'];

if($status == 'Pending')
{
	echo "<script>window.location.href = 'userPanel.php?tab=error&code=verify';</script>";
	exit();
}
elseif($status == "Finished" && $date_of_testing > 0)
{
	updateUserScores($id);
	displayScore($id);

	mysql_close();
}
elseif($status == "AttemptedCheating")
{
	echo "<script>window.location.href='userPanel.php?tab=error&code=cheat';</script>";
	die();
}
elseif($status == "OngoingExamination")
{
	echo "<script>window.location.href='userPanel.php?tab=error&code=closed';</script>";
	die();
}
else
{
	echo "<script>window.location.href='userPanel.php?tab=error&code=noexam';</script>";
	die();
}
?>
