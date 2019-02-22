<?php  
require('../dbConn.php');
require('adminSessionChecker.php');

$group_id = $_GET['id'];

$sqlGetGroups = "SELECT * FROM groups WHERE group_id = '$group_id'";
$queryGetGroups = mysql_query($sqlGetGroups) or die(mysql_error());

while($row = mysql_fetch_array($queryGetGroups))
{
	$group_id = $row['group_id'];
	$group_name = $row['group_name'];
}
?>

<form method="POST" action="updateGroup.php" role="form">
	<div class="form-group">
		<label for="course">Group Name: </label>
		<input class="form-control" id="course" type="text" name="group_name" placeholder="Course Name" value="<?=$group_name?>" required/>
	</div>

	<input type="hidden" name="group_id" value="<?=$group_id?>">
	<input type="submit" class="btn btn-success" value="Save" name="btn_save" />	
</form>
