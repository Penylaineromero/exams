<?php
require('../dbConn.php');
require('adminSessionChecker.php');

$existing_questions = [];
$group_id = $_GET['group_id'];

$sqlGetGroupName = "SELECT * FROM groups WHERE group_id = $group_id";
$queryGetGroupName = mysql_query($sqlGetGroupName) or die(mysql_error());

$group_name = mysql_fetch_assoc($queryGetGroupName)['group_name'];

$sqlGetGroupQuestions = "SELECT * FROM view_question_group WHERE group_id='$group_id'";
$queryGetGroupQuestions = mysql_query($sqlGetGroupQuestions) or die(mysql_error());

$sqlGetQuestions = "SELECT * FROM view_question_group WHERE group_id = $group_id";
$sqlGetQuestionsNotHere = "SELECT * FROM viewquestion";

if(mysql_num_rows($queryGetGroupQuestions) > 0)
{
	while($row = mysql_fetch_assoc($queryGetGroupQuestions)) 
	{
		$existing_questions[] = $row['q_id'];
	}

	if(count($existing_questions) > 0)
	{
		$existing_questions = implode(',', $existing_questions);
		$sqlGetQuestions = "SELECT * FROM viewquestion WHERE viewquestion.q_id IN ($existing_questions)";
		$sqlGetQuestionsNotHere = "SELECT * FROM viewquestion WHERE q_id NOT IN ($existing_questions)";
	}

}

$queryGetQuestions = mysql_query($sqlGetQuestions) or die(mysql_error());
$queryGetQuestionNotHere = mysql_query($sqlGetQuestionsNotHere) or die(mysql_error());

echo "<h2>$group_name Questions</h2>";

function displayQuestions($details, $add_here = false, $group_id = null)
{
	$category = $details[0];
	$q_id = $details[1];
	$questionText = $details[2];
	$answer = $details[3];

	echo "<tr><td>$category</td><td>$questionText</td>";
	echo "<td>$answer</td>";
	echo "<td>";

	if($add_here)
	{
		echo "<a href='addToGroup.php?group_id=$group_id&question_id=$q_id' class='btn btn-xs btn-success'>Add here</a>&nbsp;";
		echo "<a href='adminPanel.php?tab=editQuestion&qid=$q_id' class='btn btn-xs btn-warning'>Update</a>&nbsp;";
		echo "<a href='delete.php?id=$q_id' onclick='return areYouSure();' class='btn btn-xs btn-danger'>Delete</a>&nbsp;";
	}
	else
	{
		echo "<a href='adminPanel.php?tab=editQuestion&qid=$q_id' class='btn btn-xs btn-warning'>Update</a>&nbsp;";
		echo "<a href='removeFromGroup.php?group_id=$group_id&question_id=$q_id' onclick='return confirmRemove();' class='btn btn-xs btn-danger'>Remove</a>&nbsp;";
	}

	
	

	echo "</td>";
	echo "</tr>";
}

echo "<table class='table table-condensed table-hover'>";
echo "<thead class='info'><th>Question Category</th><th>Question Text</th><th>Answer</th><th>Action</th></thead>";
if(mysql_num_rows($queryGetQuestions) > 0)
{
	while($row = mysql_fetch_array($queryGetQuestions))
	{
		displayQuestions($row, false, $group_id);	
	}

}
else
{
	echo "<tr><td colspan='5'><center>No results found!</center></td></tr>";
}
echo "</table>";


echo "<h2>Add more questions in this group</h2>";
echo "<table class='table table-condensed table-hover'>";
echo "<thead class='info'><th>Question Category</th><th>Question Text</th><th>Answer</th><th>Action</th></thead>";

if(mysql_num_rows($queryGetQuestionNotHere) > 0)
{
	while($row = mysql_fetch_array($queryGetQuestionNotHere))
	{
		displayQuestions($row, true, $group_id);
	}
}
else
{
	echo "<tr><td colspan='5'><center>No more questions to add!</center></td></tr>";
}

mysql_close();
?>

<script type="text/javascript">

	function areYouSure()
	{
		var dialogConfirm = window.confirm("Are you sure you want to delete?");

		return dialogConfirm;
	}

	function confirmRemove()
	{
		var dialog_confirm = window.confirm("Are you sure you want to remove this question from this group?");

		return dialog_confirm;
	}

	function redirect()
	{
		var searchText = document.getElementById("search").value;
		searchText = searchText.trim().split(' ').join('+');
		window.location.href = "adminPanel.php?tab=search&value=" + searchText;
	}

	function filterPages()
	{
		var filterValue = document.getElementById("filter").value;
		filterValue = filterValue.trim().split(' ').join('+');
		window.location.href = "adminPanel.php?tab=viewQuestions&filter=" + filterValue;
	}
</script>
