<?php  
function printPendingApplicants($userDetails)
{
	$userID = $userDetails[0];
	$userStatus = $userDetails[10];
	echo "<tr>";
	foreach ($userDetails as $info) 
	{
		if($info == null)
		{
			echo "<td>N/A</td>";
		}
		else
		{
			echo "<td>$info</td>";
		}

	}

	echo "<td><a href='approve.php?id=$userID' class='btn btn-xs btn-success'>Approve</a></td>";
	echo "</tr>";

}
?>
<head>
	<script type="text/javascript">
		function approveUser()
		{
			var i = confirm();
		}
	</script>
</head>


<?php  
require('../dbConn.php');
require('adminSessionChecker.php');

$sqlViewPendingApplicants = "SELECT user_id,firstname,middlename,lastname,email,birthday,gender,date_of_testing,age,previous_school,phone,status FROM userdetails WHERE status='Pending'";
$queryViewPendingApplicants = mysql_query($sqlViewPendingApplicants) or die(mysql_error());

echo "<table class='table table-condensed table-hover'>";
echo "<thead>";
echo "<th>User ID</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Email Address</th><th>Date Of Birth</th><th>Gender</th><th>Date of Testing</th><th>Age</th><th>Previous School</th><th>Phone</th><th>Status</th><th>Action</th>";
echo "</thead>";

if(mysql_num_rows($queryViewPendingApplicants) > 0)
{
	while($row = mysql_fetch_row($queryViewPendingApplicants))
	{
		printPendingApplicants($row);
	}
}
else
{
	echo "<tr><td colspan='13'><center>No Pending Applicants</a></td></tr>";
}
echo "</table>";

mysql_close();
?>