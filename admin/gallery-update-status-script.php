<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");
	
	$gid = $_GET['gid'];
	$set_to = $_GET['s'];
	$query = new db_dotaz("UPDATE galerie SET stav = '".$set_to."' WHERE url = '".$gid."' LIMIT 1");
	$query->proved_dotaz();
	$query = NULL;
	header("Location:index.php?action=zobrazit-galerii&gid=".$gid);
?>