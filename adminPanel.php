<?php
	require('../dbConn.php');
	require('adminSessionChecker.php');

	$sqlCountPending = "SELECT * FROM user_detail WHERE status='Pending'";
	$queryCountPending = mysql_query($sqlCountPending);
	$pendingCount = mysql_num_rows($queryCountPending);

	mysql_close();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Administrator Panel</title>
	<link rel="stylesheet" type="text/css" href="css/adminpanel.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="shortcut icon" type="image/png" href="../icons/favicon.png"/>

</head>
<body>
	<div id ="wrapper">
		<div class ="header">
				<h3><a href="adminPanel.php">PUP FACULTY</a></h3>
		</div>

		<div class = "content">
			<div class = "sidenav hidden-print">
				<div><a href="adminPanel.php?tab=viewGroups" class="nav"><span class="glyphicon glyphicon-th"></span>&nbsp;Groups</a></div>
				<div><a href="adminPanel.php?tab=viewCourses" class="nav"><span class="glyphicon glyphicon-tasks"></span>&nbsp;Courses</a></div>
				<div><a href="adminPanel.php?tab=viewCategories" class="nav"><span class="glyphicon glyphicon-th-list"></span>&nbsp;Categories</a></div>
				<div><a href="adminPanel.php?tab=viewQuestions&filter=all" class="nav"><span class="glyphicon glyphicon-book"></span>&nbsp;Questions</a></div>
				<div><a href="adminPanel.php?tab=viewExaminers&filter=all" class="nav"><span class="glyphicon glyphicon-user"></span>&nbsp;Examiners</a></div>
				<div><a href="adminPanel.php?tab=viewPending" class="nav"><span class="glyphicon glyphicon-inbox"></span>&nbsp;<span style="font-size: 12px;">Pending Applicants</span>&nbsp;<span class="badge badge-notify"><?php echo $pendingCount; ?></span></a></div>
				<div><a href="adminPanel.php?tab=viewReports" class="nav"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Reports</a></div>
				<div><a href="adminPanel.php?tab=settings" class="nav"><span class="glyphicon glyphicon-cog"></span>&nbsp;Settings</a></div>
				<div><a href="../logout.php" class="nav"><span class="glyphicon glyphicon-off"></span>&nbsp;Logout</a></div>
			</div>
		</div>
	</div>

	<div class="forms">
		<div class="container-fluid" id="options">

		</div>
	</div>

	<script type="text/javascript" src="../jquery/jquery-1.11.3.min.js"></script>
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
		var qid;
		switch(currentTab)
		{

			case 'viewQuestionGroups':
				var group_id = $_GET['group_id'];
				$("#options").load("viewQuestionGroups.php?group_id=" + group_id);
				break;

			case 'viewExaminerGroups':
				var group_id = $_GET['group_id'];
				$("#options").load("viewExaminerGroups.php?group_id=" + group_id);
				break;

			case 'viewGroups':
				$("#options").load("viewGroups.php");
				break;

			case 'addNewGroup':
				$("#options").load("addNewGroup.php");
				break;

			case 'editGroup':
				var group_id = $_GET['group_id'];
				$("#options").load("editGroup.php?id=" + group_id);
				break;

			case 'viewCourses':
				$("#options").load("viewCourses.php");
				break;
			case 'addNewCourse':
				$("#options").load("addNewCourse.php");
				break;
			case 'editCourse':
				var course_id = $_GET['desired_course_id'];
				$("#options").load("editCourse.php?id=" + course_id);
				break;

			case 'viewCategories':
				$("#options").load("viewCategories.php");
				break;

			case 'addNewCategory':
				$("#options").load("addNewCategory.php");
				break;

			case 'editCategory':
				var cat_id = $_GET['cat_id'];
				$("#options").load("editCategory.php?id=" + cat_id);
				break;

			case 'viewQuestions':
				var filterValue = $_GET['filter'];
				$("#options").load("viewQuestions.php?filter=" + filterValue);
				break;
			case 'viewExaminers':
				var filterValue = $_GET['filter'];
				$("#options").load("viewExaminers.php?filter=" + filterValue);
				break;
			case 'viewPending':
				$("#options").load("viewPendingApplicants.php");
				break;
			case 'editQuestion':
				qid = $_GET['qid'];
				$("#options").load("editQuestion.php?id=" + qid);
			break;
			case 'addNewQuestion':
				$("#options").load("addNewQuestion.php");
				break;

			case 'addTrueFalseQuestion':
				$("#options").load("addTrueFalseQuestion.php");
				break;
			case 'search':
				var val = $_GET['value'];
				$("#options").load("search.php?text=" + val);
			break;

			case 'settings':
				$("#options").load("settings.php");
				break;

			case 'viewReports':
				$("#options").load("viewReports.php");				
				break;

			case 'viewAnswers':
				var id = $_GET['id'];
				$("#options").load("examresults.php?id=" + id);
				break;

			case 'viewMAB':
				var id = $_GET['id'];
				$("#options").load("viewMAB.php?id=" + id);
				break;

			case 'filter':
					var to = $_GET['to'];
					var from = $_GET['from'];
					var mySite = "top.php?to=" + to + "&from=" + from;
					$("#options").load(mySite);
				break;

			default:
				
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