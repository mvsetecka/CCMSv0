<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");
	
	
	$gid = $_POST['gid'];
	$text = $_POST['gal_desc'];
	//$text = htmlspecialchars($text,ENT_QUOTES|ENT_SUBSTITUTE);
	$query = new db_dotaz("UPDATE galerie SET popis = '".$text."' WHERE url = '".$gid."' LIMIT 1");
	$query->proved_dotaz();
	$query = NULL;
	header("Location:index.php?action=zobrazit-galerii&gid=".$gid);	
?>