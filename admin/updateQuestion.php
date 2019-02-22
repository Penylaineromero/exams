<?php  
	session_start();
	require '../dbConn.php';

	if(isset($_POST['btn_save']))
	{

		$question_text = mysql_real_escape_string($_POST['question_text']);
		$q_id = $_POST['id'];
				
		$category_id = $_POST['cat'];
		$choices = $_SESSION['choices'];
		$answer[$_POST['answer_id']] = $_POST['answer_text'];
		foreach ($choices as $key => $value) 
		{
			$choices[$key] = $_POST["choice" . $key];
		}

		$choice_id = implode(',', array_keys($choices));
		$answer_id = implode(',', array_keys($answer));
		unset($_SESSION['choices']);

		//update questions
		$sqlUpdateQuestion = "UPDATE question SET q_text = '" . $question_text . "', q_cat_id='" . $category_id . "' WHERE q_id = '" . $q_id . "'";
		$query = mysql_query($sqlUpdateQuestion) or die(mysql_error());

		if(mysql_affected_rows() > 0)
		{
			echo "Successfully updated questions";
		}

		$sqlChoices = "UPDATE choices SET choice_text = CASE choice_id ";
		foreach ($choices as $id => $text)
		{
			$text = mysql_real_escape_string($text);
			$sqlChoices .= sprintf("WHEN '%s' THEN '%s' ",$id,$text);
		}

		$sqlChoices .= "END WHERE choice_id IN ($choice_id) AND q_id=$q_id";
		echo $sqlChoices;
		$queryChoices = mysql_query($sqlChoices) or die(mysql_error());

		if(mysql_affected_rows() > 0)
		{
			echo "Updated choices";
		}

		$sqlAnswer = "UPDATE answer SET correct_answer = CASE answer_id ";
		foreach ($answer as $id => $text) 
		{
			$text = mysql_real_escape_string($text);
			$sqlAnswer .= sprintf("WHEN '%s' THEN '%s' ",$id,$text);
		}

		$sqlAnswer .= "END WHERE answer_id IN ($answer_id) AND q_id=$q_id";
		echo $sqlAnswer;
		$queryAnswer = mysql_query($sqlAnswer) or die(mysql_error());

		if(mysql_affected_rows() > 0)
		{
			echo "Updated answer";
		}
	}

	mysql_close();
	header('Location: adminPanel.php?tab=viewQuestions&filter=all');
	die();
?>