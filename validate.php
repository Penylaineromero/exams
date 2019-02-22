<?php
require('dbConn.php');
require('sessionChecker.php');

function examinerStatus($user_id)
{
	$sqlStatus = "SELECT status FROM user_detail WHERE user_id='$user_id'";
	$queryStatus = mysql_query($sqlStatus) or die("Error while getting status");
	$row = mysql_fetch_assoc($queryStatus);
	$status = $row['status'];

	return $status;
}
$user_id = $_SESSION['user_id'];
$group_id = $_SESSION['group_id'];



//check the examiner status
$status = examinerStatus($user_id);
if($status == "Pending") 
{
	header("Location: userPanel.php?tab=error&code=verify");
	die();
}
elseif($status == "AttemptedCheating")
{
	header("Location: userPanel.php?tab=error&code=cheat");
	die();
}
elseif($status == "OngoingExamination")
{
	header("Location: userPanel.php?tab=error&code=closed");
	die();
}
elseif($status == "Finished" && $date_of_testing != null) 
{
	header("Location: userPanel.php?tab=viewResults");
	die();
}
elseif($status == "Approved")
{

	//check if Approved but has no group yet.
	$sqlGetGroup = "SELECT * FROM examinee_group WHERE examiner_id = $user_id";
	$queryGetGroup = mysql_query($sqlGetGroup) or die(mysql_error());

	$has_group = mysql_num_rows($queryGetGroup);

	if(!$has_group)
	{
		header("Location: userPanel.php?tab=error&code=nogroup");
		die();
	}

	//check if db has questions

	$sqlGetQuestions = "SELECT COUNT(*) FROM question_group WHERE group_id=$group_id";
	$queryGetQuestions = mysql_query($sqlGetQuestions) or die(mysql_error());

	$questionCount = mysql_fetch_array($queryGetQuestions)[0];

	if($questionCount <= 0)
	{
		header("Location: userPanel.php?tab=error&code=question_incomplete");
		die();
	}

	$sqlGetCategories = "SELECT DISTINCT question_category.* FROM question_category, question, question_group, groups WHERE question_category.q_cat_id = question.q_cat_id AND question.q_id = question_group.question_id AND groups.group_id = question_group.group_id AND groups.group_id = $group_id";

	$queryGetCategories = mysql_query($sqlGetCategories) or die(mysql_error());
	$question_cat_id = array();
	while($row = mysql_fetch_assoc($queryGetCategories))
	{
		array_push($question_cat_id, $row['q_cat_id']);
	}

	//check if examiner_answer table is null
	$sqlCheckAnswers = "SELECT user_id FROM examiner_answer WHERE user_id='$user_id'";

	$queryCheckAnswers = mysql_query($sqlCheckAnswers) or die(mysql_error());
	$row = mysql_fetch_array($queryCheckAnswers);

	$sqlInserToCategoriesAnswered = "INSERT INTO categories_answered (user_id,q_cat_id) VALUES ";
	//if no insertion queries are inserted
	if(is_null($row[0]))
	{
		$sqlInsertToExaminerScore = "INSERT INTO examiner_score(user_id,q_cat_id,score, total_items) VALUES";
		foreach($question_cat_id as $category)
		{
			$questionID = array();
			$sqlInsertToExaminerAnswers = "INSERT INTO examiner_answer(q_cat_id, user_id, q_id) VALUES";
			$sqlQuestionID = "SELECT q_id FROM question, question_group, groups WHERE q_cat_id='$category' AND question.q_id = question_group.question_id AND groups.group_id = question_group.group_id AND groups.group_id = $group_id";
			$queryQuestionID = mysql_query($sqlQuestionID) or die(mysql_error());
			$total_items = mysql_num_rows($queryQuestionID);

			while($row = mysql_fetch_assoc($queryQuestionID))
			{
				array_push($questionID, $row['q_id']);
			}

			foreach($questionID as $qid)
			{
				$sqlInsertToExaminerAnswers .= "('$category','$user_id', '$qid'),";
			}


			//remove unnecessary comma at the end of the sql string.
			$sqlInsertToExaminerAnswers[strlen($sqlInsertToExaminerAnswers) - 1] = "";
			mysql_query($sqlInsertToExaminerAnswers);
			unset($questionID);

			$sqlInsertToExaminerScore .= "('$user_id', '$category', '0', '$total_items'),";
			$sqlInserToCategoriesAnswered .= "('$user_id', '$category'),";
		}

		$sqlInserToCategoriesAnswered[strlen($sqlInserToCategoriesAnswered) - 1] = "";
		mysql_query($sqlInserToCategoriesAnswered) or die(mysql_error());
		$sqlInsertToExaminerScore[strlen($sqlInsertToExaminerScore) - 1] = "";
		mysql_query($sqlInsertToExaminerScore) or die(mysql_error());

		$dateNow = date("Y-m-d");
		$sqlUpdateExaminerStatus = "UPDATE user_detail SET date_of_testing='$dateNow', status='OngoingExamination' WHERE user_id='$user_id'";
		mysql_query($sqlUpdateExaminerStatus) or die(mysql_error());

		$sqlInsertUserPercentage = "INSERT INTO examiner_percentage (user_id, percentage) VALUES ('$user_id', '0')";
		$updateUserPercentage = mysql_query($sqlInsertUserPercentage) or die(mysql_error());
		mysql_close();
		
			//----------randomizes category
		shuffle($question_cat_id);
		$_SESSION['category'] = $question_cat_id;
		$id = base64_encode($_SESSION['category'][0]);
		header("Location: exam.php?cat=$id");
		die();
	} 
	else
	{
		echo "<script>window.location.href='userPanel.php?tab=error&code=incomplete';</script>";
		die();
	}
}