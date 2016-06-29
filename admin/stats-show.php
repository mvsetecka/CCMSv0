<?php
	require('admin-security.php');
	$this->check_admin();
?>

<?php
echo "<h2>Statistika pøístupù</h2>";

echo "<p><a href='index.php?action=statistiky'>DNES</a></a>";

if(!isset($_REQUEST['y'])&&!isset($_REQUEST['m']))
{
 	$month = date("m");
 	$year = date("Y");
	echo '<p><img src="stats-show-graph-month.php?m='.$month.'&y='.$year.'" /></p>';
}
else
{
	$month = $_REQUEST['m'];
 	$year = $_REQUEST['y'];
	echo '<p><img src="stats-show-graph-month.php?m='.$month.'&y='.$year.'" /></p>';
}


$pocet_dnu = cal_days_in_month(CAL_GREGORIAN, $month, $year);

echo "Mìsíc:";
for($i = 1; $i <= 12; $i++)
{
	if($i<10)
	{
		$m = "0".$i;
	}
	else
	{
		$m = $i;
	}
	echo "<a href='index.php?action=statistiky&y=".$year."&m=".$m."&d=1'>".$i."</a>";
	if($i<12)
	{
		echo "-";
	}
}

echo "<br />";
echo "Den:";
for($i = 1; $i <= $pocet_dnu; $i++)
{

	echo "<a href='index.php?action=statistiky&y=".$year."&m=".$month."&d=".$i."'>".$i."</a>";
	if($i<>$pocet_dnu)
	{
		echo "-";
	}
}

	echo "<br />";
	echo "<br />";

	if(!isset($_REQUEST['d']))
	{
		$dnes = date("Y-m-d");
		echo "<H4>Dnešní pøístupy - detailnì</H4>";
	}
	else
	{
		$day = $_REQUEST['d'];
		$dnes = $year."-".$month."-".$day;
		echo "<H4>".$day.".".$month.".".$year." - detailnì</H4>";	
	}
	$dotaz = new db_dotaz("SELECT * FROM stats WHERE datum = '".$dnes."' ORDER BY datum, cas desc");
	$dotaz->proved_dotaz();

		echo "<table class='admin_tabulka'	cellspacing=1>";
		echo "<thead><tr><td>Datum</td><td>Èas</td><td>Stránka</td><td>IP</td><td>Hostname</td><td>Referrer</td></tr></thead>";
			while ($zaznam=$dotaz->get_vysledek()):
				echo "<tr><td>".$zaznam['datum']."</td><td>".$zaznam['cas']."</td><td>".$zaznam['pid']."</td><td>".$zaznam['ip']."</td><td>".$zaznam['hostname']."</td><td>".substr($zaznam['referrer'],0,40)."</td></tr>";
			endwhile;
echo "</table>";




?>


