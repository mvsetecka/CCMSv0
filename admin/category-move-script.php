<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");

$typ = $_REQUEST["type"];
$smer = $_REQUEST["action"];
$id = $_REQUEST["id"];
$parent_id = $_REQUEST["parent_id"];

switch($typ)
{
	case "cat":
		if($smer=="up"){
			category_up($id);
		}else{
			category_down($id);
		}
	break;
	
	case "subcat":
		if($smer=="up"){
			subcategory_up($id, $parent_id);
		}else{
			subcategory_down($id, $parent_id);
		}
	break;
}


function category_up($id){
	$sql_query = ("SELECT pozice FROM menu_kategorie WHERE URL = '".$id."'");
	$vyber = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	$vyber = mysql_fetch_array($vyber);
	$current_pos =  $vyber['pozice'];
	//$last_id = get_last_cat_position();
	$sql_query = ("UPDATE menu_kategorie SET pozice=pozice+1 WHERE pozice='".($current_pos-1)."'");
	$sql_query2 = ("UPDATE menu_kategorie SET pozice=pozice-1 WHERE URL='".$id."'");
	mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	mysql_query($sql_query2, $GLOBALS['database']) or die(mysql_error());
	header("Location:index.php?action=show-menu-categories");
}

function category_down($id){
	$sql_query = ("SELECT pozice FROM menu_kategorie WHERE URL = '".$id."'");
	$vyber = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	$vyber = mysql_fetch_array($vyber);
	$current_pos =  $vyber['pozice'];
	
	$sql_query = ("UPDATE menu_kategorie SET pozice=pozice-1 WHERE pozice='".($current_pos+1)."'");
	$sql_query2 = ("UPDATE menu_kategorie SET pozice=pozice+1 WHERE URL='".$id."'");
	mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	mysql_query($sql_query2, $GLOBALS['database']) or die(mysql_error());
	header("Location:index.php?action=show-menu-categories");
}

function subcategory_up($id, $parent_id){
	$sql_query = ("SELECT pozice FROM menu_subkategorie WHERE url = '".$id."' AND parent_url='".$parent_id."'");
	$vyber = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	$vyber = mysql_fetch_array($vyber);
	$current_pos =  $vyber['pozice'];
	
	$sql_query = ("UPDATE menu_subkategorie SET pozice=pozice+1 WHERE pozice='".($current_pos-1)."' AND parent_url='".$parent_id."'");
	$sql_query2 = ("UPDATE menu_subkategorie SET pozice=pozice-1 WHERE URL='".$id."'");
	mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	mysql_query($sql_query2, $GLOBALS['database']) or die(mysql_error());
	header("Location:index.php?action=show-menu-categories");
}

function subcategory_down($id,$parent_id){
	$sql_query = ("SELECT pozice FROM menu_subkategorie WHERE url = '".$id."' AND parent_url='".$parent_id."'");
	$vyber = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	$vyber = mysql_fetch_array($vyber);
	$current_pos =  $vyber['pozice'];
	//$last_id = get_last_cat_position();
	$sql_query = ("UPDATE menu_subkategorie SET pozice=pozice-1 WHERE pozice='".($current_pos+1)."' AND parent_url='".$parent_id."'");
	$sql_query2 = ("UPDATE menu_subkategorie SET pozice=pozice+1 WHERE URL='".$id."' AND parent_url='".$parent_id."'");
	mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	mysql_query($sql_query2, $GLOBALS['database']) or die(mysql_error());
	header("Location:index.php?action=show-menu-categories");
}

?>