<?php require('dbConn.php'); ?>
<?php require('sessionChecker.php'); ?>

<?php
	function get_examiner_status($user_id)
	{
		$sqlGetExaminerStatus = "SELECT * FROM user_detail WHERE user_id='$user_id' LIMIT 1";
		$queryGetExaminerStatus = mysql_query($sqlGetExaminerStatus) or die(mysql_error());
		return mysql_fetch_assoc($queryGetExaminerStatus)['status'];
	}

	$user_status = get_examiner_status($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>
<head>
	<title>User Panel</title>
	 <meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/userpanel.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="shortcut icon" type="image/png" href="icons/PUPLogo.png"/>;
	<style type="text/css">
	</style>
</head>
<body>
	<div id ="wrapper">
		<div class ="header">
			<div class = "title">
				<h3><a href="userPanel.php?tab=welcome&name=<?php echo $_SESSION['username']; ?>"><b>Online Entrance Exam</b></a></h3>
			</div>
		</div>

		<div class= "content">
			<div class = "sidenav">
				<a href="userPanel.php?tab=viewResults" class="nav"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;Results</a>
				<a href="userPanel.php?tab=instructions" class="nav"><i class="glyphicon glyphicon-pencil"></i>&nbsp;Take Exam <?php if($user_status == 'Finished') echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Done)"; ?></a>
				<a href="userPanel.php?tab=viewProfile" class="nav"><i class="glyphicon glyphicon-user"></i>&nbsp;Profile</a>
				<a href="logout.php" class="nav"><i class="glyphicon glyphicon-off"></i>&nbsp;Log Out</a>
			</div>
		</div>


		<div class="forms">
			<div class="container-fluid" id="options">

			</div>
		</div>

		<div class = "footer">
			<div class = "credits">
				<h1>
					<i>&#169; Powered by MARU</i>
				</h1>
			</div>


		</div>
	</div>

	<script type="text/javascript" src="jquery/jquery-1.11.3.min.js"></script>
	<script type="text/javascript">
	var $_GET = {};
	function getTabOption()
	{
		var parts = window.location.search.substr(1).split("&");
		for (var i = 0; i < parts.length; i++) 
		{
			var temp = parts[i].split("=");
			$_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
		}
	}

	function loadOption()
	{
		var currentTab = $_GET['tab'];
		var code;

		switch(currentTab)
		{
			case 'viewProfile':
				$("#options").load("viewProfile.php");
				break;
			case 'error':
				code = $_GET['code'];
				$("#options").load("error.php?code=" + code);
				break;
			case 'viewResults':
				$("#options").load("viewResults.php");
				break;
			case 'welcome':
				var name = $_GET['name'];
				document.getElementById("options").innerHTML = "<h2><center><br><br><br><br>Welcome, " + name + "!</center></h2> <center>Click on the take exam to test your skills now</center>";
				break;
			case 'instructions':
				$("#options").load("instructions.php");
				break;
			default:
				console.log("No such menu!");
				break;
		}
	}

	$(document).ready(function()
	{
		getTabOption();
		loadOption();
	});
	</script>

</body>
</html>