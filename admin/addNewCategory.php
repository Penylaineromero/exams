<?php  
require('../dbConn.php');
require('adminSessionChecker.php');

?>



<form method="POST" action="insertCategory.php" role="form">
	<div class="form-group">
		<label for="question">Subject Name: </label>
		<input class="form-control" type="text" name="category_name" placeholder="Category Name" required/>	
	</div>

	<div class="form-group">
		<label for="choice">Subject Description: </label>
			<input class="form-control" type="text" name="category_description" placeholder="Category Description" required/>
	</div>

	<input type="submit" class="btn btn-success" value="Save" name="btn_insert" />	
</form>
