<?php
function printUser($detail)
{
	$userID = $detail['user_id'];
	$userStatus = $detail['status'];
	echo "<tr>";
	foreach ($detail as $info) 
	{
		if($info == "AttemptedCheating")
			$info = "Cheated";
		elseif($info == "OngoingExamination")
			$info = "Ongoing";
		
		if($info == null)
		{
			echo "<td>N/A</td>";
		}
		else
		{
			echo "<td>$info</td>";
		}

	}

	if($userStatus == 'Finished' || $userStatus == 'AttemptedCheating')
	{

		echo "<td><a href='adminPanel.php?tab=viewAnswers&id=$userID' class='btn btn-success btn-xs'>Results</a>&nbsp;<a href='deleteExaminer.php?examiner_id=$userID' onclick='return areYouSure();' class='btn btn-danger btn-xs'>Delete</a>";
		echo "</td>";
	}
	else
	{
		echo "<td>Unavailable | <a href='deleteExaminer.php?examiner_id=$userID' onclick='return areYouSure();'>Delete</a></td>";
	}

	echo "</tr>";
}
?>

<div class="row">
	<div class="container-fluid">
		<input type="text" placeholder="Search" name="search" id="filter" />
		<a href="#" class="btn btn-primary" onclick="filterExaminer();">Go</a>
	</div>
<script>
	function filterExaminer()
	{
		var filterValue = document.getElementById("filter").value;
		filterValue = filterValue.trim().split(' ').join('+');
		window.location.href = "adminPanel.php?tab=viewExaminers&filter=" + filterValue;
	}
</script>
</div>
<?php  
require 'adminSessionChecker.php';
require '../dbConn.php';

$filter = "all";
$sqlExaminers = "";
if(isset($_GET['filter']))
{
	$filter = $_GET['filter'];
}

if($filter == "all")
{
	$sqlExaminers = "SELECT * FROM userdetails WHERE status <> 'Pending' ORDER BY date_of_testing, firstname, middlename, lastname,age asc";
}
else
{
	$search_term = explode(' ', $filter);
	$sqlExaminers = "SELECT * FROM userdetails WHERE status <> 'Pending' AND (";
	foreach($search_term as $value)
	{
		$value = mysql_real_escape_string($value);
		$sqlExaminers .= "firstname LIKE '$value%' OR ";
	}

	foreach($search_term as $value)
	{
		$value = mysql_real_escape_string($value);
		$sqlExaminers .= "middlename LIKE '$value%' OR ";
	}

	foreach($search_term as $value)
	{
		$value = mysql_real_escape_string($value);
		$sqlExaminers .= "lastname LIKE '$value%' OR ";
	}

	$sqlExaminers = substr($sqlExaminers, 0, -4);
	$sqlExaminers .= ")";
}

$queryExaminers = mysql_query($sqlExaminers) or die(mysql_error());
$totalExaminers = mysql_num_rows($queryExaminers);
echo "<table class='table table-condensed table-hover'>";
echo "<thead>";
echo "<th>User ID</th><th>Username</th><th>Password</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Email Address</th><th>Date Of Birth</th><th>Gender</th><th>Date of Testing</th><th>Age</th><th>Previous School</th><th>Phone</th><th>Course</th><th>Status</th><th>Action</th>";
echo "</thead>";
if(mysql_num_rows($queryExaminers) > 0)
{
	while($row = mysql_fetch_assoc($queryExaminers))
	{
		printUser($row);
	}
}
else
{
	echo "<tr><td colspan='14'><center>Not Available</a></td></tr>";
}

echo "<tr class='info'><td colspan='16'>Total: <b>$totalExaminers</b></td></tr>";
echo "</table>";

mysql_close();
?>



<script type="text/javascript">
	
	function areYouSure() 
	{
		return confirm("Are you sure you want to delete?");
	}
</script>