<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");
	
	$gal['gid'] = $_GET['gid'];
	$gal['path'] = "../gallery/".$gal['gid']."/";
	$gal['path_tb'] = "../gallery/".$gal['gid']."/thumbs/";

	$abcd = "SELECT * FROM galerie_obrazky WHERE slozka = '".$gal['gid']."'";
	$query = new db_dotaz($abcd);
	$query->proved_dotaz();
	while($zaznam=$query->get_vysledek())
	{
		$img['path'] = $gal['path'].$zaznam['soubor'];
		$img['path_tb'] = $gal['path_tb'].$zaznam['soubor'];
		unlink($img['path']);
		unlink($img['path_tb']);		
	}
	$query = NULL;

	$query = new db_dotaz("DELETE FROM galerie_obrazky WHERE slozka = '".$gal['gid']."'");
	$query->proved_dotaz();
	$query = NULL;
	
	$query = new db_dotaz("DELETE FROM galerie WHERE url = '".$gal['gid']."'");
	$query->proved_dotaz();
	$query = NULL;
	
	rmdir($gal['path_tb']);
	rmdir($gal['path']);
	
	header("Location:index.php?action=galerie");
?>