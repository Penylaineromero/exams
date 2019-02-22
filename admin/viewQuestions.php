<head>
	<style type="text/css">
	.question-filter
	{
		margin-left: 20px;
		height: auto;
		-webkit-border-radius: 20px;
		-moz-border-radius: 20px;
	}

	.search-box
	{
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
	}
	</style>
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
require('../sessionChecker.php');
require('../dbConn.php');

//get all category names
$sqlGetCategories = "SELECT q_cat_name FROM question_category";
$queryGetCategories = mysql_query($sqlGetCategories) or die(mysql_error());
$categories = array();

while($row = mysql_fetch_assoc($queryGetCategories))
{
	array_push($categories, $row['q_cat_name']);
}
$filter = "all";
$sqlFilter = "";
$queryFilter = mysql_query("SELECT * FROM viewquestion");
if(isset($_GET['filter']))
{
	$filter = $_GET['filter'];
}

if($filter == "all")
{
	$sqlFilter = "SELECT * FROM viewquestion";
	$queryFilter = mysql_query($sqlFilter) or die(mysql_error());
}
else
{
	$sqlFilter = "SELECT * FROM viewquestion WHERE q_cat_name='$filter'";
	$queryFilter = mysql_query($sqlFilter) or die(mysql_error());
}

$totalQuestion = mysql_num_rows($queryFilter);
echo "<div class='row' style='position: fixed; float: right; right: 1em; padding-right: 2.5em;'><input type='search' class='search-box' placeholder='Search' name='search' id='search' />&nbsp;<button name='search_btn' class='btn btn-primary' onclick='redirect()'>Go</button></div>";
echo "<a href='adminPanel.php?tab=addNewQuestion' class='btn btn-xs btn-success'>Add Multiple Choice</a>&nbsp;<a href='adminPanel.php?tab=addTrueFalseQuestion' class='btn btn-xs btn-warning'>Add True/False</a>";
echo "<select class='question-filter' onchange='filterPages();' id='filter'>";
echo "<option value='all'>All Questions</option>";
foreach ($categories as $category)
{
	if($filter == $category)
	{
		echo "<option value='$category' selected>$category</option>";
	}
	else
	{
		echo "<option value='$category'>$category</option>";
	}
	
}
echo "</select>";
echo "<table class='table table-condensed table-hover'>";
echo "<thead class='info'><th>Question Category</th><th>Question Text</th><th>Answer</th><th>Action</th></thead>";
if(mysql_num_rows($queryFilter) > 0)
{
	while($row = mysql_fetch_array($queryFilter))
	{
		displayQuestions($row);	
	}

}
else
{
	echo "<tr><td colspan='5'><center>No results found!</center></td></tr>";
}

echo "<tr class='info'><td colspan='5'><u>Total Questions:</u> <b>$totalQuestion</b></td></tr>";
echo "</table>";
mysql_close();
?>

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
	function filterPages()
	{
		var filterValue = document.getElementById("filter").value;
		filterValue = filterValue.trim().split(' ').join('+');
		window.location.href = "adminPanel.php?tab=viewQuestions&filter=" + filterValue;
	}
</script>