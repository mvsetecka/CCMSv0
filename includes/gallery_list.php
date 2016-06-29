<?php
	
	include('includes/language.php');
	
	if($this->get_settings('gallery')==1)
	{
	
	$query = new db_dotaz("SELECT * FROM galerie WHERE stav=1 ORDER BY datetime desc");
	$query->proved_dotaz();
	while($zaznam=$query->get_vysledek())
	{
	 	echo "<div class='galerie_list'>";
		echo "<h2 class='galerie-nadpis'><a href='".$this->root."/galerie/".$zaznam['url'].".html'>".$zaznam['nazev']."</a></h2>";
		echo "<h3 class='galerie-nadpis'>".zkratit_text($zaznam['popis'], 50)."</h3>";
		
		switch($zaznam['pocet_obrazu'])
		{
			case "2":
			case "3":
			case "4":
				$words[1] = 'jsou';
				$words[2] = 'fotografie';
			break;
			
			default:
				$words[1] = 'je';
				$words[2] = 'fotografií';
			break;
		}
		
		echo "<table><tr>";
		$pictures = new db_dotaz("SELECT * FROM galerie_obrazky WHERE slozka = '".$zaznam['url']."' ORDER BY soubor asc LIMIT 3");
		$pictures->proved_dotaz();
		while($picture=$pictures->get_vysledek())
		{
			//echo "<td><img src='..\\gallery\\".$picture['slozka']."\\thumbs\\".$picture['soubor']."' /></td>";
			echo "<td><a href='".$this->root."/galerie/".$zaznam['url'].".html'>";
			echo "<img src='".$this->root."/gallery/".$picture['slozka']."/thumbs/".$picture['soubor']."' /></a></td>";
		}
		echo "</tr></table>";
		switch($this->language)
		{
			case "CZ":
				echo "<p class='galerie-nadpis'>V galerii ".$words['1']." <strong>".$zaznam['pocet_obrazu']."</strong> ".$words['2']."</p>";
			break;
			
			default:
				$words = explode(";",$language['fotogalerie_sent1'][$this->language],2);
				echo "<p class='galerie-nadpis'>".$words[0]." <strong>".$zaznam['pocet_obrazu']."</strong> ".$words[1]."</p>";
			break;	
		}
		echo "</div>";
	}
	}
	else
	{
		echo "<strong>".$language['not_found'][$this->language]."</strong>";
	}

function zkratit_text($xstr, $delka)
{
	/*$texttoshow = chunk_split($xstr,$delka,"\r\n");
    $texttoshow  = split("\r\n",$texttoshow);
    $texttoshow = $texttoshow[0]."...";
    return $texttoshow;
    */
    
    return substr($xstr, 0, $delka)."...";
}

?>