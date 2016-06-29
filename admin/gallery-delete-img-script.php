<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");
	
	$img['gid'] = $_GET['gid'];
	$img['name'] = $_GET['pid'];
	$img['path'] = "../gallery/".$img['gid']."/".$img['name'];
	$img['path_tb'] = "../gallery/".$img['gid']."/thumbs/".$img['name'];
	
	
	//echo $img['path']."<br />";
	//echo $img['path_tb']."<br />";
	unlink($img['path']);
	unlink($img['path_tb']);
	
	$query = new db_dotaz("DELETE FROM galerie_obrazky WHERE slozka = '".$img['gid']."' AND soubor = '".$img['name']."' LIMIT 1");
	$query->proved_dotaz();
	$query = NULL;
	
	$query = new db_dotaz("UPDATE galerie SET pocet_obrazu = pocet_obrazu - 1 WHERE url = '".$img['gid']."' LIMIT 1");
	$query->proved_dotaz();
	$query = NULL;
	
	header("Location:index.php?action=zobrazit-galerii&gid=".$img['gid']);
?>