<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");
	
	
	$text_id = $_REQUEST['id'];
	$parent = $_REQUEST['parent'];
	
	$sql_query = ("DELETE FROM texty WHERE id='".$text_id."'");
	mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	
	$sql_query = ("DELETE FROM menu_subkategorie WHERE url='".$text_id."'");
	mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	
	$sql_query = ("DELETE FROM texty_langs WHERE parent_id='".$text_id."'");
	mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	
	$sql_query = ("DELETE FROM menu_subkategorie_langs WHERE parent_id='".$text_id."'");
	mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	
	stranka_admin::reorder_subcat_positions($parent);
	
	
	header("Location:index.php?action=show-menu-categories");
	
?>