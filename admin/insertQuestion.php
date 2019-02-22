<?php  
	require('../dbConn.php');
	require('adminSessionChecker.php');

	if(isset($_POST['btn_insert']))
	{

		$q_cat_id = $_POST['cat'];
		$question_text = mysql_real_escape_string($_POST['q_text']);
 	
		$sqlInsertQuestion = "INSERT INTO question(q_cat_id,q_text) VALUES ('$q_cat_id','$question_text')";
		$queryInsertQuestion = mysql_query($sqlInsertQuestion) or die(mysql_error());
		$q_id = mysql_insert_id();
		
		$correctAnswer = mysql_real_escape_string($_POST['correct_answer1']);
		$wrongAnswers = array();
		$sqlInsertAnswer = "INSERT INTO answer(q_id,correct_answer) VALUES ('$q_id', '$correctAnswer')";
		$queryAnswer = mysql_query($sqlInsertAnswer) or die(mysql_error());
		$sqlInsertChoices = "INSERT INTO choices(q_id,choice_text) VALUES ('$q_id', '$correctAnswer')";
		$queryChoices = mysql_query($sqlInsertChoices) or die(mysql_error());

		for($i = 1; $i <= 4; $i++)
		{
			$wrong_ans = "wrong_answer";
			$wrong_ans .= $i;
			if(isset($_POST[$wrong_ans]))
			{
				array_push($wrongAnswers,mysql_real_escape_string($_POST[$wrong_ans]));
			}
		}

		$sqlInsertChoices = "INSERT INTO choices(q_id, choice_text) VALUES";
		foreach ($wrongAnswers as $value) 
		{
			$sqlInsertChoices .= "('$q_id', '$value'),";
		}

		$sqlInsertChoices[strlen($sqlInsertChoices) - 1] = "";
		$queryInsertChoices = mysql_query($sqlInsertChoices) or die(mysql_error());
		mysql_close();
		header('Location: adminPanel.php?tab=viewQuestions&filter=all');
		die();
	}
?>