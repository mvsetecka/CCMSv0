<?php
	require('admin-security.php');
	$this->check_permission('article_edit');
?>


<h2>Zobrazen� publikovan� �l�nky</h2>
<p>Kategorie:</p>
<form method="POST" action="<?php echo($_SERVER["PHP_SELF"])."?".$_SERVER['QUERY_STRING'] ?>">
		<select name="kategorie">
		<?php
		$sql_query = ("SELECT * FROM menu_subkategorie WHERE typ = 'list'");
		echo "<option>V�echny</option>";
		$subkategorie = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
					while ($subzaznam=mysql_fetch_array($subkategorie)):
						$checked="";
						if ($subzaznam['nazev']==$_POST['kategorie'])$checked=" selected";
						echo "<option".$checked.">".$subzaznam['nazev']."</option>";
					endwhile;
		?>
		</select>
		<input type="submit" value="Vybrat">
</form>
<br />
<?php

if(empty($_POST['kategorie']) or $_POST['kategorie']=='V�echny')
{
	$sql_query = ("SELECT * FROM clanky WHERE zobrazovat='ano' ORDER BY datum desc, cas desc, kategorie");
	$clanky = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
}
elseif($_POST['kategorie']<>NULL)
{
	$item_category = $_POST['kategorie'];
	$sql_query = ("SELECT * FROM clanky WHERE subkategorie= '".$item_category."' and zobrazovat='ano' ORDER BY datum desc, cas desc, kategorie");
	$clanky = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
}
	
	echo "<table class='admin_tabulka' cellspacing=1>";
		echo "<thead>";
			echo "<tr>";
			echo "<td>Kategorie</td>";
			echo "<td>Titulek</td>";
			echo "<td>�l�nek</td>";
			echo "<td>Datum zad�n�</td>";
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
			echo substr(htmlspecialchars($clanek['strucne'], ENT_IGNORE,"iso-8859-1"), 0, 200);
			echo "</td>";
			echo "<td>";
			echo $clanek["datum"];
			echo "</td>";
			echo "<td>";
			echo "<a href='index.php?action=uprav-clanek&param1=".$clanek['id']."'>Upravit</a><br />";
			echo "<a href='article-delete.php?id=".$clanek['id']."' onClick=\"return confirm('Opravdu chcete odstranit tento �l�nek i s koment��i?')\">Smazat</a>";
			echo "</td>";
		echo "</tr>";
		endwhile;
	echo "</table>";
?>