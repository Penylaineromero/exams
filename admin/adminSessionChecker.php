<?php  
	session_start();
	if(!isset($_SESSION['user_id']) && $_SESSION['level'] != 1)
	{
		header("Location: ../index.php?code=required");
		die();
	}
?>