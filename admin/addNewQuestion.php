<?php  
require('../dbConn.php');
require('adminSessionChecker.php');

$categories = array();
$sqlGetCategories = "SELECT q_cat_id, q_cat_name FROM question_category";
$queryGetCategories = mysql_query($sqlGetCategories) or die(mysql_error());

while($row = mysql_fetch_array($queryGetCategories))
{
	$categories[$row[0]] = $row[1];
}
?>



<form method="POST" action="insertQuestion.php" enctype="multipart/form-data" role="form">
	<div class="form-group">
		<label for="category">Choose Category: </label>
		<select name="cat" id="category" class="form-control" required>
			<option value="">Choose...</option>
			<?php  
			foreach ($categories as $key => $value) 
			{
				echo "<option value=$key>$value</option>";
			}
			?>
		</select>
	</div>
	<div class="form-group">
		<label for="question">Question: </label>
		<textarea class="form-control" id="question" placeholder="Question goes here . . ." name="q_text" rows="8" cols="40" required></textarea>
		<br />
		
	</div>
	
	<div class="form-group">
		<label for="choice">Choices: </label>
			<input class="form-control" type="text" name="correct_answer1" placeholder="Correct Answer" required/>
	</div>

	<div class="form-group">
		<input class="form-control" type="text" name="wrong_answer1" placeholder="Wrong Answer" required/>
	</div>
	<div class="form-group">
		<input class="form-control" type="text" name="wrong_answer2" placeholder="Wrong Answer" required/>
	</div>
	<div class="form-group">
		<input class="form-control" type="text" name="wrong_answer3" placeholder="Wrong Answer" required/>
	</div>
	<div class="form-group">
		<input class="form-control" type="text" name="wrong_answer4" placeholder="Wrong Answer" required/>
	</div>

	<input type="submit" class="btn btn-success" value="Insert question" name="btn_insert" />	
</form>
