<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");
	
	$action = $_POST['akce'];
	$type = $_POST['typ'];
	switch($action){
		case "edit";
				$old_id = $_POST['old_id'];
				$old_name = $_POST['old_name'];
				$new_name = $_POST['new_name'];
				$new_id = stranka_admin::friendly_url($new_name);
			switch($type){
				case "main":
					$sql_query = "UPDATE menu_kategorie SET nazev='".$new_name."', URL='".$new_id."' WHERE URL='".$old_id."'";
					$sql_query2 = "UPDATE menu_subkategorie SET parent='".$new_name."', parent_url='".$new_id."' WHERE parent_url='".$old_id."'";
					$sql_query3 = "UPDATE clanky SET kategorie='".$new_name."' WHERE kategorie='".$old_name."'";
					mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
					mysql_query($sql_query2, $GLOBALS['database']) or die(mysql_error());
					mysql_query($sql_query3, $GLOBALS['database']) or die(mysql_error());
					header("Location:index.php?action=show-menu-categories");
				break;
				
				case "sub";
					$new_parent = $_POST['new_parent'];
					$new_parent_id = stranka_admin::friendly_url($new_parent);
					$old_parent = $_POST['old_parent'];
					
					//Overeni, zda kategorie s danym nazven jiz neexistuje
					$dotaz = new db_dotaz("SELECT * FROM menu_subkategorie WHERE url = '".$new_id."'");
					$dotaz->proved_dotaz();
					if($dotaz->pocet_vysledku()>0)
					{
						$dotaz = NULL;
						header("Location:index.php?action=update-menu-categories&param1=zkouska&param2=sub&err=1");
						exit(0);
					}
					$dotaz = NULL;
					//Konec
					
					if($old_parent==$new_parent)
					{
						$sql_query = "UPDATE menu_subkategorie SET nazev='".$new_name."',url='".$new_id."' WHERE url='".$old_id."'";
						mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
						$sql_query = "UPDATE clanky SET subkategorie='".$new_name."' WHERE subkategorie='".$old_name."'";
						mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
						
						$sql_query = "UPDATE menu_subkategorie_langs SET parent_id='".$new_id."' WHERE parent_id='".$old_id."'";
						mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
						
						$sql_query = "UPDATE menu_subkategorie_langs SET nazev='".$new_name."' WHERE nazev='".$old_name."'";
						mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
						
						
						if(isset($_POST['name_en']))
						{
							$name_en = $_POST['name_en'];
							$sql_query = "UPDATE menu_subkategorie_langs SET nazev='".$name_en."' WHERE parent_id='".$new_id."' AND jazyk='EN'";
							mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
						}
						
						if(isset($_POST['name_de']))
						{
							$name_en = $_POST['name_de'];
							$sql_query = "UPDATE menu_subkategorie_langs SET nazev='".$name_de."' WHERE parent_id='".$new_id."' AND jazyk='DE'";
							mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
						}
						
						if(isset($_POST['name_du']))
						{
							$name_en = $_POST['name_en'];
							$sql_query = "UPDATE menu_subkategorie_langs SET nazev='".$name_du."' WHERE parent_id='".$new_id."' AND jazyk='DU'";
							mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
						}
						
					}
					else
					{
						$last_pos = stranka_admin::get_last_subcat_position($new_parent)+1;
						$sql_query = "UPDATE menu_subkategorie SET nazev='".$new_name."',url='".$new_id."',parent='".$new_parent."',parent_url='".$new_parent_id."',pozice='".$last_pos."' WHERE url='".$old_id."'";	
						mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
						stranka_admin::reorder_subcat_positions($old_parent);
						$sql_query = "UPDATE clanky SET subkategorie='".$new_name."', kategorie='".$new_parent."' WHERE subkategorie='".$old_name."'";
						mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
					}
					header("Location:index.php?action=show-menu-categories");
				break;
			}
			
		break;
	}
?>