<?php
	require('dbConn.php');
	require('sessionChecker.php');
	function getTime()
	{
		$sqlGetTime = "SELECT hours, minutes, seconds FROM time_limit";
		$queryGetTime = mysql_query($sqlGetTime);
		$row = mysql_fetch_array($queryGetTime);

		$hours = intval($row['hours']);
		$minutes = intval($row['minutes']);
		$seconds = $row['seconds'];

		$time = array();
		$time['hours'] = $hours;
		$time['minutes'] = $minutes;
		$time['seconds'] = $seconds;

		return $time;
	}

	function examinerStatus()
	{
		$user_id = $_SESSION['user_id'];
		$sqlStatus = "SELECT status FROM user_detail WHERE user_id='$user_id'";
		$queryStatus = mysql_query($sqlStatus) or die("Error while getting status");
		$row = mysql_fetch_assoc($queryStatus);
		$status = $row['status'];
		
		return $status;
	}

	$examinerStatus = examinerStatus();
	if($examinerStatus == "Finished")
	{
		//redirect to view results since examiner already finished taking the exam
		echo "<script>window.location.href='userPanel.php?tab=viewResults';";
		die();
	}
	elseif($examinerStatus == "Pending")
	{
		echo "<script>window.location.href='userPanel.php?tab=error&code=verify';</script>";
		die();
	}
	elseif($examinerStatus == "OngoingExamination")
	{
		echo "<script>window.location.href='userPanel.php?tab=error&code=closed';</script>";
		die();
	}
?>

<div class="row">
	<h2>General Instructions: </h2>
	<ul>
		<li><p>Time limit is <?php $time = getTime(); echo "<b><u>" . $time['minutes'] . "</u></b>"; ?> minute(s) for each question category.</p></li>
		<li><p><u>Resizing the browser</u> , <u>Minimizing the browser</u> , <u>changing browser tabs</u> , <u>refreshing the browser</u> and <u>hitting the back button</u> is considered cheating.</p></li>
		<li><p>You can only take the exam once. Once you click the "Take Exam Now" button, you will not be able to take the exam again.</p></li>
		<li><p>If ever the time runs out and you have not answered all the questions, you will be re-directed to the next category.</p></li>
		<li><p>You can view results after you have completed answering all question categories.</p></li>
	</ul>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="btn_go" value="Take Exam Now" class="btn btn-success" onclick="window.location.href='validate.php'"/>
</div>