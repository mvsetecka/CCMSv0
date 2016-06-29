<?php
	require('admin-security.php');
	$this->check_permission('news_add');
?>

<?php
echo "<h2>Uložené aktuality</h2>";

	echo "<table class='admin_tabulka'	cellspacing=1>";
	echo "<thead>";
		echo "<tr>";
		echo "<td>ID</td>";
		echo "<td>Datum a Èas</td>";
		echo "<td>Text</td>";
		echo "<td>Akce</td>";
		echo "</tr>";
	echo "</thead>";

	$sql_query = ("SELECT * FROM aktuality WHERE language='cz' ORDER BY id desc");
	$komentare = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		
	while ($subzaznam=mysql_fetch_array($komentare)):
			echo "<tr>";
			echo "<td>".$subzaznam['id']."</td>";
			echo "<td>".date("d-m-Y", $subzaznam['datetime'])."<br />".date("h:m", $subzaznam['datetime'])."</td>";
			echo "<td>".$subzaznam['text']."</td>";
			echo "<td>";
				echo "<a href='news-update-script.php?action=delete&id=".$subzaznam['id']."' onClick=\"return confirm('Opravdu?')\">Smazat</a><br />";
				echo "<a href='index.php?action=upravit-aktualitu&id=".$subzaznam['id']."'>Editovat</a><br />";
			echo "</tr>";
	endwhile;
	
	echo "</table>";
?>