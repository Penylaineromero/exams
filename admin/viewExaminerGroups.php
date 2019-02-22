<?php
require('../dbConn.php');
require('adminSessionChecker.php');

$existing_examiners = [];
$group_id = $_GET['group_id'];

$sqlGetGroupName = "SELECT * FROM groups WHERE group_id = $group_id";
$queryGetGroupName = mysql_query($sqlGetGroupName) or die("Error: " . mysql_error());

$group_name = mysql_fetch_assoc($queryGetGroupName)['group_name'];

$sqlGetGroupExaminers = "SELECT * FROM view_examiner_group WHERE group_id='$group_id'";
$queryGetGroupExaminers = mysql_query($sqlGetGroupExaminers) or die(mysql_error());

$sqlGetExaminers = "SELECT * FROM view_examiner_group WHERE group_id = $group_id"	;
$sqlGetExaminersNotHere = "SELECT * FROM userdetails";

if(mysql_num_rows($queryGetGroupExaminers) > 0)
{
	while($row = mysql_fetch_assoc($queryGetGroupExaminers)) 
	{
		$existing_examiners[] = $row['user_id'];
	}

	if(count($existing_examiners) > 0)
	{
		$existing_examiners = implode(',', $existing_examiners);
		$sqlGetExaminers = "SELECT * FROM userdetails WHERE user_id IN ($existing_examiners)";
		$sqlGetExaminersNotHere = "SELECT * FROM userdetails WHERE user_id NOT IN ($existing_examiners) AND (status = 'Approved' OR status = 'Pending')";
	}

}

$queryGetExaminers = mysql_query($sqlGetExaminers) or die(mysql_error());
$queryGetExaminersNotHere = mysql_query($sqlGetExaminersNotHere) or die(mysql_error());

echo "<h2>$group_name Examiners</h2>";
echo "<table class='table table-condensed table-hover'>";
echo "<thead>";
echo "<th>Username</th><th>Password</th><th>Full Name</th><th>Gender</th><th>Date of Testing</th><th>Previous School</th><th>Phone</th><th>Status</th><th>Action</th>";
echo "</thead>";
$totalExaminers = mysql_num_rows($queryGetExaminers);
if($totalExaminers > 0)
{
	while($row = mysql_fetch_assoc($queryGetExaminers))
	{
		printUser($row, false, $group_id);
	}
}
else
{
	echo "<tr><td colspan='14'><center>No examiners in this group yet.</a></td></tr>";
}

echo "<tr class='info'><td colspan='16'>Total: <b>$totalExaminers</b></td></tr>";
echo "</table>";

echo "<h2>Add more examiners in this group</h2>";
echo "<table class='table table-condensed table-hover'>";
echo "<thead>";
echo "<th>Username</th><th>Password</th><th>Full Name</th><th>Gender</th><th>Date of Testing</th><th>Previous School</th><th>Phone</th><th>Status</th><th>Action</th>";
echo "</thead>";
$loopableExaminers = mysql_num_rows($queryGetExaminersNotHere);
$totalExaminers = 0;
if($loopableExaminers > 0)
{
	while($row = mysql_fetch_assoc($queryGetExaminersNotHere))
	{
		if(!user_is_in_a_group($row['user_id'])) {
			printUser($row, true, $group_id);
			$totalExaminers++;
		}
	}

	if($totalExaminers == 0)
	{
		echo "<tr><td colspan='14'><center>No more examiners to add.</a></td></tr>";
	}
}
else
{
	echo "<tr><td colspan='14'><center>No more examiners to add.</a></td></tr>";
}

echo "<tr class='info'><td colspan='16'>Total: <b>$totalExaminers</b></td></tr>";
echo "</table>";
mysql_close();

function printUser($detail, $add_here = false, $group_id = null)
{
	$userID = $detail['user_id'];
	$username = $detail['username'];
	$password = $detail['password'];
	$firstname = $detail['firstname'];
	$middlename = $detail['middlename'];
	$lastname = $detail['lastname'];
	$email = $detail['email'];
	$birthday = $detail['birthday'];
	$gender = $detail['gender'];
	$date_of_testing = $detail['date_of_testing'];
	$age = $detail['age'];
	$previous_school = $detail['previous_school'];
	$phone = $detail['phone'];
	$course_name = $detail['course_name'];
	$status = $detail['status'];
	$result_class = '';
	$confirm_dialog = $add_here ? "return areYouSure();" : "return confirmRemove()";
	$add_to_group = "<a href='addToExaminerGroup.php?group_id=$group_id&examiner_id=$userID' class='btn btn-success btn-xs'>Add here</a>&nbsp;";

	echo "<tr>";
	if($status == "AttemptedCheating")
		$status = "Cheated";
	elseif($status == "OngoingExamination")
		$status = "Ongoing";

	echo "<td>" . $username . "</td>";
	echo "<td>" . $password . "</td>";
	echo "<td>" . $firstname . " " . $middlename . " " . $lastname . "</td>";
	echo "<td>" . $gender . "</td>";
	echo "<td>" . (($date_of_testing) ? $date_of_testing : "N/A") . "</td>";
	echo "<td>" . $previous_school . "</td>";
	echo "<td>" . $phone . "</td>";
	echo "<td>" . $status . "</td>";

	if($status == 'Finished' || $status == 'AttemptedCheating')
	{
		$result_class = "btn btn-success btn-xs";
	}
	else
	{
		$result_class = "btn btn-success btn-xs disabled";
	}

	echo "<td>";
	if($add_here)
		echo $add_to_group;
	
	echo "<a href='adminPanel.php?tab=viewAnswers&id=$userID' class='$result_class'>Results</a>&nbsp;";
	if(!$add_here)
		echo "<a href='removeExaminerFromGroup.php?examiner_id=$userID&group_id=$group_id' onclick='$confirm_dialog' class='btn btn-danger btn-xs'>Remove</a>";
	echo "</td>";

	echo "</tr>";
}

function user_is_in_a_group($user_id)
{
	$sqlGetStatus = "SELECT * FROM examinee_group WHERE examiner_id = $user_id";
	$queryGetStatus = mysql_query($sqlGetStatus) or die(mysql_error());

	if(mysql_num_rows($queryGetStatus) > 0)
	{
		return true;
	}

	return false;
}
?>
<script type="text/javascript">

	function areYouSure()
	{
		var dialogConfirm = window.confirm("Are you sure you want to delete?");

		return dialogConfirm;
	}

	function confirmRemove()
	{
		var dialog_confirm = window.confirm("Are you sure you want to remove this examiner from this group?");

		return dialog_confirm;
	}

</script>
