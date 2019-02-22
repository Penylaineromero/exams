<?php  
function validDate($dateFrom, $dateTo)
{
	$from_year = $dateFrom['year'];
	$from_month = $dateFrom['month'];
	$from_day = $dateFrom['day'];
	$to_year = $dateTo['year'];
	$to_month = $dateTo['month'];
	$to_day = $dateTo['day'];

	$fromDate = date_create("$from_year-$from_month-$from_day");
	$fromDate = date_format($fromDate, "Y/m/d");

	$toDate = date_create("$to_year-$to_month-$to_day");
	$toDate = date_format($toDate, "Y/m/d");

	if(($fromDate <= $toDate) || (strtotime($fromDate) <= strtotime($toDate)))
	{
		return true;
	}

	return false;
}

function printTopNotchers($details, $rank)
{
	$name = $details['lastname'] . ", " . $details['middlename'] . " " . $details['firstname'];
	$date_of_testing = $details['date_of_testing'];
	$percentage = $details['percentage'];

	echo "<tr>";
	echo "<td>$rank</td><td>$name</td><td>$date_of_testing</td><td>$percentage%</td>";
	echo "</tr>";
}
?>

<?php
	require('../dbConn.php');
	require('adminSessionChecker.php');

	$getFromDate = $_GET['from'];
	$getToDate = $_GET['to'];
	$from = explode('-', $getFromDate);
	$to = explode('-', $getToDate);

	$myFromDate = array();
	$myFromDate['year'] = $from[0];
	$myFromDate['month'] = $from[1];
	$myFromDate['day'] = $from[2];

	$myToDate = array();
	$myToDate['year'] = $to[0];
	$myToDate['month'] = $to[1];
	$myToDate['day'] = $to[2];

	$groupings = $_GET['group'];

	if(validDate($myFromDate, $myToDate))
	{
		if($groupings == "all")
		{
			$sqlTopNotchers = "SELECT user_detail.firstname, user_detail.middlename, user_detail.lastname, user_detail.status, date_format(user_detail.date_of_testing, '%M %e, %Y') as date_of_testing, examiner_percentage.* FROM user_detail, examiner_percentage WHERE date_of_testing >= '$getFromDate' AND date_of_testing <= '$getToDate' AND status='Finished' AND user_detail.user_id = examiner_percentage.user_id ORDER BY percentage DESC, lastname ASC, middlename ASC, firstname ASC";
			$queryTopNotchers = mysql_query($sqlTopNotchers) or die(mysql_error());
		}
		else
		{
			$sqlTopNotchers = "SELECT user_detail.firstname, user_detail.middlename, user_detail.lastname, user_detail.status, date_format(user_detail.date_of_testing, '%M %e, %Y') as date_of_testing, examiner_percentage.* FROM user_detail, groups, examinee_group, examiner_percentage WHERE user_detail.user_id = examinee_group.examiner_id AND groups.group_id = examinee_group.group_id AND user_detail.user_id = examiner_percentage.user_id AND groups.group_id = $groupings AND date_of_testing >= '$getFromDate' AND date_of_testing <= '$getToDate' AND status='Finished' ORDER BY examiner_percentage.percentage DESC, lastname ASC, middlename ASC, firstname ASC";
			$queryTopNotchers = mysql_query($sqlTopNotchers) or die(mysql_error());
		}
		
	}
	else
	{
		die("Invalid date!");
	}
?>



<div class="row">
	<h2>Top-notchers</h2>
	<a href="javascript:window.print()" class="btn btn-primary btn-xs hidden-print"><span class="glyphicon glyphicon-print"></span>&nbsp;Print Results </a><br>
	<b>From: </b>
	<select name="from_month" id="from_month">
		<option value="0" disabled>Month</option>
		<?php  
		$monthArray = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sept', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
		foreach ($monthArray as $key => $value) 
		{
			if($key == $myFromDate['month'])
			{
				echo "<option value='$key' selected>$value</option>";
			}
			else
			{
				echo "<option value='$key'>$value</option>";
			}
		}
		?>
	</select>
	<select name="from_day" id="from_day">
		<option value="0" disabled>Day</option>
		<?php 
		for($i = 1; $i <= 31; $i++)
		{
			if($myFromDate['day'] == $i)
			{
				echo "<option value='$i' selected>$i</option>"; 
			}
			else
			{
				echo "<option value='$i'>$i</option>"; 
			}
		}
		?>
	</select>
	<select name="from_year" id="from_year">
		<option value="0" disabled>Year</option>
		<?php 
		$year = date("Y"); 
		for($i = $year; $i >= 2000; $i--)
		{
			if($i == $myFromDate['year'])
			{
				echo "<option value='$i' selected>$i</option>"; 
			}
			else
			{
				echo "<option value='$i'>$i</option>";
			}
		}
		
		?>
	</select>
	<b>To: </b>
	<select name="to_month" id="to_month">
		<option value="0" disabled>Month</option>
		<?php
		$monthArray = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sept', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
		foreach ($monthArray as $key => $value) 
		{
			if($key == $myToDate['month'])
			{
				echo "<option value='$key' selected>$value</option>";
			}
			else
			{
				echo "<option value='$key'>$value</option>";
			}
		}
		?>
	</select>
	<select name="to_day" id="to_day">
		<option value="0" disabled>Day</option>
		<?php 
		for($i = 1; $i <= 31; $i++)
		{
			if($myToDate['day'] == $i)
			{
				echo "<option value='$i' selected>$i</option>"; 
			}
			else
			{
				echo "<option value='$i'>$i</option>"; 
			}
		}
		?>
	</select>
	<select name="to_year" id="to_year">
		<option value="0" disabled>Year</option>
		<?php 
		$year = date("Y");
		for($i = $year; $i >= 2000; $i--)
		{
			if($i == $myToDate['year'])
			{
				echo "<option value='$i' selected>$i</option>"; 
			}
			else
			{
				echo "<option value='$i'>$i</option>";
			}
		}
		
		?>
	</select>
	<b>Group: </b>
	<select name="group_id" id="groupings">
		<?php
			if($groupings == "all")
			{
				echo "<option value='all' selected>All</option>";
			}
			else
			{
				echo "<option value='all'>All</option>";
			}
			require('../dbConn.php');

			$sqlGetGroups = "SELECT * FROM groups";
			$queryGetGroups = mysql_query($sqlGetGroups) or die(mysql_error());

			while($row = mysql_fetch_assoc($queryGetGroups))
			{
				if($row['group_id'] == $groupings)
				{
					echo "<option value='" . $row['group_id'] . "' selected>" . $row['group_name'] . "</option>";
				}
				else
				{
					echo "<option value='" . $row['group_id'] . "'>" . $row['group_name'] . "</option>";
				}
				
			}

		?>
	</select>	
	<input type="button" class="hidden-print" value="Go" name="btn_go" onclick="loadDate();" />
	<span id="error" style="color: red;"></span>
</div>

<div class="row" id="list">
	<table class="table table-condensed table-hover table-striped">
		<thead><tr class="info"><td>Rank</td><td>Name</td><td>Date of Testing</td><td>Percentage</td></tr></thead>
			<?php
			if(mysql_num_rows($queryTopNotchers) > 0)
			{
				$rank = 1;
				while($row = mysql_fetch_array($queryTopNotchers))
				{
					printTopNotchers($row, $rank);
					$rank++;
				}
			}
			else
			{
				echo "<tr><td colspan='4'><center>No results found</center></td></tr>";
			}
			?>
	</table>
</div>
<script type="text/javascript">
function loadDate()
{
	var from_month = document.getElementById("from_month").value;
	var from_day = document.getElementById("from_day").value;
	var from_year = document.getElementById("from_year").value;

	var to_month = document.getElementById("to_month").value;
	var to_day = document.getElementById("to_day").value;
	var to_year = document.getElementById("to_year").value;

	var from_date = (from_year + "-" + from_month + "-" + from_day);
	var to_date = (to_year + "-" + to_month + "-" + to_day);
	var groupings = document.getElementById('groupings').value;

	if(from_date <= to_date && (from_month > 0 && from_day > 0 && from_year > 0 && to_month > 0 && to_day > 0 && to_year > 0))
	{
		window.location.href = "adminPanel.php?tab=filter&from=" + from_date + "&to=" + to_date + "&group=" + groupings;
	}
	else
	{
		document.getElementById("error").innerHTML = "Invalid Date!";
	}

	
}
</script>