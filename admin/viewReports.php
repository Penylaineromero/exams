<script type="text/javascript">
	
	function loadTopNotchers()
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
			document.getElementById("error-message").innerHTML = "Invalid Date!";
		}
		
	}
</script>
<div class="row">
	<h1>&nbsp;Top-notchers</h1>
	<b>&nbsp;From: </b>
	<select name="from_month" id="from_month">
		<option value="0" selected disabled>Month</option>
		<?php  
		$monthArray = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sept', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
		foreach ($monthArray as $key => $value) 
		{
			echo "<option value='$key'>$value</option>";
		}
		?>
	</select>
	<select name="from_day" id="from_day">
		<option value="0" selected disabled>Day</option>
		<?php for($i = 1; $i <= 31; $i++) 
		echo "<option value='$i'>$i</option>"; 
		?>
	</select>
	<select name="from_year" id="from_year">
		<option value="0" selected disabled>Year</option>
		<?php $year = date("Y"); for($i = $year; $i >= 2000; $i--) 
		echo "<option value='$i'>$i</option>"; 
		?>
	</select>
	<b>To: </b>
	<select name="to_month" id="to_month">
		<option value="0" selected disabled>Month</option>
		<?php  
		$monthArray = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sept', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
		foreach ($monthArray as $key => $value) 
		{
			echo "<option value='$key'>$value</option>";
		}
		?>
	</select>
	<select name="to_day" id="to_day">
		<option value="0" selected disabled>Day</option>
		<?php for($i = 1; $i <= 31; $i++) 
		echo "<option value='$i'>$i</option>"; 
		?>
	</select>
	<select name="to_year" id="to_year">
		<option value="0" selected disabled>Year</option>
		<?php $year = date("Y"); for($i = $year; $i >= 2000; $i--) 
		echo "<option value='$i'>$i</option>"; 
		?>
	</select>
	<b>Group: </b>
	<select name="group_id" id="groupings">
		<option value="all" selected>All</option>
		<?php
			require('../dbConn.php');

			$sqlGetGroups = "SELECT * FROM groups";
			$queryGetGroups = mysql_query($sqlGetGroups) or die(mysql_error());

			while($row = mysql_fetch_assoc($queryGetGroups))
			{
				echo "<option value='" . $row['group_id'] . "'>" . $row['group_name'] . "</option>";
			}

		?>
	</select>
	<input type="button" value="Go" name="btn_go" onclick="loadTopNotchers();" />
	<span id="error-message" style="color: red;"></span>
</div>