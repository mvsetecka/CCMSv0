<?php
	require('admin-security.php');
	$this->check_permission('comments_edit');
?>

<?php

	echo "<h2>Komentáøe k èlánkùm - skryté správcem</h2>";
	
	echo "<form method='POST' action='comments-update-script.php'>";
	echo "<table class='admin_tabulka'	cellspacing=1>";
	echo "<thead>";
		echo "<tr>";
		echo "<td>Výbìr</td>";
		echo "<td>Èlánek</td>";
		echo "<td>Èas</td>";
		echo "<td>Komentáø</td>";
		echo "<td>Autor</td>";
		echo "<td>Akce</td>";
		echo "</tr>";
	echo "</thead>";

	$sql_query = ("SELECT * FROM komentare WHERE zobrazit=0 ORDER BY datum desc, cas desc");
	$komentare = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		
	while ($subzaznam=mysql_fetch_array($komentare)):
			echo "<tr>";
			echo "<td><input type='checkbox' name='".$subzaznam['item_id']."@".$subzaznam['comment_id']."' /></td>";
			echo "<td>".$subzaznam['item_id']."</td>";
			echo "<td>".$subzaznam['datum']."<br />".$subzaznam['cas']."</td>";
			echo "<td>".$subzaznam['text']."</td>";
			echo "<td>".$subzaznam['autor_nick']."<br />".$subzaznam['autor_email']."<br />".$subzaznam['autor_ip']."</td>";
			echo "<td>";
				echo "<a href='comments-update-script.php?action=delete&item_id=".$subzaznam['item_id']."&comment_id=".$subzaznam['comment_id']."'>Smazat</a><br />";
				echo "<a href='comments-update-script.php?action=unhide&item_id=".$subzaznam['item_id']."&comment_id=".$subzaznam['comment_id']."'>Obnovit</a><br />";
				echo "<a href='index.php?action=uprav-komentar&article_id=".$subzaznam['item_id']."&comm_id=".$subzaznam['comment_id']."'>Editovat</a><br />";
			echo "</tr>";
	endwhile;
	
	echo "</table>";
	echo "<p>Vybrané komentáøe:</p>";
	echo "<select name='akce'>";
		echo "<option>Smazat</option>";
	echo "</select>";
	echo "<br />";
	echo "<br />";
	$this->add_submit_button('Provést');
	echo "</form>";
?>