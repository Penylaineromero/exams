<!DOCTYPE html>
<html>
<head>
	<title>Exam</title>
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/png" href="icons/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script type="text/javascript">
		function attemptedCheating()
		{
			alert("Oops. It seems like you are attempting to cheat!");
			window.location.href="attemptedCheating.php";
		}
	</script>

	<style type="text/css">
		.timer 
		{
			width: 170px;
			height: auto;
			background-color: white;
			font-size: 20px;
			color: black;
			right: 2em;
			float: right;
			position: fixed;
		}
	</style>
</head>
<?php
	function getTime()
	{
		$sqlGetTime = "SELECT hours, minutes, seconds FROM time_limit";
		$queryGetTime = mysql_query($sqlGetTime);
		$row = mysql_fetch_array($queryGetTime);

		$hours = intval($row['hours']) * 60 * 60;
		$minutes = intval($row['minutes']) * 60;
		$seconds = $row['seconds'];

		$time = $hours + $minutes + $seconds;
		return $time;
	}
?>
<body onblur="attemptedCheating();" onresize="attemptedCheating();">
<div class="timer">
	<b style="font-style: Segoe UI;">Time Remaining:</b>
	<center><span id="floating_timer"></span></center>
</div>
<?php

require('sessionChecker.php');
require("dbConn.php");

$time = getTime();

$question_id = array(); //will be used in randomizing the questions
$group_id = $_SESSION['group_id'];
$user_id = $_SESSION['user_id'];
$category = base64_decode($_GET['cat']) or die("No category selected!");	//decoding the category

//get category name
$sqlGetCurrentCategory = "SELECT q_cat_name FROM question_category WHERE q_cat_id='$category'";
$queryGetCurrentCategory = mysql_query($sqlGetCurrentCategory) or die(mysql_error());
$row = mysql_fetch_assoc($queryGetCurrentCategory);
$category_name = $row['q_cat_name'];
echo "<center><h2>Category: $category_name</h2></center>";


//checking when a user hits refresh
$sqlAlreadyAnswered = "SELECT status FROM categories_answered WHERE user_id='$user_id' AND q_cat_id='$category' AND status = 'answered' LIMIT 1";
$queryAlreadyAnswered = mysql_query($sqlAlreadyAnswered) or die(mysql_error());
$alreadyAnswered = mysql_num_rows($queryAlreadyAnswered);

if($alreadyAnswered)
{
	echo "<script>window.location.href='attemptedCheating.php';</script>";
	die();
}
else
{
	$sqlUpdateTheStatus = "UPDATE categories_answered SET status='answered' WHERE user_id='$user_id' AND q_cat_id='$category'";
	mysql_query($sqlUpdateTheStatus) or die(mysql_error());
}
//end of checking

$sqlGetQuestions = "SELECT q_id FROM question, question_group WHERE question.q_cat_id = $category AND question_group.group_id = $group_id AND question.q_id = question_group.question_id";
$queryGetQuestions = mysql_query($sqlGetQuestions) or die(mysql_error());

while($row = mysql_fetch_assoc($queryGetQuestions))
{
	$id = $row['q_id'];
	array_push($question_id, $id);
}

shuffle($question_id);
$_SESSION['question_id'] = $question_id;
$count = count($question_id);

echo "<div class='container'>";
echo "<div class='jumbotron'>";
echo "<form method='POST' action='process.php' name='examform' role='form'>";
for($i = 0; $i < $count; $i++)
{
	$queryString = "SELECT q_text FROM question WHERE q_id='" . $question_id[$i] . "'";
	$query = mysql_query($queryString) or die(mysql_error());
	$row = mysql_fetch_assoc($query);
	$text = $row['q_text'];
	echo "<div class='form-group $count'>";
	echo "<p> " . ($i + 1) . ". " . $text . "</p>";
	echo "</div>";
	$queryString = "SELECT choice_text FROM choices WHERE q_id='" . $question_id[$i] . "'";
	$query = mysql_query($queryString) or die(mysql_error());

	$choices = array();
	while($row = mysql_fetch_assoc($query))
	{
		$choice_text = $row['choice_text'];
		array_push($choices, $choice_text);
	}

	shuffle($choices);

	$counter = 0;
	foreach ($choices as $choice) 
	{
		echo "<input type='radio' id=" . "\"" . $choice . " " . $i . $counter . "\"" . "name='$question_id[$i]' value=" . "\"" . $choice . "\"" . " />";
		echo "<label for=" . "\"" . $choice . " " . $i . $counter . "\"" . ">$choice</label>";
		echo "<br />";
		$counter++;
	}
	echo "<br />";
}
mysql_close();
echo "<input type='hidden' value='$category' name='current_category' />";
echo "<input type='submit' value='Submit' name='btn_submit' class='btn btn-success'/>";
echo "</form>";
echo "</div>";
echo "</div>";

?>
<input type="hidden" name="time_limit" id="time_limit" value="<?php echo $time; ?>" />
<script type="text/javascript">

	var timeLimit = document.getElementById("time_limit").value;	//change to php value.. query inside database
	console.log(timeLimit);
	window.onload = function() { myTimer(timeLimit)}

	function myTimer(timeInSec)
	{
		var minutes, seconds;
		minutes = parseInt(timeInSec / 60);
		seconds = parseInt(timeInSec % 60);
		setInterval(function()
		{
			minutes = parseInt(minutes);
			seconds = parseInt(seconds);

			if(minutes == 0 && seconds == 1)
			{
				document.examform.submit();
			}

			if(seconds > 0)
			{
				--seconds;
			}
			else
			{
				seconds = 59;
				--minutes;
			}

			minutes = (minutes < 10) ? ("0" + minutes) : minutes;
			seconds = (seconds < 10) ? "0" + seconds : seconds;
			document.getElementById('floating_timer').innerHTML = minutes + " : " + seconds;
		}, 1000);
	}
	</script>
</body>
</html>