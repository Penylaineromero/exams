<?php  
function displayCategories($details)
{
	$category_id = $details['q_cat_id'];
	$category_name = $details['q_cat_name'];
	$category_description = $details['q_cat_desc'];

	echo "<tr>";
	echo "<td>" . $category_name . "</td>";
	echo "<td>" . $category_description . "</td>";
	echo "<td><a href='adminPanel.php?tab=editCategory&cat_id=" . $category_id . "' class='btn btn-xs btn-warning'>Update</a>&nbsp;<a href='deleteCategory.php?id=$category_id' onclick='return areYouSure();' class='btn btn-xs btn-danger'>Delete</a></td>";
	echo "</tr>";
}
?>

<?php
require('../sessionChecker.php');
require('../dbConn.php');

//get all category names
$sqlGetCategories = "SELECT * FROM question_category";
$queryGetCategories = mysql_query($sqlGetCategories) or die(mysql_error());
$totalCategories = mysql_num_rows($queryGetCategories);

echo "<a href='adminPanel.php?tab=addNewCategory' class='btn btn-success btn-xs'>New Category</a>";
echo "<table class='table table-condensed table-hover'>";
echo "<thead class='info'><th>Category Name</th><th>Category Description</th><th>Action</th></thead>";
if($totalCategories > 0)
{
	while($row = mysql_fetch_array($queryGetCategories))
	{
		displayCategories($row);	
	}

}
else
{
	echo "<tr><td colspan='5'><center>No results found!</center></td></tr>";
}

echo "<tr class='info'><td colspan='5'><u>Total Categories:</u> <b>$totalCategories</b></td></tr>";
echo "</table>";
mysql_close();
?>

<script type="text/javascript">

	function areYouSure()
	{
		var dialogConfirm = window.confirm("Are you sure you want to delete?");

		return dialogConfirm;
	}
</script>