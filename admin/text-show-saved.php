<?php
	require('admin-security.php');
	$this->check_permission('text_add');
?>

<?php
	
	$sql_query = ("SELECT * FROM texty WHERE zobrazovat='ne' ORDER BY datum desc, cas desc, kategorie");
	$clanky = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	
	echo "<h2>Uložené nepublikované texty</h2>";
		
	echo "<table class='admin_tabulka'	cellspacing=1>";
		echo "<thead>";
			echo "<tr>";
			//echo "<td>Kategorie</td>";
			echo "<td>Titulek</td>";
			echo "<td>Èlánek</td>";
			echo "<td>Datum zadání</td>";
			echo "<td>Akce</td>";
			echo "</tr>";
		echo "</thead>";
		while ($clanek = mysql_fetch_array($clanky)):
		echo "<tr>";
			//echo "<td>";
			//echo $clanek["kategorie"];
			//echo "</td>";
			echo "<td>";
			echo $clanek["titulek"];
			echo "</td>";
			echo "<td>";
            echo "<p>";
            $text = htmlspecialchars($clanek['text'], ENT_IGNORE,"iso-8859-1");
            $text = substr($text, 0, 50)."...";
			echo $text;
            echo "</p>";
			echo "</td>";
			echo "<td>";
			echo $clanek["datum"];
			echo "</td>";
			echo "<td>";
				echo "<a href='index.php?action=uprav-text&param1=".$clanek['id']."'>Upravit</a><br />";
				echo "<a href='text-delete.php?id=".$clanek['id']."&parent=".$clanek["kategorie"]."' onClick=\"return confirm('Opravdu chcete tento text odstranit?')\">Smazat</a>";
			echo "</td>";
		echo "</tr>";
		endwhile;
	echo "</table>";

?>