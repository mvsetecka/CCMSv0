<?php
	require('admin-security.php');
	$this->check_permission('text_edit');
?>

<?php

echo "<h2>Zobrazené publikované texty</h2>";

if ($_SESSION['logged']!==1) header("Location:login.php");

if(empty($_POST['kategorie']) or $_POST['kategorie']=='Všechny')
{
	$sql_query = ("SELECT * FROM texty WHERE (zobrazovat='ano' OR zobrazovat='nmenu') ORDER BY datum desc, cas desc, kategorie");
	$clanky = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
}
elseif($_POST['kategorie']<>NULL)
{
	$item_category = $_POST['kategorie'];
	$sql_query = ("SELECT * FROM texty WHERE kategorie= '".$item_category."' and zobrazovat='ano' ORDER BY datum desc, cas desc, kategorie");
	$clanky = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
}

	$home_page = new db_dotaz("SELECT * FROM texty WHERE id = 'home-page' and zobrazovat='home'");
	$home_page->proved_dotaz();
	$home_page = $home_page->get_vysledek();
	$home_page = $home_page['text'];
	
	echo "<table class='admin_tabulka' cellspacing=1>";
		echo "<thead>";
			echo "<tr>";
			//echo "<td>Kategorie</td>";
			echo "<td>Titulek</td>";
			echo "<td>Èlánek</td>";
			echo "<td>Datum zadání</td>";
			echo "<td>Další</td>";
			echo "<td>Akce</td>";
			echo "</tr>";
		echo "</thead>";
			echo "<tr>";
				echo "<td>Úvodní strana</td>";
				echo "<td>";
					$text = htmlspecialchars($home_page, ENT_IGNORE,"iso-8859-1");
                    echo substr($text, 0, 100);
				echo "</td>";
				echo "<td> - </td>";
				echo "<td>";
					echo "<a href=index.php?action=uprav-text&param1=home-page&lang=EN>EN</a><br />";
					echo "<a href=index.php?action=uprav-text&param1=home-page&lang=DE>DE</a><br />";
					echo "<a href=index.php?action=uprav-text&param1=home-page&lang=DU>DU</a><br />";
				echo "</td>";
				echo "<td>";
					echo "<a href=index.php?action=uprav-text&param1=home-page>Upravit</a><br />";
				echo "</td>";
			echo "</tr>";
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
			echo "</td>";
			echo "<td>";
			echo $clanek["datum"];
			echo "</td>";
			echo "<td>";
			echo "<a href=index.php?action=uprav-text&param1=".$clanek['id']."&lang=EN>EN</a><br />";
			echo "<a href=index.php?action=uprav-text&param1=".$clanek['id']."&lang=DE>DE</a><br />";
			echo "<a href=index.php?action=uprav-text&param1=".$clanek['id']."&lang=DU>DU</a><br />";
			echo "</td>";
			echo "<td>";
			echo "<a href=index.php?action=uprav-text&param1=".$clanek['id'].">Upravit</a><br />";
			echo "<a href='text-delete.php?id=".$clanek['id']."&parent=".$clanek["kategorie"]."' onClick=\"return confirm('Opravdu chcete tento text odstranit?')\">Smazat</a>";
			echo "</td>";
		echo "</tr>";
		endwhile;
	echo "</table>";
	$home_page = NULL;
	echo "<br />";
	echo "<br />";
	
	
	echo "<table class='admin_tabulka' cellspacing=1>";
		echo "<thead>";
			echo "<tr>";
			echo "<td>Popis</td>";
			echo "<td>Text</td>";
			echo "<td>Další</td>";
			echo "<td>Akce</td>";
			echo "</tr>";
		echo "</thead>";
		echo "<tr>";
				echo "<td>Kontaktní informace</td>";
				echo "<td>";
					$text = htmlspecialchars($this->get_others('contact_info_L1'), ENT_IGNORE,"iso-8859-1");
					echo substr($text, 0, 100);
				echo "</td>";
				echo "<td>";
					echo "<a href=index.php?action=kontaktni-informace&lang=EN>EN</a><br />";
					echo "<a href=index.php?action=kontaktni-informace&lang=DE>DE</a><br />";
					echo "<a href=index.php?action=kontaktni-informace&lang=DU>DU</a><br />";
				echo "</td>";
				echo "<td>";
					echo "<a href=index.php?action=kontaktni-informace>Upravit</a><br />";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
?>