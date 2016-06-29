<?php
	require('admin-security.php');
	$this->check_permission('article_add');
?>

<?php
	echo "<h2>Uložené nepublikované èlánky</h2>";

	
	$sql_query = ("SELECT * FROM clanky WHERE zobrazovat='ne' ORDER BY datum desc, cas desc, kategorie");
	$clanky = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	
	echo "<table class='admin_tabulka'	cellspacing=1>";
		echo "<thead>";
			echo "<tr>";
			echo "<td>Kategorie</td>";
			echo "<td>Titulek</td>";
			echo "<td>Èlánek</td>";
			echo "<td>Datum zadání</td>";
			echo "<td>Akce</td>";
			echo "</tr>";
		echo "</thead>";
		while ($clanek = mysql_fetch_array($clanky)):
		echo "<tr>";
			echo "<td>";
			echo $clanek["subkategorie"];
			echo "</td>";
			echo "<td>";
			echo $clanek["titulek"];
			echo "</td>";
			echo "<td>";
			echo $clanek["strucne"];
			echo "</td>";
			echo "<td>";
			echo $clanek["datum"];
			echo "</td>";
			echo "<td>";
				echo "<a href=".$GLOBALS['absolute_path_admin']."index.php?action=uprav-clanek&param1=".$clanek['id'].">Upravit</a><br />";
				echo "<a href='".$GLOBALS['absolute_path_admin']."article-delete.php?id=".$clanek['id']."' onClick=\"return confirm('Opravdu chcete odstranit tento èlánek i s komentáøi?')\">Smazat</a>";
			echo "</td>";
		echo "</tr>";
		endwhile;
	echo "</table>";

?>