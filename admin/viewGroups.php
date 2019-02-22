<?php  
function displayGroups($details)
{
	$group_id = $details['group_id'];
	$group_name = $details['group_name'];

	echo "<tr>";
	echo "<td>" . $group_name . "</td>";

	echo "<td><a href='adminPanel.php?tab=editGroup&group_id=" . $group_id . "' class='btn btn-xs btn-warning'>Update</a>&nbsp;<a href='deleteGroup.php?id=$group_id' onclick='return areYouSure();' class='btn btn-xs btn-danger'>Delete</a>&nbsp;<a href='adminPanel.php?tab=viewQuestionGroups&group_id=" . $group_id . "' class='btn btn-xs btn-default'>Questions</a>&nbsp;<a href='adminPanel.php?tab=viewExaminerGroups&group_id=" . $group_id . "' class='btn btn-xs btn-primary'>Examiners</a></td>";
	echo "</tr>";
}
?>

<?php
require('../sessionChecker.php');
require('../dbConn.php');

//get all category names
$sqlGetGroups = "SELECT * FROM groups";
$queryGetGroups = mysql_query($sqlGetGroups) or die(mysql_error());
$totalGroups = mysql_num_rows($queryGetGroups);

echo "<a href='adminPanel.php?tab=addNewGroup' class='btn btn-success btn-xs'>New Group</a>";
echo "<table class='table table-condensed table-hover'>";
echo "<thead class='info'><th>Group Name</th><th>Action</th></thead>";
if($totalGroups > 0)
{
	while($row = mysql_fetch_array($queryGetGroups))
	{
		displayGroups($row);	
	}

}
else
{
	echo "<tr><td colspan='5'><center>No results found!</center></td></tr>";
}

echo "<tr class='info'><td colspan='5'><u>Total Groups:</u> <b>$totalGroups</b></td></tr>";
echo "</table>";
mysql_close();
?>

<script type="text/javascript">

	function areYouSure()
	{
		var dialogConfirm = window.confirm("Are you sure you want to delete?");

		return dialogConfirm;
	}
</script>