<?php

//echo ANKETA."<br />";
//echo $this->anketa_stav."<br />";
//echo $_COOKIE['poll_1']."<br />";

if($this->get_settings('opinion_poll')==1)
{

	$vyber = new db_dotaz("SELECT * FROM anketa WHERE id=1");
	$vyber->proved_dotaz();
	$zaznam = $vyber->get_vysledek();
	$vyber = NULL;
	$pocet_otazek = 5;
	if($zaznam['5_text']=="")$pocet_otazek=4;
	if($zaznam['4_text']=="")$pocet_otazek=3;
	if($zaznam['3_text']=="")$pocet_otazek=2;

	function trojclenka($a,$b,$c)
	{
	return(($a*$b)/$c);
	}

	$pocet_hlasu = $zaznam['1_hlasu']+$zaznam['2_hlasu']+$zaznam['3_hlasu']+$zaznam['4_hlasu']+$zaznam['5_hlasu'];
	if($pocet_hlasu==0)$pocet_hlasu=1;
	$procenta[1] = trojclenka(100, $zaznam['1_hlasu'], $pocet_hlasu);
	$procenta[2] = trojclenka(100, $zaznam['2_hlasu'], $pocet_hlasu);
	if($zaznam['3_text']!=="")$procenta[3] = trojclenka(100, $zaznam['3_hlasu'], $pocet_hlasu);
	if($zaznam['4_text']!=="")$procenta[4] = trojclenka(100, $zaznam['4_hlasu'], $pocet_hlasu);
	if($zaznam['5_text']!=="")$procenta[5] = trojclenka(100, $zaznam['5_hlasu'], $pocet_hlasu);
	$max = max($procenta);
	$pozadovana_sirka = 100;
	if($max==0)$max=$pozadovana_sirka;
    for($i = 1; $i<=$pocet_otazek;$i++)
    {
	   $sirka[$i] = ($procenta[$i]/$max)*$pozadovana_sirka;
	   //$sirka[2] = ($procenta[2]/$max)*$pozadovana_sirka;
	   //$sirka[3] = ($procenta[3]/$max)*$pozadovana_sirka;
	   //$sirka[4] = ($procenta[4]/$max)*$pozadovana_sirka;
	   //$sirka[5] = ($procenta[5]/$max)*$pozadovana_sirka;
    }

	$nazev_ankety  = $zaznam['nazev'];
	//print_r($_COOKIE);

	//Nastavi ? nebo & podle toho, zda se jiz v adrese vyskytuje
	if(preg_match("/[?]/",$_SERVER['REQUEST_URI']))
	{
		$url_symbol = "&";
	}
	else
	{
		$url_symbol = "?";
	}
	?>
	
	<div id='anketa' onmouseover="document.getElementById('anketa').style.borderColor='#286ea0'" onmouseout="document.getElementById('anketa').style.borderColor='#cccccc'">
	
	<?php
	echo "<table class='anketa_tabulka'>";
	echo "<thead><tr><td colspan='2'><p class='anketa_head'>".$zaznam['otazka']."</p></td></tr></thead>";
	if($this->anketa_stav == 1)
	{
		echo "<tr><td>".$zaznam['1_text']."</td></tr>";
	}
	else
	{
			echo "<tr><td><a href='".$_SERVER['REQUEST_URI'].$url_symbol."hlas=1'>".$zaznam['1_text']."</a></td></tr>";	
	}
	echo "<tr><td><img src='".$this->root."/red_pixel.bmp' height='15' width='".$sirka[1]."' alt='' /></td><td>".$zaznam['1_hlasu']."</td></tr>";
	
	if($this->anketa_stav == 1)
	{
		echo "<tr><td>".$zaznam['2_text']."</td></tr>";
	}
	else
	{
		echo "<tr><td><a href='".$_SERVER['REQUEST_URI'].$url_symbol."hlas=2'>".$zaznam['2_text']."</a></td></tr>";
	}
	echo "<tr><td><img src='".$this->root."/red_pixel.bmp' height='15' width='".$sirka[2]."' alt='' /></td><td>".$zaznam['2_hlasu']."</td></tr>";
	
	if($zaznam['3_text']!=="")
	{
		if($this->anketa_stav == 1)
		{
			echo "<tr><td>".$zaznam['3_text']."</td></tr>";
		}
		else
		{
			echo "<tr><td><a href='".$_SERVER['REQUEST_URI'].$url_symbol."hlas=3'>".$zaznam['3_text']."</a></td></tr>";
		}
		echo "<tr><td><img src='".$this->root."/red_pixel.bmp' height='15' width='".$sirka[3]."' alt='' /></td><td>".$zaznam['3_hlasu']."</td></tr>";
	}
	
	if($zaznam['4_text']!=="")
	{
		if($this->anketa_stav == 1)
		{
			echo "<tr><td>".$zaznam['4_text']."</td></tr>";
		}
		else
		{
			echo "<tr><td><a href='".$_SERVER['REQUEST_URI'].$url_symbol."hlas=4'>".$zaznam['4_text']."</a></td></tr>";
		}
		echo "<tr><td><img src='".$this->root."/red_pixel.bmp' height='15' width='".$sirka[4]."' alt='' /></td><td>".$zaznam['4_hlasu']."</td></tr>";
	}

	if($zaznam['5_text']!=="")
	{
		if($this->anketa_stav == 1)
		{
			echo "<tr><td>".$zaznam['5_text']."</td></tr>";
		}
		else
		{
			echo "<tr><td><a href='".$_SERVER['REQUEST_URI'].$url_symbol."hlas=5'>".$zaznam['5_text']."</a></td></tr>";
		}
		echo "<tr><td><img src='".$this->root."/red_pixel.bmp' height='15' width='".$sirka[5]."' alt='' /></td><td>".$zaznam['5_hlasu']."</td></tr>";
	}

	if($this->anketa_stav == 1)
	{
		echo "<tr><td>Z tohoto poèítaèe se dnes již hlasovalo.</td></tr>";
	}

	echo "</table>";
	echo "</div>";
}
?>