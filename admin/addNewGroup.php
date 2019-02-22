<?php  
require('../dbConn.php');
require('adminSessionChecker.php');

?>



<form method="POST" action="insertGroup.php" role="form">
	<div class="form-group">
		<label for="group">Group Name: </label>
		<input id="group" class="form-control" type="text" name="group_name" placeholder="Group Name" required/>	
	</div>

	<input type="submit" class="btn btn-success" value="Save" name="btn_insert" />	
</form>
