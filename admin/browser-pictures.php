<?php
if(isset($_POST['slozka']) && $_POST['slozka']<>"" && $_POST['slozka']<>"..")
{
	$podadresar = $_POST['slozka'];
	$adresar = "../media/images/".$podadresar."thumbs/";
	$top_form = 1;
}
elseif(isset($_POST['slozka'])&&$_POST['slozka']=="..")
{
	$adresar = "../media/images/";
	$top_form = 0;
}
else
{
	$adresar = "../media/images/";
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
		echo "<input type='submit' name='slozka' value='".$slozky."/' style='background-color: White; border: none;' /><br />";
	}
}
echo "</form>";
$stream->close();
echo "<br /><br />";
echo "<table>";
$i = 0;

$stream = dir($adresar);
while ($fotka=$stream->read())
{
	$soubor = $adresar.$fotka;
	if (is_file($soubor))
	{
	 	if($i==0)
		{
			echo "<tr>";
		}
		echo "<td>";
		$i=$i+1;
		$path_parts = pathinfo($soubor);
    	list($width, $height) = getimagesize($soubor);

		/*echo "<a href='$adresar$fotka' onclick='openCEwindow();' target='CE' class='one'><img src='$soubor' width='66' height='50' alt='' class='img' style='margin:0px 0px 0px 0px'></a><br />";

		<img src="<?php echo $soubor ?>" onclick='ulozdata("<?php echo($soubor) ?>");' width='66' height='50' alt='' class='img' style='margin:0px 0px 0px 0px'><br />*/
		//echo $podadresar."<br />".$fotka;	

		$preview_url = $soubor; 
        //echo $preview_url;
		$url = "media/images/".$podadresar."thumbs/".$fotka;
		?>
			
		<img src=<?php echo "'".$soubor."'" ?> onclick="send_picture(<?php echo "'".$url."', '".$preview_url."'" ?>);" width='66' height='50' alt='' class='img' style='margin:0px 0px 0px 0px' /><br />
		
		
		<?php
		$delka_nazvu = strlen($path_parts['filename']);
		if($delka_nazvu>10)
		{
		echo zkratit_nazev_souboru($path_parts['filename']);
		}
		else
		{
			echo $path_parts['filename'];
		}
		echo "<br />";
		echo "<strong>".$path_parts['extension']."</strong><br />";
		echo $width."x".$height."<br /></td>";
		if ($i==10)
		{
			echo "</tr>";
			$i = 0;
		}
	
	}
}
echo "</tr></table>";
$stream->close();

function zkratit_nazev_souboru($xstr)
{
	$texttoshow = chunk_split($xstr,10,"\r\n");
    $texttoshow  = split("\r\n",$texttoshow);
    $texttoshow = $texttoshow[0]."...";
    return $texttoshow;
}

//include("upload-image.php");
?>
