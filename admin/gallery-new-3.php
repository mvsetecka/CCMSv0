    <?php
	require('admin-security.php');
?>

<?php
	echo "<h2>Vytvoøit novou fotogalerii - Krok 3/3</h2>";
	$galerie['id'] = $_POST['id'];
    
    
    $work_dir = "../gallery/".$galerie['id']."/";
    $path = new DirectoryIterator($work_dir);
    echo "<h4>".$work_dir."</h4>";
    while($path->valid()) {
    if(!$path->isDot()&&!$path->isDir()) {
        //echo $path->current()."<br />";
        $size = round($path->getSize()/1024,0)." kB";
        usleep(100000);
        $time_micro = round(microtime(true)*1000);
        //$query = "INSERT INTO galerie_obrazky VALUES ('".$time_micro."', '".$path->current()."', '".$galerie["id"]."', '', '".$size."', '0', '1')";
		$query = "INSERT INTO galerie_obrazky (soubor, slozka, popis, velikost, zobrazeni, stav) VALUES ('".$path->current()."', '".$galerie["id"]."', '', '".$size."', '0', '1')";
        $sql_query = new db_dotaz($query);
		$sql_query->proved_dotaz();
		$sql_query = NULL;
        echo $path->current()." uloženo v poøádku.<br />";
        echo $time_micro;
    }
    $path->next();
    }
    
    
    
    
	//$galerie['images_uploaded'] = $_POST['images_uploaded'];
	$pictures_count = new db_dotaz("SELECT COUNT(id) AS pocet_obrazku FROM galerie_obrazky WHERE slozka = '".$galerie['id']."'");
	$pictures_count->proved_dotaz();
	$pocet_obrazu = $pictures_count->get_vysledek();
	$pocet_obrazu = $pocet_obrazu['pocet_obrazku'];
	$pictures_count = NULL;
	
	$query = new db_dotaz("UPDATE galerie SET pocet_obrazu = '".$pocet_obrazu."' WHERE url = '".$galerie['id']."'");
	//echo $dotaz = "UPDATE galerie SET pocet_obrazu = '".$pocet_obrazu."' WHERE url = '".$galerie['id']."'";
	$query->proved_dotaz();
	$query = NULL;
	
	echo "<p><strong>Vytvoøení galerie probìhlo v poøádku.</strong></p>";
	echo "<p><a href=index.php?action=zobrazit-galerii&gid=".$galerie['id'].">Pokraèujte zde</a></p>";
	
	
	/*$query = new db_dotaz("SELECT * FROM galerie WHERE url = '".$galerie['id']."' LIMIT 1");
	$query->proved_dotaz();
	$zaznam = $query->get_vysledek();
	$query = NULL;
	
	echo "<p><strong>Název galerie:</strong> ".$zaznam['nazev']."</p>";
	echo "<p><strong>Popis galerie:</strong> ".$zaznam['popis']."<br />";
	echo "<a href='index.php?action=upravit-galerii&w=gal_desc&gid=".$zaznam['url']."'>Upravit...</a></p>";
	echo "<p><strong>Poèet fotografií:</strong> ".$galerie['images_uploaded']."</p>";
	echo "<p><strong>Aktuální stav:</strong> ";
				switch($zaznam['stav'])
				{
					case "0":
						echo "skrytá<br />"; 
					break;
					
					case "1":
						echo "zobrazená<br />";
					break;	
				}
	echo "<a href='index.php?action=upravit-galerii&w=gal_status&gid=".$zaznam['url']."'>Zmìnit stav...</a></p>";
	echo "</p>";
	echo "<p><strong>Poèet zobrazení:</strong> ".$zaznam['zobrazeni']."x</p>";
	echo "<p><strong>Datum vlozeni:</strong> ".date("d. m. Y",$zaznam['datetime'])."</p>";
	
	$query = new db_dotaz("SELECT * FROM galerie_obrazky WHERE slozka = '".$galerie['id']."' ORDER BY id asc");
	$query->proved_dotaz();
	
	$i=0;
	echo "<table>";
	while ($zaznam=$query->get_vysledek()):
		if($i==0)echo "<tr>";
		echo "<td>";
		echo "<img src='../gallery/".$zaznam['slozka']."/thumbs/".$zaznam['soubor']."' /><br />";
		echo $zaznam['popis']."<br />";
		echo "<a href='index.php?action=upravit-galerii&w=img_desc&pid=".$zaznam['soubor']."&gid=".$zaznam['slozka']."'>Upravit popis</a><br />";
		echo "<a href='index.php?action=upravit-galerii&w=del&pid=".$zaznam['soubor']."&gid=".$zaznam['slozka']."'>Smazat</a>";
		echo "</td>";
		$i++;
		if($i==3)$i=0;
		if($i==0)echo "</tr>";
	endwhile;
	*/
	echo "</table>"
    
?>