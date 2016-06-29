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
		 	if($k!="akce")
				{
					$pid = $k;
					$sql_query = "DELETE FROM guestbook WHERE id=".$pid."";
					mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
				}
		}
		header("Location:index.php?action=gb-prispevky");
	break;
	
	case "delete":
		$pid = $_REQUEST['pid'];
		$sql_query = "DELETE FROM guestbook WHERE id=".$pid."";
		mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		header("Location:index.php?action=gb-prispevky");
	break;
	
	case "edit":
		$pid = $_POST['pid'];
		$text = $_POST['Komentar'];
		$oznacit = $_POST['oznacit'];
		
		switch ($oznacit)
		{
			case "ne":
				$sql_query = "UPDATE guestbook SET text='".$text."' WHERE id=".$pid."";
				mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
				header("Location:index.php?action=gb-prispevky");
			break;
			
			case "ano":
				$text = $text."<br /><i>Tento pøíspìvek editoval admin dne ".date(d."-".m."-".Y)."</i>";
				$sql_query = "UPDATE guestbook SET text='".$text."' WHERE id=".$pid."";
				mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
				header("Location:index.php?action=gb-prispevky");
			break;
		}
		
	break;
}
?>