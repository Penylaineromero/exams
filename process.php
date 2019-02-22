<?php  
require('dbConn.php');
require('sessionChecker.php');
$user_id = $_SESSION['user_id'];
$question_id = $_SESSION['question_id'];
$examiner_answers = array();
$current_category = $_POST['current_category'];


//get what the examiners chose as an answer
foreach($question_id as $key)
{
	if(isset($_POST[$key]))
	{
		$examiner_answers[$key] = $_POST[$key];
	}
	else
	{
		$examiner_answers[$key] = "skipped_question";
	}
}

//update the examiner's answer to the database
$sqlUpdateExaminerAnswer = "UPDATE examiner_answer SET answer_text = CASE q_id ";
$ids = implode(',', array_keys($examiner_answers));
foreach ($examiner_answers as $key => $value)
{
	$value = mysql_real_escape_string($value);
	$sqlUpdateExaminerAnswer .= sprintf("WHEN '%s' THEN '%s' ", $key, $value);
}

$sqlUpdateExaminerAnswer .= "END WHERE q_id IN ($ids) AND user_id = '$user_id' AND q_cat_id = '$current_category'";

$queryUpdateExaminerAnswer = mysql_query($sqlUpdateExaminerAnswer) or die("Error in sqlUpdateExaminerAnswer");

$nextValue = 0;
for($x = 0; $x < count($_SESSION['category']); $x++)
{
	if($_SESSION['category'][$x] == $current_category)
	{
			$nextValue = $x + 1;
	}
}

if($nextValue < count($_SESSION['category']))
{
	$next_category = $_SESSION['category'][$nextValue];
	$next_category = base64_encode($next_category);
	header("Location: exam.php?cat=$next_category");
	die();
}
else
{
	// update status to Finished for examiner if he/she successfully answered all the categories
	$sqlUpdateStatus = "UPDATE user_detail SET status='Finished' WHERE user_id='$user_id'";
	mysql_query($sqlUpdateStatus) or die("Error in sqlUpdateStatus");
	header("Location: userPanel.php?tab=viewResults");
	die();
}