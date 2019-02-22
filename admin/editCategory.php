<?php  
	require('../dbConn.php');
	require('adminSessionChecker.php');

	$category_id = $_GET['id'];

	$sqlGetCategory = "SELECT * FROM question_category WHERE q_cat_id = '$category_id'";
	$queryGetCategory = mysql_query($sqlGetCategory) or die(mysql_error());

	$category_id = '';
	$category_name = '';
	$category_desc = '';

	while($row = mysql_fetch_array($queryGetCategory))
	{
		$category_id = $row['q_cat_id'];
		$category_name = $row['q_cat_name'];
		$category_desc = $row['q_cat_desc'];
	}

?>
<h3>Edit Category</h3>
<form method="POST" action="updateCategory.php" role="form">
	<div class="form-group">
		<label for="question">Category Name: </label>
		<input class="form-control" type="text" name="category_name" placeholder="Category Name" value="<?php echo $category_name; ?>" required />	
	</div>

	<div class="form-group">
		<label for="choice">Category Description: </label>
			<input class="form-control" type="text" name="category_description" placeholder="Category Description" value="<?php echo $category_desc; ?>" required/>
	</div>

	<input type="hidden" name="category_id" value="<?php echo $category_id?>">
	<input type="submit" class="btn btn-success" value="Save" name="btn_save" />	
</form>
