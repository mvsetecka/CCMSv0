<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");
    
$akce = $_POST['akce'];
if($akce=="")$akce=$_REQUEST['action'];

switch($akce)
{
	case "add":
		$aktualita['text'] = $_POST['aktualita'];
		$aktualita['timestamp'] = time();
		
		$query = new db_dotaz("SELECT id FROM aktuality ORDER BY id desc LIMIT 1");
		$query->proved_dotaz();
		if($query->pocet_vysledku()>0)
		{
			$aktualita['top_id'] = $query->get_vysledek();
			$aktualita['top_id'] = $aktualita['top_id']['id'];
			$aktualita['top_id']++;
		}
		else
		{
			$aktualita['top_id'] = 1;
		}
		
		$query = NULL;
		
		$sql_query = ("INSERT INTO aktuality VALUES (".$aktualita['top_id'].", ".$aktualita['timestamp'].", '".$aktualita['text']."', 'cz')");
		echo $sql_query;
		
		$query = new db_dotaz($sql_query);
		$query->proved_dotaz();
		$query = NULL;
		//header("Location: index.php?action=zobrazit-aktuality");
	break;
	
	case "delete":
		$id = $_GET['id'];
		$query = new db_dotaz("DELETE FROM aktuality WHERE id=".$id."");
		$query->proved_dotaz();
		$query = NULL;
		header("Location: index.php?action=zobrazit-aktuality");
	break;
	
	case "edit":
		$id = $_POST['id'];
		$text = $_POST['aktualita'];
		
		$query = new db_dotaz("UPDATE aktuality SET text = '".$text."' WHERE id = ".$id." AND language = 'cz'");
		$query->proved_dotaz();
		$query = NULL;
		header("Location: index.php?action=zobrazit-aktuality");
	break;
}

?>