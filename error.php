<?php  
	
	$error = array();
	$error['verify'] = '<p>It seems like you are not yet verified by the administrator.</p>';
	$error['noexam'] = "<p>It seems like you have not yet taken the exam.</p>";
	$error['cheat'] = "<p>It seems like you attempted to cheat by switching tabs or hitting the refresh or minimizing the browser. Did you read the instructions?</p>";
	$error['question_incomplete'] = "<p>Sorry, taking an examination is unavailable at the moment. Please try again later.";
	$error['incomplete'] = "<p>It seems like you already took the exam. It was either you attempted to cheat or you failed to answer all the categories.";
	$error['closed'] = "<p>It seems like you or something closed the browser while taking the exam.</p>";
	$error['nogroup'] = "<p>It seems like you are not yet assigned to an examination group. Please contact the administrator.</p>";
	if(isset($_GET['code']))
	{
		echo "<div class='jumbotron' style='background-color: #fff; !important;'>";
		$error_code = $_GET['code'];
		echo "<b style='font-size: 5em; color: red !important;'>Error:</b>"	;
		echo $error[$error_code];
		echo "</div>";
	}

?>


