<?php  
function printResults($details)
{
	$was_correct = false;
	if($details['correct_answer'] != $details['answer_text'])
	{
		echo "<tr class='danger'>";
	}
	else
	{
		$was_correct = true;
		echo "<tr class='info'>";
	}
	foreach($details as $column)
	{
		echo "<td><p>$column</p></td>";
	}
	echo "</tr>";

	return $was_correct;
}
function displayScore($user_id)
{
	$sqlGetStuff = "SELECT * FROM examiner_score, question_category WHERE user_id = '$user_id' AND examiner_score.q_cat_id = question_category.q_cat_id";
	$queryGetStuff = mysql_query($sqlGetStuff) or die(mysql_error());
	$user_total_score = 0;
	$total_number_of_items = 0;

	$user_percentage = 0.0;

	$course_cut_off = get_course_cut_off($user_id);
	while($row = mysql_fetch_assoc($queryGetStuff))
	{
		$user_total_score += $row['score'];
		$total_number_of_items += $row['total_items'];
	}

	if($user_total_score > 0)
	{
		$user_percentage = ($user_total_score / $total_number_of_items) * 100.0;
	}

	$sqlUpdateUserPercentage = "UPDATE examiner_percentage SET percentage = '$user_percentage' WHERE user_id = '$user_id'";
	$queryUpdateUserPercentage = mysql_query($sqlUpdateUserPercentage) or die(mysql_error());

	echo "<tr class='info'>";
	echo "<td colspan='20'><strong>Percentage: </strong><em>$user_percentage%</em></td>";
	echo "</tr>";
}

function get_course_cut_off($user_id)
{
	$sql = "SELECT * FROM user_detail, college_courses WHERE user_id = '$user_id' AND user_detail.desired_course_id = college_courses.desired_course_id LIMIT 1";
	$query = mysql_query($sql) or die(mysql_error());
}

?>

<?php
require('../dbConn.php');
require('adminSessionChecker.php');
if(!isset($_GET['id']))
	die("No id selected");

$userID = $_GET['id'];
$sqlGetResults = "SELECT q_cat_name, q_text, correct_answer, answer_text FROM examiner_question_results WHERE user_id='$userID'";
$queryGetResults = mysql_query($sqlGetResults) or die(mysql_error());
$totalItems = 0;
$totalCorrect = 0;
$totalWrong = 0;
?>
<div class="container-fluid">
</div>
<div class="row">
	<table class="table table-condensed table-hover">
		<thead>
			<tr class="success">
				<th>Category</th>
				<th>Question</th>
				<th>Correct Answer</th>
				<th>Examiner's Answer</th>
			</tr>
		</thead>
		<?php
		if(mysql_num_rows($queryGetResults) > 0)
		{
			while($row = mysql_fetch_assoc($queryGetResults))
			{
				if(printResults($row))
					$totalCorrect++;

				$totalItems++;
			}
			displayScore($userID);
			$totalWrong = $totalItems - $totalCorrect;
			echo "<tr><td></td></tr>";
			echo "<tr class='warning'>";
			echo "<td colspan='20'><strong>Correct: $totalCorrect | Wrong: $totalWrong | Total Items: $totalItems</td></strong>";
			echo "</tr>";
		}
		else
		{
			die("Not available");
		}
		
		?>
	</table>
</div>