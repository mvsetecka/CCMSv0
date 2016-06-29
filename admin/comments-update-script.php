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
	case"Smazat":
		foreach ($_POST as $k => $v)
		{
			$k = explode('@',$k);
				if($k[0]!="akce")
				{
					$item_id = $k[0];
					$comment_id = $k[1];
					$sql_query = "DELETE FROM komentare WHERE comment_id=".$comment_id." AND item_id='".$item_id."'";
					mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
				}
		}
		header("Location:index.php?action=komentare");
	break;
	
	case "Skrýt":
		foreach ($_POST as $k => $v)
		{
			$k = explode('@',$k);
				if($k[0]!="akce")
				{
					$item_id = $k[0];
					$comment_id = $k[1];
					$sql_query = "UPDATE komentare SET zobrazit=0 WHERE comment_id=".$comment_id." AND item_id='".$item_id."'";
					mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
				}
		}
		header("Location:index.php?action=komentare-skryte");
	break;
	
	case "delete":
		$item_id = $_REQUEST['item_id'];
		$comment_id = $_REQUEST['comment_id'];
		$sql_query = "DELETE FROM komentare WHERE comment_id=".$comment_id." AND item_id='".$item_id."'";
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		header("Location:index.php?action=komentare");
	break;
	
	case "hide":
		$item_id = $_REQUEST['item_id'];
		$comment_id = $_REQUEST['comment_id'];
		$sql_query = "UPDATE komentare SET zobrazit=0 WHERE comment_id=".$comment_id." AND item_id='".$item_id."'";
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		header("Location:index.php?action=komentare-skryte");
	break;
	
	case "unhide":
		$item_id = $_REQUEST['item_id'];
		$comment_id = $_REQUEST['comment_id'];
		$sql_query = "UPDATE komentare SET zobrazit=1 WHERE comment_id=".$comment_id." AND item_id='".$item_id."'";
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		header("Location:index.php?action=komentare");
	break;
	
	case "edit":
		$item_id = $_POST['item_id'];
		$comment_id = $_POST['comment_id'];
		$text = $_POST['Komentar'];
		$oznacit = $_POST['oznacit'];
		
		switch ($oznacit)
		{
			case "ne":
				$sql_query = "UPDATE komentare SET text='".$text."' WHERE comment_id=".$comment_id." AND item_id='".$item_id."'";
				mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
				header("Location:index.php?action=komentare");
			break;
			
			case "ano":
				$text = $text."<br /><i>Tento komentáø editoval admin dne ".date(d."-".m."-".Y)."</i>";
				$sql_query = "UPDATE komentare SET text='".$text."' WHERE comment_id=".$comment_id." AND item_id='".$item_id."'";
				mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
				header("Location:index.php?action=komentare");
			break;
		}
		
	break;
}
?>