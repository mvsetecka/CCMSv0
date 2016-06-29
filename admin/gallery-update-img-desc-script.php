<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");
	
	$gid = $_POST['gid'];
	$pid = $_POST['pid'];
	$text = $_POST['img_desc'];
	$text = htmlspecialchars($text);
	$query = new db_dotaz("UPDATE galerie_obrazky SET popis = '".$text."' WHERE slozka = '".$gid."' AND soubor = '".$pid."' LIMIT 1");
	$query->proved_dotaz();
	$query = NULL;
	header("Location:index.php?action=zobrazit-galerii&gid=".$gid);

?>