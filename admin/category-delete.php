<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");
	
	$type = $_REQUEST['type'];
	$id = $_REQUEST['id'];
	switch($type)
	{
		case "main":
			$sql_query = "SELECT nazev FROM menu_kategorie WHERE URL='".$id."'";
			$vyber = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			$vyber = mysql_fetch_array($vyber);
			$nazev = $vyber['nazev'];
			
			$sql_query = "DELETE FROM menu_kategorie WHERE URL='".$id."'";
			$sql_query2 = "DELETE FROM menu_subkategorie WHERE parent_url='".$id."'";
			$sql_query3 = "DELETE FROM clanky WHERE kategorie='".$nazev."'";
			mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			mysql_query($sql_query2, $GLOBALS['database']) or die(mysql_error());	
			mysql_query($sql_query3, $GLOBALS['database']) or die(mysql_error());
			//echo $sql_query."<br />".$sql_query2."<br />".$sql_query3;
			stranka_admin::reorder_category_positions();
			header("Location:index.php?action=show-menu-categories");
		break;
		
		case "sub":
			$sql_query = "SELECT * FROM menu_subkategorie WHERE url='".$id."'";
			$vyber = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			$vyber = mysql_fetch_array($vyber);
			$nazev = $vyber['nazev'];
			
			$sql_query = "DELETE FROM menu_subkategorie WHERE url='".$id."'";
			$sql_query2 = "DELETE FROM clanky WHERE subkategorie='".$nazev."'";
			mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			mysql_query($sql_query2, $GLOBALS['database']) or die(mysql_error());
			stranka_admin::reorder_subcat_positions('simple');
			
			$sql_query = "DELETE FROM menu_subkategorie_langs WHERE parent_id='".$id."'";
			mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			
			header("Location:index.php?action=show-menu-categories");
		break;
		
		case "separator":
			$sql_query = "DELETE FROM menu_subkategorie WHERE url='".$id."'";
			mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			stranka_admin::reorder_subcat_positions('simple');
			header("Location:index.php?action=show-menu-categories");
		break;
	}
?>