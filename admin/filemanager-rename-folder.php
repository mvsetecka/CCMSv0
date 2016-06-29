<?php

include('session.php');
if ($_SESSION['logged']!==1)header("Location:login.php");

	$path = $_GET['path'];
	$name = $_GET['name'];
	$new_name = $_GET['nname'];
	//echo dirname($path)."/<br/>";
	//echo $new_name;
	
	$path_dir = dirname($path)."/";
	
	$source = $path_dir.$name."/";
	$dest = $path_dir.$new_name."/";
	
	if(copyr($source, $dest))
	{
		header("Location: filemanager-delete-folder.php?path=".$source);
	}
	else
	{
		
	}
	
	function copyr($source, $dest)
	{
    // Simple copy for a file
    if (is_file($source)) {
        return copy($source, $dest);
    }
 
    // Make destination directory
    if (!is_dir($dest)) {
        mkdir($dest);
    }
    
    // If the source is a symlink
    if (is_link($source)) {
        $link_dest = readlink($source);
        return symlink($link_dest, $dest);
    }
 
    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }
 
        // Deep copy directories
        if ($dest !== "$source/$entry") {
            copyr("$source/$entry", "$dest/$entry");
        }
    }
 
    // Clean up
    $dir->close();
    return true;
	}
	
	
	/*if(@mkdir($path_dir.$new_name))
	{
		echo "OK";
	}
	else
	{
		echo "Složka s tímto názvem již existuje!";
	}
	
	$dir = dir($source);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }
 
        // Deep copy directories
        if ($dest !== "$source/$entry") {
            copyr("$source/$entry", "$dest/$entry");
        }
    }
 
    // Clean up
    $dir->close();
    return true;
    */
	
?>