<?php  
require ('../dbConn.php');
require ('adminSessionChecker.php');

$sqlGetTimeLimit = "SELECT * FROM time_limit";
$queryTimeLimit = mysql_query($sqlGetTimeLimit) or die(mysql_error());
$row = mysql_fetch_array($queryTimeLimit);

$hours = $row['hours'];
$minutes = $row['minutes'];
$seconds = $row['seconds'];

mysql_close();
?>
<head>
	<script type="text/javascript">
	function saveChanges()
	{
		var oldPassword = document.getElementById("oldpassword").value;
		var newPassword = document.getElementById("newpassword").value;
		var confirmPassword = document.getElementById("confirmpassword").value;

		if(oldPassword == "")
		{
			document.getElementById("oldpass").innerHTML = "Enter your old password!";
		}
		else
		{
			if(newPassword != confirmPassword)
			{
				document.getElementById("confirmpass").innerHTML = "Password mismatch!";
			}
			else
			{
				document.changepass.submit();
			}
		}

	}
	</script>
</head>

<?php 

if(isset($_GET['code'])) 
{
	echo "<p class='success'>Successfully changed password!</p>";
}
?>

<div class="row">
	<form role="form" class="col-xs-4" name="changepass" method="POST" action="savesettings.php">
		<div class="form-group">
			<label for="oldpassword"><h4>Change Password: </h4></label>
			<input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="Old Password" /><span id="oldpass" style="color: red;"></span>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="New Password" />
		</div>
		<div class="form-group">
			<input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" /><span id="confirmpass" style="color: red;"></span>
		</div>
		<input type="button" value="Save Changes" name="btn_save" class="form-control btn btn-success" onclick="saveChanges()" />
	</form>
</div>
<hr>
<form role="form" name="setTime" method="POST" action="updatetime.php">
	<div class="row col-xs-3">
		<div class="form-group">
			<label><h4>Time for each question category</h4></label>
			<b>Hour(s): </b>
			<input type="number" name="hours" min="0" class="form-control" placeholder="Hour(s)" value="<?php echo $hours; ?>" />
		</div>

		<div class="form-group">
			<b>Minute(s): </b>
			<input type="number" name="minutes" min="1" max="59" class="form-control" placeholder="Minute(s)" value="<?php echo $minutes; ?>" />
		</div>

		<div class="form-group">
			<b>Second(s): </b>
			<input type="number" name="seconds" min="0" max="59" class="form-control" placeholder="Second(s)" value="<?php echo $seconds; ?>"/>
		</div>
		<input type="submit" value="Set Time" name="btn_set_time" class="btn btn-primary" />
	</div>
</form>