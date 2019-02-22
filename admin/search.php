<head>
	<script type="text/javascript">

	function areYouSure()
	{
		var dialogConfirm = window.confirm("Are you sure you want to delete?");

		return dialogConfirm;
	}

	function redirect()
	{
		var searchText = document.getElementById("search").value;
		searchText = searchText.trim().split(' ').join('+');
		window.location.href = "adminPanel.php?tab=search&value=" + searchText;
	}
	</script>
</head>

<?php  
function displayQuestions($details)
{
	$category = $details[0];
	$q_id = $details[1];
	$questionText = $details[2];
	$answer = $details[3];

	echo "<tr><td>$category</td><td>$questionText</td>";
	echo "<td>$answer</td>";
	echo "<td><a href='adminPanel.php?tab=editQuestion&qid=$q_id' class='btn btn-xs btn-warning'>Update</a>&nbsp;<a href='delete.php?id=$q_id' onclick='return areYouSure();' class='btn btn-xs btn-danger'>Delete</a>&nbsp;</td>";
	echo "</tr>";
}
?>

<?php
	require('../dbConn.php');
	if(empty($_GET['text']))
	{
		$sqlSearch = "SELECT * FROM viewquestion";
		$querySearch = mysql_query($sqlSearch) or die(mysql_error());

		echo "<div class='row'><div class='form-group col-xs-6'><input type='search' placeholder='Search' name='search' id='search' /> <button name='search_btn' class='btn btn-primary' onclick='redirect()'>Go</button></div></div>";
		echo "<a href='adminPanel.php?tab=addNewQuestion' class='btn btn-success'>Add New Question</a>";
		echo "<table class='table table-condensed table-hover'>";
		echo "<tr class='info'><th>Question Category</th><th>Question Text</th><th>Action</th></tr>";
		while($row = mysql_fetch_array($querySearch))
		{
			displayQuestions($row);
		}

		echo "</table>";
	}
	
	if(isset($_GET['text']))
	{
		
		$searchText = $_GET['text'];
		$sqlSearch = "SELECT * FROM question WHERE q_text LIKE '$searchText%'";
		$querySearch = mysql_query($sqlSearch) or die(mysql_error());
		$queryID = array();
		while($row = mysql_fetch_array($querySearch))
		{
			$qid = $row['q_id'];
			if(!in_array($qid, $queryID))
			{
				array_push($queryID, $qid);
			}
		}

		$sqlSearch = "SELECT * FROM answer WHERE correct_answer LIKE '$searchText%'";
		$querySearch = mysql_query($sqlSearch) or die(mysql_error());

		while($row = mysql_fetch_array($querySearch))
		{
			$qid = $row['q_id'];
			if(!in_array($qid, $queryID))
			{
				array_push($queryID, $qid);
			}
		}

		$queryID = implode(',',array_values($queryID));

		if(!empty($queryID))
		{
			$sqlSearch = "SELECT * FROM viewquestion WHERE q_id IN ($queryID)";
			$querySearch = mysql_query($sqlSearch) or die("Error here. . .");

			echo "<div class='row'><div class='form-group col-xs-6'><input type='search' placeholder='Search' name='search' id='search' /> <button name='search_btn' class='btn btn-primary' onclick='redirect()'>Go</button></div></div>";
			echo "<a href='adminPanel.php?tab=addNewQuestion' class='btn btn-success'>Add New Question</a>";
			echo "<table class='table table-condensed table-hover'>";
			echo "<tr class='info'><th>Question Category</th><th>Question Text</th><th>Answer</th><th>Action</th></tr>";
			while($row = mysql_fetch_array($querySearch))
			{
				displayQuestions($row);
			}

			echo "</table>";
		}
		else
		{
			echo "<div class='row'><div class='form-group col-xs-6'><input type='search' placeholder='Search' name='search' id='search' /> <button name='search_btn' class='btn btn-primary' onclick='redirect()'>Go</button></div></div>";
			echo "<a href='adminPanel.php?tab=addNewQuestion' class='btn btn-success'>Add New Question</a>";
			echo "<table class='table table-condensed table-hover'>";
			echo "<tr class='info'><th>Question Category</th><th>Question Text</th><th>Answer</th><th>Action</th></tr>";
			echo "<tr><td>No results found!</td></tr>";
			echo "</table>";
		}
	}
	mysql_close();
?>