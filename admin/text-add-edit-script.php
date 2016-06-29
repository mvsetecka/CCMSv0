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
	$clanek_text = $_POST['clanek_text'];
	$clanek_autor = $_POST['clanek_autor'];
	$clanek_komentare = $_POST['komentare'];
	$clanek_komentare = "off_hidden";
	if($clanek_komentare==""){$clanek_komentare="off";}
	$clanek_zobrazovat = $_POST['clanek_zobrazovat'];
	$clanek_zobrazovat_puvodni = $_POST['zobrazovat_old'];
	$clanek_kategorie = $_POST['clanek_kategorie'];
	if($_POST['menu_zobrazovat']!=="on")$clanek_zobrazovat="nmenu";
	$clanek_kategorie_puvodni = $_POST['clanek_kategorie_old'];
	$clanek_editor = $_POST['editor'];
	$clanek_kategorie_id = stranka_admin::friendly_url($clanek_kategorie);
	
	if(stranka_admin::get_settings(web_version)=='simple')
	{
		$clanek_kategorie = "simple";
		$clanek_kategorie_id = "simple";
	}
	
switch($akce)
{
	case "add":
		//Proveri zda text s timto titulkem jiz neexistuje
		$sql_query=("SELECT * FROM texty WHERE id = '".$clanek_id."'");
		$dotaz = new db_dotaz($sql_query);
		$dotaz->proved_dotaz();
		if($dotaz->pocet_vysledku()>0)
		{
			$_SESSION['article_text_saved'] = $clanek_text;
			$_SESSION['article_author_saved'] = $clanek_autor;
			$_SESSION['article_title_saved'] = $clanek_titulek;
			header("Location: index.php?action=pridej-text&err=1");
			$dotaz = NULL;
			exit(0);
		}
		$dotaz = NULL;
		//------------------------------------------------
		
		$sql_query=("INSERT INTO texty VALUES ('".$clanek_id."', '".$clanek_kategorie_id."','".$clanek_kategorie."','".$clanek_titulek."','".$datum."','".$cas."','".$clanek_autor."','".$clanek_text."','".$clanek_komentare."','".$clanek_zobrazovat."','0','".$clanek_editor."','','')");
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		if($clanek_kategorie!=="")
		{
			$clanek_pozice = stranka_admin::get_last_subcat_position($clanek_kategorie);
			$clanek_pozice = $clanek_pozice + 1;
			$sql_query=("INSERT INTO menu_subkategorie VALUES('".$clanek_kategorie."','".$clanek_kategorie_id."','".$clanek_titulek."','".$clanek_id."','text','".$clanek_zobrazovat."','".$clanek_pozice."')");
			mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		}
		$sql_query=("INSERT INTO texty_langs VALUES('".$clanek_id."', '', '','','EN')");
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		$sql_query=("INSERT INTO texty_langs VALUES('".$clanek_id."', '', '','','DE')");
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		$sql_query=("INSERT INTO texty_langs VALUES('".$clanek_id."', '', '','','DU')");
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		$sql_query=("INSERT INTO menu_subkategorie_langs VALUES('".$clanek_id."', '','','EN')");
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		$sql_query=("INSERT INTO menu_subkategorie_langs VALUES('".$clanek_id."', '','','DE')");
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		$sql_query=("INSERT INTO menu_subkategorie_langs VALUES('".$clanek_id."', '','','DU')");
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		header("Location:index.php?action=zobrazit-texty");
	break;
	
	case "edit":
		//Proveri zda text s timto titulkem jiz neexistuje
		$sql_query=("SELECT * FROM texty WHERE id = '".$clanek_id."'");
		$dotaz = new db_dotaz($sql_query);
		$dotaz->proved_dotaz();
		if($dotaz->pocet_vysledku()>0 && $clanek_id_old!==$clanek_id)
		{
			$_SESSION['article_text_saved'] = $clanek_text;
			$_SESSION['article_author_saved'] = $clanek_autor;
			$_SESSION['article_title_saved'] = $clanek_titulek;
			header("Location: index.php?action=uprav-text&param1=".$clanek_id_old."&err=1");
			$dotaz = NULL;
			exit(0);
		}
		$dotaz = NULL;
		//------------------------------------------------
	
		$sql_query=("UPDATE texty SET id ='".$clanek_id."', kategorie = '".$clanek_kategorie."', kategorie_id = '".$clanek_kategorie_id."', titulek = '".$clanek_titulek."', autor = '".$clanek_autor."', text = '".$clanek_text."', komentare = '".$clanek_komentare."', zobrazovat='".$clanek_zobrazovat."', editor='".$clanek_editor."', last_change_date='".$datum."', last_change_time='".$cas."' WHERE id = '".$clanek_id_old."'");
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		
		if($clanek_zobrazovat=="ano" && $clanek_zobrazovat_puvodni=="ano")
		{
		 	$clanek_pozice = stranka_admin::get_last_subcat_position($clanek_kategorie);
		 	$clanek_pozice = $clanek_pozice + 1;
			$sql_query=("UPDATE menu_subkategorie SET parent= '".$clanek_kategorie."', parent_url= '".$clanek_kategorie_id."', nazev= '".$clanek_titulek."', url='".$clanek_id."', zobrazovat='".$clanek_zobrazovat."', pozice='".$clanek_pozice."' WHERE url='".$clanek_id_old."'");
			mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			stranka_admin::reorder_subcat_positions($clanek_kategorie_puvodni);
		}
		elseif($clanek_zobrazovat=="ano" && $clanek_zobrazovat_puvodni=="ne")
		{	
		 	$clanek_pozice = stranka_admin::get_last_subcat_position($clanek_kategorie);
			$clanek_pozice = $clanek_pozice + 1;
			$sql_query=("INSERT INTO menu_subkategorie VALUES('".$clanek_kategorie."','".$clanek_kategorie_id."','".$clanek_titulek."','".$clanek_id."','text','".$clanek_zobrazovat."','".$clanek_pozice."')");
			mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			stranka_admin::reorder_subcat_positions($clanek_kategorie_puvodni);
		}
		elseif($clanek_zobrazovat=="ne" && $clanek_zobrazovat_puvodni=="ano")
		{
			$sql_query = ("DELETE FROM menu_subkategorie WHERE url='".$clanek_id."'");
			mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			
			stranka_admin::reorder_subcat_positions($clanek_kategorie_puvodni);
		}
		header("Location:index.php?action=zobrazit-texty");
	break;
	
	case "edit_lang":
		$language = $_POST['language'];
		$sql_query = ("UPDATE texty_langs SET nazev= '".$clanek_titulek."', text='".$clanek_text."' WHERE parent_id='".$clanek_id_old."' AND lang='".$language."'");
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		$sql_query = ("UPDATE menu_subkategorie_langs SET nazev= '".$clanek_titulek."' WHERE parent_id='".$clanek_id_old."' AND jazyk='".$language."'");
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		header("Location:index.php?action=zobrazit-texty");
	break;
	
	case "home":
		$sql_query = "UPDATE texty SET text='".$clanek_text."' WHERE id='home-page' AND zobrazovat='home'";
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		header("Location:index.php?action=zobrazit-texty");
	break;
}

?>