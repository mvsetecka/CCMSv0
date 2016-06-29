<?php
	require('admin-security.php');
	$this->check_permission('photogallery_edit');
?>

<?php

$gid = $_GET['gid'];

	$query = new db_dotaz("SELECT * FROM galerie WHERE url = '".$gid."' LIMIT 1");
	$query->proved_dotaz();
	$zaznam = $query->get_vysledek();
	$query = NULL;
	echo "<h2>Detaily fotogalerie</h2>";
	
	echo "<p><strong>N�zev galerie:</strong> ".$zaznam['nazev']."</p>";
	echo "<p><strong>Popis galerie:</strong> ".htmlspecialchars($zaznam['popis'], ENT_QUOTES|ENT_SUBSTITUTE, 'cp1251')."<br />";
	//echo "<p><strong>Popis galerie:</strong> ".$zaznam['popis']."<br />";
    echo "<a href='index.php?action=upravit-galerii&w=gal_desc&gid=".$zaznam['url']."'>Upravit...</a></p>";
	echo "<p><strong>Po�et fotografi�:</strong> ".$zaznam['pocet_obrazu']."</p>";
	echo "<p><strong>Aktu�ln� stav:</strong> ";
				switch($zaznam['stav'])
				{
					case "0":
						echo "skryt�<br />"; 
						echo "<a href='gallery-update-status-script.php?gid=".$zaznam['url']."&s=1'>Zobrazit...</a></p>";
					break;
					
					case "1":
						echo "zobrazen�<br />";
						echo "<a href='gallery-update-status-script.php?gid=".$zaznam['url']."&s=0'>Skr�t...</a></p>";
					break;	
				}
	echo "</p>";
	echo "<p><strong>Po�et zobrazen�:</strong> ".$zaznam['zobrazeni']."x</p>";
	echo "<p><strong>Datum vlozeni:</strong> ".date("d. m. Y",$zaznam['datetime'])."</p>";
	echo "<p><a href='gallery-delete-script.php?gid=".$zaznam['url']."' onClick=\"return confirm('Opravdu chcete smazat celou galerii? Tato akce je nevratn�!')\">Smazat celou galerii</a></p>";
	echo "<p><a href='index.php?action=upravit-galerii&w=add_img&gid=".$gid."'>P�idat dal�� fotografie</a></p>";
	
	$query = new db_dotaz("SELECT * FROM galerie_obrazky WHERE slozka = '".$gid."' ORDER BY id asc");
	$query->proved_dotaz();
	//echo $query->pocet_vysledku();
	
	$i=0;
	/*/
	echo "<table>";
	while ($zaznam=$query->get_vysledek()):
		if($i==0)echo "<tr>";
		echo "<td>";
		echo "<img src='../gallery/".$zaznam['slozka']."/thumbs/".$zaznam['soubor']."' /><br />";
		echo $zaznam['popis']."<br />";
		echo "<a href='index.php?action=upravit-galerii&w=img_desc&pid=".$zaznam['soubor']."&gid=".$zaznam['slozka']."'>Upravit popis</a><br />";
		echo "<a href='gallery-delete-img-script.php?pid=".$zaznam['soubor']."&gid=".$zaznam['slozka']."' onClick=\"return confirm('Opravdu chcete smazat tuto fotografii? Tato akce je nevratn�!')\>Smazat</a>";
		echo "</td>";
		$i++;
		if($i==3)$i=0;
		if($i==0)echo "</tr>";
	endwhile;
	echo "</table>";
	*/
	
	//echo "<div id='galerie_list'>";
	$i=0;
	echo "<table class='gallery'>";
	while ($zaznam=$query->get_vysledek()):
		if($i==0)echo "<tr>";
		echo "<td>";
		echo "<img class='gallery_thumb' src='../gallery/".$zaznam['slozka']."/thumbs/".$zaznam['soubor']."' /><br />";
		echo $zaznam['popis']."<br />";
		echo "<a href='index.php?action=upravit-galerii&w=img_desc&pid=".$zaznam['soubor']."&gid=".$zaznam['slozka']."'>Upravit popis</a><br />";
		echo "<a href='gallery-delete-img-script.php?pid=".$zaznam['soubor']."&gid=".$zaznam['slozka']."' onClick=\"return confirm('Opravdu chcete smazat tuto fotografii? Tato akce je nevratn�!')\" >Smazat</a>";
		echo "</td>";
		$i++;
		if($i==3)$i=0;
		if($i==0)echo "</tr>";
	endwhile;
	echo "</table>";
	//echo "</div>";
	
?>