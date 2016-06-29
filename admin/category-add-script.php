<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");;
	
	$type = $_POST['type'];
	if(!isset($_POST['type']))
	{
		$type = $_GET['type'];
	}
	$name = $_POST['name'];
	$parent = $_POST['parent'];
	switch($type)
	{	
		case "sub":
			$id = stranka_admin::friendly_url($name);
			$parent_id = "simple";
			$parent = "simple";
			
			//overeni, zda kategorie s danym nazven jiz neexistuje
			$dotaz = new db_dotaz("SELECT * FROM menu_subkategorie WHERE url = '".$id."'");
			$dotaz->proved_dotaz();
			if($dotaz->pocet_vysledku()>0)
			{
				$dotaz = NULL;
				header("Location:index.php?action=pridat-kategorii&param=sub&err=1");
				exit(0);
			}
			$dotaz = NULL;
			
			$last_id = stranka_admin::get_last_subcat_position($parent_id) + 1;
			$sql_query = "INSERT INTO menu_subkategorie VALUES ('".$parent."', '".$parent_id."', '".$name."','".$id."','list','ano',".$last_id.")";
			//echo $sql_query."<br />";
			mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			if($_POST['name_de']!="")
			{
				$name_de = $_POST['name_de'];	
			}
			else
			{
				$name_de = $name;
			}
			
			if($_POST['name_en']!="")
			{
				$name_en = $_POST['name_en'];	
			}
			else
			{
				$name_en = $name;
			}
			
			if($_POST['name_du']!="")
			{
				$name_du = $_POST['name_du'];	
			}
			else
			{
				$name_du = $name;
			}
			$sql_query=("INSERT INTO menu_subkategorie_langs VALUES('".$id."', '','".$name_en."','EN')");
			mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			//echo $sql_query."<br />";
			$sql_query=("INSERT INTO menu_subkategorie_langs VALUES('".$id."', '','".$name_de."','DE')");
			//echo $sql_query."<br />";
			mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			$sql_query=("INSERT INTO menu_subkategorie_langs VALUES('".$id."', '','".$name_du."','DU')");
			//echo $sql_query."<br />";
			mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			
			header("Location:index.php?action=show-menu-categories");
		break;
		
		case "separator":
			$last_id = stranka_admin::get_last_subcat_position('simple') + 1;
			$last_separator = stranka_admin::get_settings('menu_separator') + 1;
			$sql_query = "INSERT INTO menu_subkategorie VALUES ('simple', 'simple', '---separator---','separator".$last_separator."','separator','ano',".$last_id.")";
			mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			stranka_admin::set_settings('menu_separator', $last_separator);
			header("Location:index.php?action=show-menu-categories");
		break;	
	}


?>