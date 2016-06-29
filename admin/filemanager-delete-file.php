<?php

	include 'session.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");

	$path = $_GET['path'].$_GET['file'];
	//echo $path;
	unlink($path);
	header("Location: index.php?action=spravce-souboru&path=".$_GET['path']);
?>