<?php
	require('admin-security.php');
	$this->check_permission('news_add');
?>

<?php

echo "<h2>Konfigurace aktualit</h2>";

if(isset($_GET['stav']))
	{
		switch ($_GET['stav'])
		{
			case "0":
				$this->set_settings('news', 0);
			break;
			case "1";
				$this->set_settings('news', 1);
			break;
		}
	}
	
if(!empty($_POST))
{
	if(isset($_POST['news_count']))
	{
		$this->set_settings('news_count', $_POST['news_count']);
	}
}



echo "V souèasné dobì jsou aktuality: ";
	switch ($this->get_settings('news'))
	{
	case "0":
		echo " <strong>zakázány</strong> / <a href='index.php?action=nastaveni-aktualit&stav=1'>Povolit</a>";
	break;
	case "1":
		echo " <strong>povoleny</strong> / <a href='index.php?action=nastaveni-aktualit&stav=0'>Zakázat</a>";
	break;
	}
echo "<br />";
echo "<br />";
?>
	<form method="POST" action="<?php echo($_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"] ?>">
<?php
	$this->add_text_input('news_count','news_count','Poèet zobrazených novinek v pøehledu',$this->get_settings('news_count'), 10, 10);
	$this->add_submit_button("Uložit");
	echo "</form>";
?>