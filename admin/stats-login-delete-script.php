<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");
	
	
	//$query = new db_dotaz("DELETE FROM stats_login");
	$query = new db_dotaz("TRUNCATE TABLE stats_login");
	$query->proved_dotaz();
	$query = NULL;	
	
	header("Location:index.php?action=statistiky-login");
	
?>