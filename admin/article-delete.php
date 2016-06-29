<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");
	
	$article_id = $_REQUEST['id'];
	
	$sql_query = ("DELETE FROM clanky WHERE id='".$article_id."'");
	mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	
	$sql_query = ("DELETE FROM komentare WHERE item_id='".$article_id."'");
	mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	
	header("Location:index.php?action=zobrazit-clanky");
?>