<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");
	
	//Nastavení data a èasu->
	$datum = date("Ymd");
	$cas = date("H:i:s");
	//<-
	$akce = $_POST['action'];
	$clanek_titulek = $_POST['clanek_titulek'];
	$clanek_id = stranka_admin::friendly_url($clanek_titulek);
	$clanek_id_old = $_POST['item_id_old'];
	$clanek_strucne = $_POST['clanek_strucne'];
	$clanek_text = $_POST['clanek_text'];
	$clanek_autor = $_POST['clanek_autor'];
	$clanek_komentare = $_POST['komentare'];
	if($clanek_komentare==""){$clanek_komentare="off";}
	$clanek_zobrazovat = $_POST['clanek_zobrazovat'];
	$clanek_kategorie = $_POST['clanek_kategorie'];
	$clanek_editor = $_POST['editor'];
	
	//$clanek_kategorie = explode("-", $clanek_kategorie);
	//$clanek_subkategorie = $clanek_kategorie[1];
	//$clanek_kategorie = $clanek_kategorie[0];
	$clanek_subkategorie = $clanek_kategorie;
	$clanek_kategorie = "simple";
	
	//Pokud je u katerorie nastaveno zobrazení èlánku místo vıpisu, nastavit id èlánku stejné jako id kategorie
	//$category_id=stranka_admin::find_article_category_id($clanek_subkategorie);
	//$category_type=stranka_admin::find_category_type($clanek_subkategorie);
	//if($category_type=="page")
	//{
	//	$clanek_id=$category_id;
	//}

switch($akce)
{
	case "add":	
		$sql_query=("INSERT INTO clanky VALUES ('".$clanek_id."', '".$clanek_kategorie."','".$clanek_subkategorie."','".$clanek_titulek."','".$datum."','".$cas."','".$clanek_autor."','".$clanek_strucne."','".$clanek_text."','".$clanek_komentare."','".$clanek_zobrazovat."','0','".$clanek_editor."','','')");
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		header("Location:index.php?action=zobrazit-clanky");
	break;
	
	case "edit":
		$sql_query=("UPDATE clanky SET id =	'".$clanek_id."', kategorie = '".$clanek_kategorie."', subkategorie = '".$clanek_subkategorie."', titulek = '".$clanek_titulek."', autor = '".$clanek_autor."', strucne = '".$clanek_strucne."', text = '".$clanek_text."', komentare = '".$clanek_komentare."', zobrazovat='".$clanek_zobrazovat."', editor='".$clanek_editor."', last_change_date='".$datum."', last_change_time='".$cas."' WHERE id = '".$clanek_id_old."'");
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		
		$sql_query=("UPDATE komentare SET item_id='".$clanek_id."' WHERE item_id='".$clanek_id_old."'");
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		
		header("Location:index.php?action=zobrazit-clanky");
	break;
}

?>