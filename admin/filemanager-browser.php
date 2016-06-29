
<script language="Javascript">
	function DeleteFile(soubor,cesta)
	{
  		smazat = window.confirm("Opravdu chcete smazat soubor "+soubor+"?"); 
  		if (smazat)
  		{
    		location.href="filemanager-delete-file.php?path="+cesta+"&file="+soubor;
  		}
	}
	
	function RenameFile(soubor,cesta)
	{
  		new_name = window.prompt('Pøejmenování souboru '+soubor+'!', soubor);
  		if (new_name!=null)
  		{
    		location.href="filemanager-rename-file.php?path="+cesta+"&file="+soubor+"&nname="+new_name;
  		}
	}
	
	function DeleteFolder(cesta, nazev)
	{
  		smazat = window.confirm("Opravdu chcete smazat slozku "+nazev+" vèetnì všech souborù? Tato operace je nevratná!"); 
  		if (smazat)
  		{
    		location.href="filemanager-delete-folder.php?path="+cesta;
  		}
	}
	
	function RenameFolder(cesta, nazev)
	{
  		new_name = window.prompt('Pøejmenování složky '+nazev+'!', nazev); 
  		if (new_name!=null)
  		{
    		location.href="filemanager-rename-folder.php?path="+cesta+"&name="+nazev+"&nname="+new_name;
  		}
	}
	
	
</script>

<?php
require('admin-security.php');
$this->check_permission('filemanager');

require_once('./../includes/function.dirsize.php');
require_once('./../includes/function.nice_size.php');

//definice hlášek
$filemanager_text[1] = "Soubor s tímto jménem již existuje!";
$filemanager_text[2] = "Soubor byl úspìšnì pøejmìnován!";
$filemanager_text[3] = "Soubor se nepodaøilo pøejmenovat!";

echo "<h2>Správce souborù</h2>";

if(isset($_GET['hlaska']))
{
	$message_id = $_GET['hlaska'];
	echo "<h3 style='color: Red;'>".$filemanager_text[$message_id]."</h3>";
}


$root_dir = "../media/";

if(isset($_POST['make_dir_sent']) && $_POST['make_dir_sent']==1)
{
 	$new_dir_name = $_POST['make_dir_name'];
 	$path = $_POST['make_dir_path'];
 	$new_dir_path =  $path.$new_dir_name."/";
	mkdir($new_dir_path, 0700);

	if(preg_match('^../media/images^',$path))
	{
		mkdir($new_dir_path."thumbs/", 0700);
	}

}


if(isset($_POST['file_sent']) && $_POST['file_sent']==1)
{
 	$upl_path = $_POST['upload_path'];
	//echo $upl_path;
	if(is_file($_FILES['soubor_1']['tmp_name']))$path_1 = ($upl_path . $_FILES['soubor_1']['name']);
	if(move_uploaded_file($_FILES['soubor_1']['tmp_name'], "$path_1"))echo("Soubor 1 - ".$_FILES['soubor_1']['name']." - ".($_FILES['soubor_1']['size']/1000)." kB - <strong>OK</strong><br />");else echo ("Chyba<br />");
	$work_dir = $upl_path;
}
elseif(isset($_POST['slozka']) && $_POST['slozka']<>"")
{
 	
 	$sub_dir = $_POST['slozka'];
	$parent_dir = $_POST['parent'][$sub_dir];
	switch($parent_dir)
	{
		case "none":
			$work_dir = $root_dir.$sub_dir."/";
		break;
		
		default:
			$work_dir = $root_dir.$parent_dir."/".$sub_dir."/";
		break;
	}
	//echo $work_dir;
}
elseif(isset($_GET['path']))
{
	$work_dir = $_GET['path'];
	$parent_dir = "return";
}
elseif(isset($_POST['path_return']))
{
	$work_dir = $_POST['path_return'];
	$parent_dir = "return";
}
else
{
	$work_dir = $root_dir;
}

//$work_dir = "../media/images/Mythbusters/";

$path = new DirectoryIterator($root_dir);
echo "<h4>".$work_dir."</h4>";

echo "<div>";
echo "<form method='POST' action='".$_SERVER["PHP_SELF"]."?action=spravce-souboru' >";

echo "<table>";
while($path->valid()) {
    if($path->isDir() && !$path->isDot()) {
    		echo "<tr>";
    		echo "<td>";
			echo "<img src='CSS/folder_up.png' />";
    		echo "<input type='submit' name='slozka' value='".$path->current()."' style='background-color: White; border: none; text-align: left; font-weight: bolder;' /><br />";
			echo "<input type='hidden' name='parent[".$path->current()."]' value='none' />";
			echo "</td>";
    		echo "</tr>";
		$sub = $path->getPath()."/".$path->current();
    	
    	$subpath = new DirectoryIterator($sub);
    		while($subpath->valid())
    		{
				if($subpath->isDir() && !$subpath->isDot())
				{
				 	$spath = $subpath->getPath()."/".$subpath->current();
				 	echo "<tr>";
				 	echo "<td>";
					echo "<img src='CSS/folder_open.png' style='margin-left:15px;' />";
					echo "<input type='submit' name='slozka' value='".$subpath->current()."' style='background-color: White; border: none; text-align: left;' />";
					echo "<input type='hidden' name='parent[".$subpath->current()."]' value='".$path->current()."' />";
					echo "</td><td>";
					echo "(".pocet($spath).")";
					echo "</td><td>";
					echo size_readable(dirsize($sub."/".$subpath->current()));
					echo "</td><td>";
					echo "<img src='CSS/kosik_del.gif' title='Smazat' alt='Smazat' onclick=\"javascript: DeleteFolder('".$sub."/".$subpath->current()."/','".$subpath->current()."')\" />";
					echo "</td><td>";
					echo "<img src='CSS/rename.png' title='Pøejmenovat' alt='Pøejmenovat' onclick=\"javascript: RenameFolder('".$sub."/".$subpath->current()."/','".$subpath->current()."')\" />";
					echo "</td></tr>";
				}
				$subpath->next();
			}
    	$subpath = NULL;
    }
    $path->next();
}
$path = NULL;
echo "</table>";
echo "</form>";
echo "</div>";


echo "<div>";
echo "<table>";
$path = new DirectoryIterator($work_dir);
while($path->valid()) {
	echo "<tr>";
    if(!$path->isDot()&&!$path->isDir()) {
        echo "<td>".$path->current()."</td>";
        $size = round($path->getSize()/1024,0)." kB";
		echo "<td>".$size."</td>";
        echo "<td><img src='CSS/kosik_del.gif' title='Smazat' alt='Smazat' onclick=\"javascript: DeleteFile('".$path->current()."','".$work_dir."')\" /></td>";
		echo "<td><img src='CSS/preview.png' title='Náhled' alt='Náhled' style='border:none;' onclick=\"window.open('".$work_dir.$path->current()."')\" /></td>";
		echo "<td><img src='CSS/rename.png' title='Pøejmenovat' alt='Pøejmenovat' style='border:none;' onclick=\"javascript: RenameFile('".$path->current()."','".$work_dir."')\" /></td>";
    }
    $path->next();
    echo "</tr>";
}
echo "</table>";
echo "</div>";


echo "<br />";
$path = NULL;

	/*
	echo "<form method='POST' enctype='multipart/form-data' action='".$_SERVER["PHP_SELF"]."?".$_SERVER['QUERY_STRING']."' >";
	echo "<input type='file' name='soubor_1' accept='*' size='40' />";
	echo "<input type='hidden' name='upload_path' value='".$work_dir."' />";
	echo "<input type='hidden' name='file_sent' value='1'>";
	echo "<input type='submit' value='Nahrát' />";
	echo "</form>";
	*/
//echo $_POST['slozka'];

if(isset($parent_dir) && $parent_dir=="none")
{
	echo "<form method='POST' action='".$_SERVER["PHP_SELF"]."?".$_SERVER['QUERY_STRING']."' >";
	echo "<input type='text' name='make_dir_name' value=''>";
	echo "<input type='submit' value='Vytvoøit podsložku' />";
	echo "<input type='hidden' name='make_dir_sent' value='1'>";
	echo "<input type='hidden' name='make_dir_path' value='".$work_dir."'>";
	echo "</form>";
}

//echo "<h1>".$parent_dir."</h1>";

if(isset($parent_dir) && $parent_dir!=="none")
{
	echo "<form method='POST' action='".$_SERVER["PHP_SELF"]."?".$_SERVER['QUERY_STRING']."' >";
	echo "<input type='submit' value='Nahrát soubory do složky' />";
	echo "<input type='hidden' name='upload_files' value='flexupload' />";
	echo "<input type='hidden' name='upload_path' value='".$work_dir."' />";
	echo "</form>";
}

function pocet($addr){
	$gallery = opendir($addr);
	$counter = 0;
	while($file = readdir($gallery)){
   	if($file != '.' && $file != '..' && $file != 'thumbs'){
   	   $counter++;
   	}
	}
	closedir($gallery);
	return($counter);
}

?>