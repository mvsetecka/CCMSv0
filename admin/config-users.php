<?php
	require('admin-security.php');
	$this->check_admin();
	
echo "<h2>Konfigurace - správa uživatelù a práv</h2>";
$dotaz = new db_dotaz("SELECT jmeno_prijmeni, username, last_login FROM uzivatele");
$dotaz->proved_dotaz();
echo "<table class='admin_tabulka' cellspacing=1>";
	echo "<thead>";
		echo "<tr><td>Jméno</td><td>Uživatelské jméno</td><td>Poslední pøihlášení</td><td>Akce</td>";
	echo "</thead>";
	while($zaznam = $dotaz->get_vysledek())
	{
		echo "<tr><td>".$zaznam['jmeno_prijmeni']."</td><td>".$zaznam['username']."</td><td>".date("d.m.Y - H:m",$zaznam['last_login'])."</td>";
		echo "<td>";
			echo "<a href='config-users-delete-script.php'>Smazat</a><br />";
			echo "<a href='index.php?action=add_edit_user&do=edit&uid=".$zaznam['username']."'>Upravit</a>";
		echo "</td>";
	}
echo "</table>";
$dotaz = NULL;
echo "<a href='index.php?action=add_edit_user&do=add'>Pøidat uživatele</a>";
?>