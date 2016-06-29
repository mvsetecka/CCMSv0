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



echo "V sou�asn� dob� jsou aktuality: ";
	switch ($this->get_settings('news'))
	{
	case "0":
		echo " <strong>zak�z�ny</strong> / <a href='index.php?action=nastaveni-aktualit&stav=1'>Povolit</a>";
	break;
	case "1":
		echo " <strong>povoleny</strong> / <a href='index.php?action=nastaveni-aktualit&stav=0'>Zak�zat</a>";
	break;
	}
echo "<br />";
echo "<br />";
?>
	<form method="POST" action="<?php echo($_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"] ?>">
<?php
	$this->add_text_input('news_count','news_count','Po�et zobrazen�ch novinek v p�ehledu',$this->get_settings('news_count'), 10, 10);
	$this->add_submit_button("Ulo�it");
	echo "</form>";
?>