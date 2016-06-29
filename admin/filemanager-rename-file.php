<?php

	include('session.php');
	if ($_SESSION['logged']!==1)header("Location:login.php");
	
	$path = $_GET['path'];
	
	$old_filename = $_GET['file'];
	$new_filename = $_GET['nname'];
	
	$soubor_s = $path.$old_filename;
    $soubor_n = $path.$new_filename;
    
    if (!File_Exists($soubor_n)):
       if (@Rename($soubor_s, $soubor_n)):
          //$message = "Soubor <i>$oldname</i> byl pøejmenován na <i>$newname</i>!";
          header("Location: index.php?action=spravce-souboru&path=".$_GET['path']."&hlaska=2");
       else:
          //$message = "Soubor <i>$oldname</i> se nepodaøilo pøejmenovat!";
          header("Location: index.php?action=spravce-souboru&path=".$_GET['path']."&hlaska=3");
       endif;    
    else:
       //$message = "Soubor s tímto jménem již existuje!";
       header("Location: index.php?action=spravce-souboru&path=".$_GET['path']."&hlaska=1");
    endif;

?>