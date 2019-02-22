<?php
	$servername="localhost";
	$username="root";
	$password="";
	$dbName="exam";
	
	$conn = mysql_connect($servername, $username,$password) or die(mysql_error());
	$db = mysql_select_db($dbName) or die("Cannot select dabase: " . mysql_error());
?>