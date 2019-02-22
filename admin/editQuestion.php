<?php 
require 'adminSessionChecker.php';
require '../dbConn.php';

if(!isset($_GET['id']))
	die("nothing to edit");

$id = $_GET['id'];
$sql = "SELECT q_cat_id, q_text FROM question WHERE q_id='$id'";
$query = mysql_query($sql);
$row = mysql_fetch_assoc($query) or die(mysql_error());
$text = $row['q_text'];
$category_id = $row['q_cat_id'];

$sqlChoices = "SELECT choice_id, choice_text FROM choices WHERE q_id =$id";
$queryChoice = mysql_query($sqlChoices) or die(mysql_error());
$choices = array();

while($row = mysql_fetch_assoc($queryChoice))
{
	$choices[$row['choice_id']] = $row['choice_text'];
}

$_SESSION['choices'] = $choices;

$sqlAnswer = "SELECT answer_id, correct_answer FROM answer WHERE q_id=$id";
$queryAnswer = mysql_query($sqlAnswer) or die(mysql_error());
$answer = array();

while($row = mysql_fetch_assoc($queryAnswer))
{
	$answer[$row['answer_id']] = $row['correct_answer'];
}

$categories = array();
$sqlGetCategories = "SELECT q_cat_id, q_cat_name FROM question_category";
$queryGetCategories = mysql_query($sqlGetCategories) or die(mysql_error());

while($row = mysql_fetch_array($queryGetCategories))
{
	$categories[$row[0]] = $row[1];
}

mysql_close();

?>

<html>
<head>
	<title>Edit Page</title>
	<script type="text/javascript">
	function changeHiddenVal()
	{
		var i = document.getElementById('correct_textbox').value;
		document.getElementById('correct').value = i;
	}
	</script>
</head>
<body>
	

	<form action="updateQuestion.php" method="POST" enctype="multipart/form-data" role="form">
		<div id="question" class="form-group">

			<div class="form-group">
				<label for="category">Choose Category: </label>
				<select name="cat" id="category" class="form-control" required>
					<option value="" selected>Choose...</option>
					<?php  
					foreach ($categories as $key => $value) 
					{
						if($key == $category_id)
						{
							echo "<option value=$key selected>$value</option>";
						}
						else
						{
							echo "<option value=$key>$value</option>";
						}
					}
					?>
				</select>
			</div>
			<h3>Question: </h3>
			<textarea id="textQuestion" placeholder="Question goes here" class="form-control" name="question_text" rows="3" data-min-rows="3" data-min-cols="5"><?php  echo $text; ?>
			</textarea>
			
		</div>

		<div id="choices">
			<h3>Choices: </h3>
			<div id="correct_anwer" class="form-group">

				<?php  
				foreach ($choices as $key => $value) 
				{
					if(in_array($value, $answer))
					{
						echo "<input type='text' id='correct_textbox' class='form-control' name='choice$key' value=" . "\"" . $value . "\"" . " placeholder='Correct Answer' onchange='changeHiddenVal();' required/>";
						$answer_id = array_search($value, $answer);
						echo "<input type='hidden' name='answer_id' value='$answer_id' />";
						echo "<input type='hidden' id='correct' name='answer_text' value=" . "\"" . $value . "\"" . " />";
						unset($choices[$key]);
					}
				}
				?>
			</div>

			<div id="wrong_answer" class="form-group">
				<?php  
				foreach ($choices as $key => $value) 
				{
					//$value = mysql_real_escape_string($value);
					echo "<input type='text' class='form-control' name='choice$key' value=" ."\"" . $value . "\"" . "placeholder='Wrong Answer' required/><br />";
				}
				?>
			</div>

		</div>

		<input type="hidden" name="id" value="<?php echo $id; ?>"/>
		<input type="submit" class="btn btn-success" value="Save Changes" name="btn_save" />
	</form>

</body>
</html>