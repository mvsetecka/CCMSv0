<?php
	require('admin-security.php');
	$this->check_permission('opinion_poll');
?>

<?php
echo "<h2>Konfigurace ankety</h2>";

if(!empty($_POST))
{
	$datum = date("d.m.Y - H:i"); 
	$sql_query = "UPDATE anketa SET nazev = '".$_POST['nazev']."', otazka = '".$_POST['otazka']."', 1_text = '".$_POST['moznost_1']."', 1_hlasu=0, 2_text = '".$_POST['moznost_2']."', 2_hlasu=0, 3_text = '".$_POST['moznost_3']."', 3_hlasu=0, 4_text = '".$_POST['moznost_4']."', 4_hlasu=0, 5_text = '".$_POST['moznost_5']."', 5_hlasu=0, datum = '".$datum."' WHERE id=1";
	mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	$sql_query;
}

if(isset($_GET['stav']))
{
	switch ($_GET['stav'])
	{
	case "0":
		$this->set_settings('opinion_poll', 0);
	break;
	case "1";
		$this->set_settings('opinion_poll', 1);
	break;
	}
}

echo "V souèasné dobì je anketa";
	switch ($this->get_settings('opinion_poll'))
	{
	case "0":
		echo " <strong>zakázána</strong> / <a href='index.php?action=ankety&stav=1'>Povolit</a>";
	break;
	case "1":
		echo " <strong>povolena</strong> / <a href='index.php?action=ankety&stav=0'>Zakázat</a>";
	break;
	}
echo "<br />";
?>
<form method="POST" action="<?php echo($_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"] ?>">
<?php
$vyber = new db_dotaz("SELECT * FROM anketa WHERE id=1");
$vyber->proved_dotaz();
$zaznam = $vyber->get_vysledek();
$vyber = NULL;
echo "Anketa v souèasné podobì bìží od: <strong>".$zaznam['datum']." hod</strong>";
echo "<br />";
echo "<br />";
$this->add_text_input('nazev','nazev','Název ankety',$zaznam['nazev'], 50, 50);
$this->add_text_input('otazka','otazka','Otázka',$zaznam['otazka'], 50, 100);
$this->add_text_input('moznost_1','moznost_1','1',$zaznam['1_text'], 50, 100);
$this->add_text_input('moznost_2','moznost_2','2',$zaznam['2_text'], 50, 100);
$this->add_text_input('moznost_3','moznost_3','3',$zaznam['3_text'], 50, 100);
$this->add_text_input('moznost_4','moznost_4','4',$zaznam['4_text'], 50, 100);
$this->add_text_input('moznost_5','moznost_5','5',$zaznam['5_text'], 50, 100); 
$this->add_submit_button('Uložit zmìny');
?>
</form>