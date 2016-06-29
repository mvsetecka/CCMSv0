<?php
	require('admin-security.php');
	$this->check_admin();
	
echo "<h2>Konfigurace - spr�va u�ivatel� a pr�v</h2>";
$dotaz = new db_dotaz("SELECT jmeno_prijmeni, username, last_login FROM uzivatele");
$dotaz->proved_dotaz();
echo "<table class='admin_tabulka' cellspacing=1>";
	echo "<thead>";
		echo "<tr><td>Jm�no</td><td>U�ivatelsk� jm�no</td><td>Posledn� p�ihl�en�</td><td>Akce</td>";
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
echo "<a href='index.php?action=add_edit_user&do=add'>P�idat u�ivatele</a>";
?>