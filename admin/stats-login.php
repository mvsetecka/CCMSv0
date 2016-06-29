<?php
	require('admin-security.php');
	$this->check_admin();
?>

<?php

echo "<h2>Neúspìšné pokusy o pøihlášení do administrace</h2>";

$query = new db_dotaz("SELECT * FROM stats_login ORDER BY datum desc, cas desc");
$query->proved_dotaz();

echo "<table class='admin_tabulka' cellspacing=1>\n";
echo "<thead style='background-color: Red; color: White;'><tr><td>Datum a èas</td><td>IP Adresa</td><td>Hostname</td><td>Jméno</td><td>Heslo</td></tr></thead>";
while($zaznam=$query->get_vysledek()):
	echo"<tr><td class='center'>".$zaznam['datum']."<br />".$zaznam['cas']."</td><td class='center'>".$zaznam['ip']."</td><td class='center'>".$zaznam['remote_name']."</td><td class='center'>".$zaznam['ent_name']."</td><td class='center'>".$zaznam['ent_pass']."</td>\n";
	echo "</tr>\n";
endwhile;
echo "</table>\n";

$query = NULL;

echo "<a href='stats-login-delete-script.php' onClick=\"return confirm('Opravdu chcete smazat všechny špatné pokusy o pøihlášení do administrace? Tato akce je nevratná!')\" >Vymazat</a></p>";

?>