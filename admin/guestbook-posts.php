<?php
	require('admin-security.php');
	$this->check_permission('guestbook_edit');
?>

<?php
/*
$query = new db_dotaz("SELECT * FROM guestbook");
$query->proved_dotaz();

echo "<table rules='all' style='border: 2px black solid;'>\n";
echo "<thead><tr><td>ID</td><td>Datum a èas</td><td>Jméno</td><td>Text pøíspìvku</td><td>Akce</td></tr>";
while($zaznam=$query->get_vysledek()):
	echo"<tr><td>".$zaznam['id']."</td><td>".$zaznam['datum']."<br />".$zaznam['cas']."</td><td>".$zaznam['jmeno']."</td><td>".$zaznam['text']."</td>\n";
	echo "<td>Smazat<br />Editovat</td>\n";
	echo "</tr>\n";
endwhile;
echo "</table>\n";

$query = NULL;
*/

	echo "<h2>Pøíspìvky v návštìvní knize</h2>";

	echo "<form method='POST' action='guestbook-update-script.php'>";
	echo "<table class='admin_tabulka'	cellspacing=1>";
	echo "<thead>";
		echo "<tr>";
		echo "<td>Výbìr</td>";
		echo "<td>ID</td>";
		echo "<td>Datum a Èas</td>";
		echo "<td>Text</td>";
		echo "<td>Autor</td>";
		echo "<td>Akce</td>";
		echo "</tr>";
	echo "</thead>";

	$sql_query = ("SELECT * FROM guestbook ORDER BY id desc");
	$komentare = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		
	while ($subzaznam=mysql_fetch_array($komentare)):
			echo "<tr>";
			echo "<td><input type='checkbox' name='".$subzaznam['id']."' /></td>";
			echo "<td>".$subzaznam['id']."</td>";
			echo "<td>".$subzaznam['datum']."<br />".$subzaznam['cas']."</td>";
			echo "<td>".$subzaznam['text']."</td>";
			echo "<td>".$subzaznam['jmeno']."<br />".$subzaznam['email']."<br />".$subzaznam['web']."<br />".$subzaznam['addr']."</td>";
			echo "<td>";
				echo "<a href='guestbook-update-script.php?action=delete&pid=".$subzaznam['id']."'>Smazat</a><br />";
				echo "<a href='index.php?action=uprav-prispevek&pid=".$subzaznam['id']."'>Editovat</a><br />";
			echo "</tr>";
	endwhile;
	
	echo "</table>";
	echo "<p>Vybrané pøíspìvky:</p>";
	echo "<select name='akce'>";
		echo "<option>Smazat</option>";
	echo "</select>";
	echo "<br />";
	echo "<br />";
	$this->add_submit_button('Provést');
	echo "</form>";
?>

