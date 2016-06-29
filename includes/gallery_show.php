<?php
	include('includes/language.php');	
	if($this->get_settings('gallery_default')=='0')
	{
		$galerie['id'] = $_GET['gallery_id'];
	}
	else
	{
		$galerie['id'] = $this->get_settings('gallery_default'); 
	}
	
	$query = new db_dotaz("SELECT * FROM galerie WHERE url = '".$galerie['id']."' AND stav=1 LIMIT 1");
	$query->proved_dotaz();
	$gal = $query->get_vysledek();
	$query = NULL;
	$galerie['nazev'] = $gal['nazev'];
	$galerie['popis'] = $gal['popis'];
	$galerie['stav'] = $gal['stav'];
	
	if($galerie['stav']==1 && $this->get_settings('gallery')==1)
	{
		if($this->get_settings('gallery_default')=='0')
		{
		echo "<p><a href='".$this->root."/galerie/'>".$language['fotogalerie_back_list'][$this->language]."</a></p>";
		echo "<h2 class='galerie-nadpis'>".$galerie['nazev']."</h2>";
		}
		echo "<h3 class='galerie-nadpis'>".$galerie['popis']."</h3>";
		$query = new db_dotaz("SELECT * FROM galerie_obrazky WHERE slozka = '".$galerie['id']."' ORDER BY ID asc");
		$query->proved_dotaz();
		echo "<div class='galerie_list'>";
		$i=0;
		echo "<table>";
		while ($zaznam=$query->get_vysledek()):
			if($i==0)echo "<tr>";
			echo "<td>";
			//echo "<a href='".$this->root."/galerie/".$zaznam['slozka']."/".$zaznam['soubor']."'><img src='".$this->root."/gallery/".$zaznam['slozka']."/thumbs/".$zaznam['soubor']."' /></a><br />";
			if($zaznam['popis']=='')
			{
				$img_desc = $zaznam['soubor'];	
			}
			else
			{
				$img_desc = $zaznam['popis'];
			}
			echo "<a href='".$this->root."/gallery/".$zaznam['slozka']."/".$zaznam['soubor']."' rel='lightbox[galerie]' title='".$img_desc."'><img src='".$this->root."/gallery/".$zaznam['slozka']."/thumbs/".$zaznam['soubor']."' /></a><br />";
			//echo $zaznam['popis'];
			echo "</td>";
			$i++;
			if($i==3)$i=0;
			if($i==0)echo "</tr>";
		endwhile;
		echo "</table>";
		echo "</div>";
	}
	else
	{
		echo "<strong>".$language['not_found'][$this->language]."</strong>";
	}
?>

