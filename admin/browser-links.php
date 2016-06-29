<?php
	/*
	echo "<h2>Èlánky</h2>";
	//Naète z db èlánky
	$dotaz = new db_dotaz("SELECT titulek,kategorie,subkategorie,id FROM clanky WHERE zobrazovat='ano'");
	$dotaz->proved_dotaz();
	while ($zaznam=$dotaz->get_vysledek()):
		$link = $browser->friendly_url($zaznam['kategorie'])."/".$browser->friendly_url($zaznam['subkategorie'])."/".$zaznam['id'].".html";
		$title = $zaznam['titulek'];
		?>
			<a onclick="send_link(<?php echo "'".$link."','".$title."'" ?>);"><?php echo $title ?></a><br />
		<?php
	endwhile;
	$dotaz = NULL;
	
	echo "<br />";
	*/
	
	//Naète z db texty
	echo "<h2>Texty</h2>";
	$dotaz = new db_dotaz("SELECT id,kategorie_id, titulek FROM texty WHERE (zobrazovat='ano' OR zobrazovat='nmenu')");
	$dotaz->proved_dotaz();
	while ($zaznam=$dotaz->get_vysledek()):
		//$link = $zaznam['kategorie_id']."/".$zaznam['id'].".html";
		$link = $zaznam['id'].".html";
		$title = $zaznam['titulek'];
		?>
			<a onclick="send_link(<?php echo "'".$link."','".$title."'" ?>);"><?php echo $title ?></a><br />	
		<?php
	endwhile;
	$dotaz = NULL;
	
	//Naète galerie
	echo "<h2>Fotogalerie</h2>";
	$dotaz = new db_dotaz("SELECT url, nazev FROM galerie");
	$dotaz->proved_dotaz();
	while ($zaznam=$dotaz->get_vysledek()):
		$link = "galerie/".$zaznam['url'].".html";
		$title = $zaznam['nazev'];
		?>
			<a onclick="send_link(<?php echo "'".$link."','".$title."'" ?>);"><?php echo $title ?></a><br />	
		<?php
	endwhile;
	$dotaz = NULL;
	
	echo "<h2>Soubory</h2>";
	require_once('browser-files.php');
	
	echo "<h2>Obrázky</h2>";
	require_once('browser-pictures-inc.php');
	?>