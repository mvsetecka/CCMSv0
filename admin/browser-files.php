<?php
if(isset($_POST['slozka']) && $_POST['slozka']<>"" && $_POST['slozka']<>"..")
{
	$podadresar = $_POST['slozka'];
	$adresar = "../media/files/".$podadresar;
	$top_form = 1;
}
elseif(isset($_POST['slozka']) && $_POST['slozka']=="..")
{
	$adresar = "../media/files/";
	$top_form = 0;
}
else
{
	$adresar = "../media/files/";
	$top_form = 0;
}
echo "<strong>".$adresar."</strong><br />";

if($top_form == 1)
{
	echo "<form method='POST' action='".$_SERVER["PHP_SELF"]."?".$_SERVER['QUERY_STRING']."'>";
	echo "<input type='submit' name='slozka' value='..'>";
	echo "</form>";
}
$stream = dir($adresar);
echo "<form method='POST' action='".$_SERVER["PHP_SELF"]."?".$_SERVER['QUERY_STRING']."'>";
while($slozky=$stream->read())
{
 	$soubor = $adresar.$slozky;
	if(is_dir($soubor)&&$slozky!="."&&$slozky!="..")
	{
		//echo $slozky."<br />";
		echo "<input type='submit' name='slozka' value='".$slozky."/' style='background-color: White; border: none; text-align:left;' /><br />";
	}
}
echo "</form>";
$stream->close();
echo "<br />";
//echo "<table>";
$stream = dir($adresar);
while ($fotka=$stream->read())
{
	$soubor = $adresar.$fotka;
	if (is_file($soubor))
	{
	 	//echo $soubor."<br />";
	 	$path_parts = pathinfo($soubor);
	 	
	 	//echo $path_parts['filename'].".".$path_parts['extension'];
	 	$file_full_path = $soubor;
	 	//echo "<br />";
	 	//echo $file_full_path;
	 	$search = "../";
	 	$replace = "";
	 	$relative_path = str_replace($search,$replace,$soubor);
	 	//echo "<strong>".$relative_path."</strong>";
		?>
	 	
	 	<a onclick="send_link(<?php echo "'".$relative_path."'"; ?>, '');"><?php echo $path_parts['filename'].".".$path_parts['extension']; ?></a><br />
	 	<?php
	 	echo "<br />";
	}
}
//echo "</tr></table>";
$stream->close();


?>
